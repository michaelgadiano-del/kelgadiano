<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_builds_required_library_demo_data(): void
    {
        $this->seed();

        $this->assertTrue(Schema::hasTable('book_member'));
        $this->assertSame(10, Author::count());
        $this->assertSame(40, Book::count());
        $this->assertSame(1, Book::where('is_reference', true)->count());
        $this->assertSame(30, Member::count());
        $this->assertGreaterThanOrEqual(30, Loan::count());
        $this->assertLessThanOrEqual(90, Loan::count());

        $this->assertSame(
            (int) round(Loan::count() * 0.2),
            Loan::whereNull('returned_at')->count(),
        );

        $memberUser = User::where('email', 'member@example.com')->firstOrFail();
        $this->assertSame('member', $memberUser->role);
        $this->assertNotNull($memberUser->member);
        $this->assertDatabaseHas('users', ['email' => 'librarian@example.com', 'role' => 'librarian']);
        $this->assertDatabaseHas('users', ['email' => 'admin@example.com', 'role' => 'admin']);

        $this->post('/login', [
            'email' => 'member@example.com',
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($memberUser);
    }
}
