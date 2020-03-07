<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->truncate();
        DB::table('questions')->insert([
            [
                'user_id' => 1,
                'tag_category_id' => 1,
                'title' => '今日は何で優勝しますか？',
                'content' => '今回は味噌煮込みうどんと１番のやつで優勝するわね',
            ],
            [
                'user_id' => 2,
                'tag_category_id' => 2,
                'title' => '好きな言葉は何ですか？',
                'content' => '大盛り！！！！！！！！！！！',
            ],
        ]);

    }
}
