<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LibraryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_catalogue_and_catalogue_lists_books(): void
    {
        $book = Book::factory()->create([
            'title' => 'A Practical Laravel Guide',
        ]);

        $this->get('/')->assertRedirect(route('books.index'));
        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('A Practical Laravel Guide')
            ->assertSee($book->author->name)
            ->assertSee('Available');
    }

    public function test_catalogue_marks_a_book_with_an_active_loan_as_on_loan(): void
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();
        $book->members()->attach($member->id, ['borrowed_at' => now(), 'returned_at' => null]);

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('On loan');
    }

    public function test_seeder_creates_the_requested_library_sample(): void
    {
        $this->seed();

        $this->assertDatabaseCount('authors', 10);
        $this->assertDatabaseCount('books', 40);
        $this->assertDatabaseCount('members', 30);
        $this->assertGreaterThan(0, DB::table('book_member')->count());
        $activeLoanCount = DB::table('book_member')->whereNull('returned_at')->count();
        $this->assertGreaterThan(0, $activeLoanCount);
        $this->assertLessThan(40, $activeLoanCount);

        $loanCounts = DB::table('book_member')
            ->select('member_id', DB::raw('COUNT(*) AS loan_count'))
            ->groupBy('member_id')
            ->get();
        $this->assertCount(30, $loanCounts);

        foreach ($loanCounts as $loanCount) {
            $this->assertGreaterThanOrEqual(1, $loanCount->loan_count);
            $this->assertLessThanOrEqual(3, $loanCount->loan_count);
        }

        $member = Member::firstOrFail();
        $this->assertTrue(Hash::check('password', $member->password));
    }

    public function test_book_can_be_created_with_normalized_isbn_and_a_safe_cover_upload(): void
    {
        Storage::fake('public');
        $author = Author::factory()->create();

        $response = $this->post(route('books.store'), $this->validBookData($author, [
            'isbn' => '978-0-306-40615-7',
            'cover' => $this->fakePng('original.png'),
        ]));

        $book = Book::where('isbn', '9780306406157')->firstOrFail();

        $response->assertRedirect(route('books.show', $book))
            ->assertSessionHas('status', 'Book added to the catalogue.');
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'isbn' => '9780306406157',
            'author_id' => $author->id,
        ]);
        $this->assertNotSame('original.png', basename($book->cover_path));
        Storage::disk('public')->assertExists($book->cover_path);

        $this->get(route('books.show', $book))->assertSee('storage/'.$book->cover_path);
    }

    public function test_invalid_isbn_year_and_cover_return_to_form_with_old_input(): void
    {
        $author = Author::factory()->create();
        $response = $this->followingRedirects()->from(route('books.create'))->post(route('books.store'), $this->validBookData($author, [
            'isbn' => '978-0-306-40615-8',
            'title' => 'Retained title',
            'published_year' => 1449,
            'cover' => UploadedFile::fake()->create('cover.gif', 20, 'image/gif'),
        ]));

        $response->assertOk()
            ->assertSee('Retained title')
            ->assertSee('invalid ISBN-13 check digit')
            ->assertSee('published year')
            ->assertSee('JPG or PNG');
    }

    public function test_update_accepts_its_existing_isbn_and_replaces_old_cover_safely(): void
    {
        Storage::fake('public');
        $oldCoverPath = 'covers/old-cover.png';
        Storage::disk('public')->put($oldCoverPath, 'old cover');
        $book = Book::factory()->create(['cover_path' => $oldCoverPath]);

        $response = $this->put(route('books.update', $book), $this->validBookData($book->author, [
            'isbn' => substr($book->isbn, 0, 3).'-'.substr($book->isbn, 3),
            'title' => 'Revised book title',
            'cover' => $this->fakePng('new-cover.png'),
        ]));

        $book->refresh();
        $response->assertRedirect(route('books.show', $book))
            ->assertSessionHas('status', 'Book updated.');
        $this->assertSame('Revised book title', $book->title);
        Storage::disk('public')->assertMissing($oldCoverPath);
        Storage::disk('public')->assertExists($book->cover_path);
    }

    public function test_member_registration_checks_age_password_and_hashes_password(): void
    {
        $response = $this->post(route('members.store'), [
            'name' => 'Alex Reader',
            'email' => 'alex@example.test',
            'date_of_birth' => now()->subYears(20)->toDateString(),
            'password' => 'long-password',
            'password_confirmation' => 'long-password',
        ]);

        $member = Member::where('email', 'alex@example.test')->firstOrFail();
        $response->assertRedirect(route('books.index'))
            ->assertSessionHas('status', 'Member registered.');
        $this->assertTrue(Hash::check('long-password', $member->password));

        $this->from(route('members.create'))->post(route('members.store'), [
            'name' => 'Young Reader',
            'email' => 'young@example.test',
            'date_of_birth' => now()->subYears(15)->toDateString(),
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertRedirect(route('members.create'))
            ->assertSessionHasErrors(['date_of_birth', 'password']);
    }

    public function test_member_can_borrow_available_book_and_loan_is_recorded(): void
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        $response = $this->post(route('books.borrow', $book), ['member_id' => $member->id]);

        $response->assertRedirect(route('books.show', $book))
            ->assertSessionHas('status', 'Book borrowed successfully.');
        $this->assertDatabaseHas('book_member', [
            'book_id' => $book->id,
            'member_id' => $member->id,
            'returned_at' => null,
        ]);
    }

    public function test_book_already_on_loan_cannot_be_borrowed_again(): void
    {
        $book = Book::factory()->create();
        $currentMember = Member::factory()->create();
        $nextMember = Member::factory()->create();
        $book->members()->attach($currentMember->id, ['borrowed_at' => now(), 'returned_at' => null]);

        $this->from(route('books.show', $book))->post(route('books.borrow', $book), ['member_id' => $nextMember->id])
            ->assertRedirect(route('books.show', $book))
            ->assertSessionHasErrors('member_id');

        $this->assertDatabaseMissing('book_member', [
            'book_id' => $book->id,
            'member_id' => $nextMember->id,
        ]);
    }

    public function test_book_page_shows_current_borrower_and_disables_an_unavailable_book(): void
    {
        $book = Book::factory()->create();
        $member = Member::factory()->create(['name' => 'Current Reader']);
        $book->members()->attach($member->id, ['borrowed_at' => now(), 'returned_at' => null]);

        $this->get(route('books.show', $book))
            ->assertOk()
            ->assertSee('currently on loan to Current Reader')
            ->assertSee('disabled', false);
    }

    public function test_member_with_three_unreturned_loans_cannot_borrow_another_book(): void
    {
        $member = Member::factory()->create();
        $books = Book::factory()->count(4)->create();

        foreach ($books->take(3) as $book) {
            $book->members()->attach($member->id, ['borrowed_at' => now(), 'returned_at' => null]);
        }

        $this->from(route('books.show', $books[3]))
            ->post(route('books.borrow', $books[3]), ['member_id' => $member->id])
            ->assertRedirect(route('books.show', $books[3]))
            ->assertSessionHasErrors('member_id');

        $this->assertDatabaseMissing('book_member', [
            'book_id' => $books[3]->id,
            'member_id' => $member->id,
        ]);
    }

    private function validBookData(Author $author, array $overrides = []): array
    {
        return array_merge([
            'isbn' => '9780306406157',
            'title' => 'A Practical Laravel Guide',
            'author_id' => $author->id,
            'published_year' => now()->year,
            'is_reference' => 0,
        ], $overrides);
    }

    private function fakePng(string $name): UploadedFile
    {
        $contents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC');

        return UploadedFile::fake()->createWithContent($name, $contents ?: '');
    }
}
