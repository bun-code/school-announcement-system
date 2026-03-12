<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        Announcement::factory()
            ->for($author, 'author')
            ->state([
                'title' => 'Enrollment Now Open',
                'status' => 'published',
                'is_pinned' => true,
                'category' => 'General',
                'post_date' => now()->subDays(9),
            ])
            ->create();

        Announcement::factory()
            ->count(7)
            ->for($author, 'author')
            ->state(['status' => 'published'])
            ->create();

        Announcement::factory()
            ->count(4)
            ->for($author, 'author')
            ->state(['status' => 'draft'])
            ->create();
    }
}
