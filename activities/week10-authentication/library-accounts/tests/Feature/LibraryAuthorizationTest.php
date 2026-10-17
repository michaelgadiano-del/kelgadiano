<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_browse_books_but_staff_routes_require_login(): void
    {
        $book = Book::factory()->create();

        $this->get(route('books.index'))->assertOk();
        $this->get(route('books.show', $book))->assertOk();
        $this->get(route('desk'))->assertRedirect(route('login'));
        $this->get(route('my.loans'))->assertRedirect(route('login'));
    }

    public function test_only_librarian_and_admin_can_use_library_desk(): void
    {
        $member = $this->makeUserWithRole('member');
        $this->actingAs($member)->get(route('desk'))->assertForbidden();

        $librarian = $this->makeUserWithRole('librarian');
        $this->actingAs($librarian)->get(route('desk'))->assertOk();
    }

    public function test_member_can_borrow_a_circulating_book_and_cannot_borrow_reference_book(): void
    {
        $user = $this->makeUserWithRole('member');
        $member = $user->member()->create(['name' => $user->name, 'email' => $user->email]);
        $circulatingBook = Book::factory()->create();
        $referenceBook = Book::factory()->create(['is_reference' => true]);

        $this->actingAs($user)
            ->post(route('books.borrow', $circulatingBook))
            ->assertRedirect(route('my.loans'));

        $this->assertDatabaseHas('book_member', [
            'member_id' => $member->id,
            'book_id' => $circulatingBook->id,
            'returned_at' => null,
        ]);

        $this->post(route('books.borrow', $referenceBook))->assertForbidden();
    }

    public function test_member_cannot_borrow_the_same_book_twice_without_returning_it(): void
    {
        $user = $this->makeUserWithRole('member');
        $member = $user->member()->create(['name' => $user->name, 'email' => $user->email]);
        $book = Book::factory()->create();
        $member->loans()->create(['book_id' => $book->id, 'borrowed_at' => now()]);

        $this->actingAs($user)
            ->from(route('books.show', $book))
            ->post(route('books.borrow', $book))
            ->assertRedirect(route('books.show', $book))
            ->assertSessionHasErrors('borrow');

        $this->assertSame(1, Loan::where('member_id', $member->id)->where('book_id', $book->id)->count());
    }

    public function test_member_sees_only_their_own_loans(): void
    {
        $user = $this->makeUserWithRole('member');
        $member = $user->member()->create(['name' => $user->name, 'email' => $user->email]);
        $other = Member::factory()->create();
        $ownBook = Book::factory()->create(['title' => 'My book']);
        $otherBook = Book::factory()->create(['title' => 'Private other book']);
        $member->loans()->create(['book_id' => $ownBook->id, 'borrowed_at' => now()]);
        $other->loans()->create(['book_id' => $otherBook->id, 'borrowed_at' => now()]);

        $this->actingAs($user)
            ->get(route('my.loans'))
            ->assertOk()
            ->assertSee('My book')
            ->assertDontSee('Private other book');
    }

    public function test_librarian_can_manage_books_and_return_loans_but_member_cannot(): void
    {
        $author = Author::factory()->create();
        $book = Book::factory()->for($author)->create();
        $member = Member::factory()->create();
        $loan = $member->loans()->create(['book_id' => $book->id, 'borrowed_at' => now()]);

        $regularUser = $this->makeUserWithRole('member');
        $this->actingAs($regularUser)->patch(route('desk.loans.return', $loan))->assertForbidden();

        $librarian = $this->makeUserWithRole('librarian');
        $this->actingAs($librarian)
            ->get(route('books.create'))
            ->assertOk();

        $this->post(route('books.store'), [
            'author_id' => $author->id,
            'isbn' => '9781234567890',
            'title' => 'Created by librarian',
            'published_year' => 2020,
            'is_reference' => 0,
        ])->assertRedirect();

        $createdBook = Book::where('isbn', '9781234567890')->firstOrFail();
        $this->put(route('books.update', $createdBook), [
            'author_id' => $author->id,
            'isbn' => $createdBook->isbn,
            'title' => 'Updated by librarian',
            'published_year' => 2021,
            'is_reference' => 0,
        ])->assertRedirect();

        $this->patch(route('desk.loans.return', $loan))->assertRedirect();
        $this->assertNotNull($loan->fresh()->returned_at);

        $this->delete(route('books.destroy', $createdBook))->assertRedirect();
        $this->assertDatabaseMissing('books', ['id' => $createdBook->id]);
    }

    public function test_only_admin_can_change_roles_and_admin_cannot_demote_self(): void
    {
        $admin = $this->makeUserWithRole('admin');
        $other = $this->makeUserWithRole('member');

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->patch(route('admin.users.role', $admin), ['role' => 'member'])->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
        $this->patch(route('admin.users.role', $admin), ['role' => 'admin'])->assertRedirect();
        $this->patch(route('admin.users.role', $other), ['role' => 'librarian'])->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $other->id, 'role' => 'librarian']);

        $librarian = $this->makeUserWithRole('librarian');
        $this->actingAs($librarian)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_member_registration_creates_a_linked_library_profile(): void
    {
        $this->post(route('register'), [
            'name' => 'New Library Member',
            'email' => 'new-member@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'new-member@example.com')->firstOrFail();
        $this->assertSame('member', $user->role);
        $this->assertSame($user->id, $user->member->user_id);
        $this->assertSame($user->email, $user->member->email);
    }

    public function test_librarian_can_rename_authors_but_members_cannot(): void
    {
        $author = Author::factory()->create();
        $librarian = $this->makeUserWithRole('librarian');

        $this->actingAs($librarian)
            ->get(route('authors.index'))
            ->assertOk();

        $this->patch(route('authors.update', $author), ['name' => 'Professor Sample'])
            ->assertRedirect();

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'name' => 'Professor Sample',
        ]);

        $member = $this->makeUserWithRole('member');
        $this->actingAs($member)
            ->get(route('authors.index'))
            ->assertForbidden();
    }

    public function test_demo_seeder_uses_distinct_human_readable_book_titles(): void
    {
        $this->seed();

        $this->assertDatabaseCount('books', 40);
        $this->assertDatabaseHas('books', ['title' => 'A Map of Old Manila']);
        $this->assertDatabaseHas('books', ['title' => 'The School Library Handbook']);
        $this->assertSame(40, Book::query()->distinct()->count('title'));
    }

    private function makeUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->forceFill(['role' => $role])->save();

        return $user;
    }
}
