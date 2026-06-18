<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Note;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create test notes
        Note::create([
            'title' => 'Welcome to Our Note App',
            'content' => 'This is the first note introducing our new note taking platform.',
            'user_id' => $user1->id,
        ]);

        Note::create([
            'title' => 'Getting Started with APIs',
            'content' => 'Learn how to work with REST APIs and how to document them properly using Postman.',
            'user_id' => $user2->id,
        ]);

        Note::create([
            'title' => 'Best Practices for API Design',
            'content' => 'Discover the best practices for designing robust and scalable APIs.',
            'user_id' => $user1->id,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('Test Users:');
        $this->command->info('  - Email: john@example.com (Password: password)');
        $this->command->info('  - Email: jane@example.com (Password: password)');
    }
}
