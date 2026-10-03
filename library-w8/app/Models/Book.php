<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    protected $fillable = [
        'author_id',
        'isbn',
        'title',
        'published_year',
        'is_reference',
        'cover_path',
    ];

    protected function casts(): array
    {
        return [
            'published_year' => 'integer',
            'is_reference' => 'boolean',
        ];
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class)
            ->withPivot('borrowed_at', 'returned_at')
            ->withTimestamps();
    }

    public function isAvailable(): bool
    {
        return ! $this->members()->wherePivotNull('returned_at')->exists();
    }
}
