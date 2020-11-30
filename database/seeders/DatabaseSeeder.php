<?php

namespace Database\Seeders;

use App\Models\QuestionComment;
use App\Models\QuestionLike;
use App\Models\QuestionSave;
use App\Models\QuestionTag;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // User
        User::create([
            'name' => 'Hein Htet',
            'email' => 'hein@gmail.com',
            'password' => Hash::make('hein1234'),
            'image' => '/images/profile/default.jpg',
        ]);
        User::create([
            'name' => 'Pan Ei',
            'email' => 'pan@gmail.com',
            'password' => Hash::make('pan123'),
            'image' => '/images/profile/default.jpg',
        ]);
        // Question
        Question::create([
            'user_id' => '1',
            'slug' => Str::slug('laravel problem?'),
            'title' => 'laravel problem?',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
        ]);

        Question::create([
            'user_id' => '2',
            'slug' => Str::slug('another laravel problem?'),
            'title' => 'another laravel problem?',
            'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
        ]);


        // Tag

        Tag::create([
            'slug' => Str::slug('laravel'),
            'name' => 'laravel',
        ]);

        // QuestionTag

        QuestionTag::create([
            'question_id'=>1,
            'tag_id'=>1
        ]);


        // QuestionComment

        QuestionComment::create([
            'question_id'=>1,
            'user_id'=>1,
            'comment'=>'something'
        ]);

        // QuestionLike
        QuestionLike::create([
            'question_id'=>1,
            'user_id'=>1,
        ]);

        // QuestionSave
        QuestionSave::create([
            'question_id'=>1,
            'user_id'=>1,
        ]);

    }
}
