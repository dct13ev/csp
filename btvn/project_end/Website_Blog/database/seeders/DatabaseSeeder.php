<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo tài khoản test
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        // 2. Tạo 5 tài khoản Member
        $members = User::factory(5)->create(['role' => 'member']);

        // 3. Tạo 5 Danh mục và 10 Tag
        $categories = Category::factory(5)->create();
        $tags = Tag::factory(10)->create();

        // 4. Tạo 20 Bài viết và gán ngẫu nhiên cho các Member, Category
        Post::factory(20)->create(function () use ($members, $categories) {
            return [
                'user_id' => $members->random()->id,
                'category_id' => $categories->random()->id,
            ];
        })->each(function ($post) use ($tags, $members) {
            // Gắn ngẫu nhiên 2-4 tag cho mỗi bài viết
            $post->tags()->attach($tags->random(rand(2, 4))->pluck('id')->toArray());
            
            // Tạo 3 bình luận ngẫu nhiên cho mỗi bài viết
            for ($i = 0; $i < 3; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $members->random()->id,
                    'content' => fake()->paragraph(2),
                ]);
            }
        });
    }
}