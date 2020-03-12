<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();
        DB::table('comments')->insert([
            [
                'user_id' => 4,
                'question_id' => 1,
                'comment' => 'ぜひ優勝してください',
            ],
            [
                'user_id' => 2,
                'question_id' => 2,
                'comment' => 'デブの味方ですね',
            ],
            [
                'user_id' => 2,
                'question_id' => 1,
                'comment' => 'トロフィーを潜影蛇手',
            ],
            [
                'user_id' => 4,
                'question_id' => 2,
                'comment' => '全ての大盛りの産みの親ー！そう我こそはー',
            ],
        ]);

    }
}
