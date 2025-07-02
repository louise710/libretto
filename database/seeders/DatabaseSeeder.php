<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create 5 users
        $users = User::factory(5)->create();
        
        // For each user, create authors and books
        $users->each(function ($user) {
            $authors = Author::factory(3)->create();
            
            $authors->each(function ($author) use ($user) {
                $books = Book::factory(2)->create([
                    'author_id' => $author->id,
                    'user_id' => $user->id
                ]);
                
                $books->each(function ($book) use ($user) {
                    $genres = Genre::factory(2)->create();
                    $book->genres()->attach($genres);
                    
                    Review::factory(3)->create([
                        'book_id' => $book->id,
                        'user_id' => $user->id
                    ]);
                });
            });
        });
        
        // Create an admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@libretto.com',
            'password' => bcrypt('password'),
        ]);
    }
}