<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2,8)),
            'content' => collect($this->faker->paragraphs(mt_rand(5,10)))
                    ->map(fn($p) =>"<p>$p</p>")
                    ->implode(''),
            'user_id' => mt_rand(1,4),
            'category_id' => mt_rand(1,3)
        ];
    }
}
