<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        $postDate = $this->faker->dateTimeBetween('-45 days', 'now');
        $expiryDate = $this->faker->boolean(20)
            ? (clone $postDate)->modify('+' . $this->faker->numberBetween(5, 30) . ' days')
            : null;

        return [
            'title'       => $this->faker->sentence(4),
            'body'        => $this->faker->paragraphs(3, true),
            'category'    => $this->faker->randomElement([
                'General',
                'Academic',
                'Notice',
                'Health',
                'Community',
            ]),
            'status'      => $this->faker->randomElement(['published', 'draft']),
            'is_pinned'   => $this->faker->boolean(10),
            'post_date'   => $postDate,
            'expiry_date' => $expiryDate,
            'author_id'   => User::factory(),
        ];
    }
}
