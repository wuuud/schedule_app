<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //2件のデータ 
        \App\Models\User::factory(2)->create()
        //出来上がったデータを回してfoewach文
            ->each(function ($user) {
                // ユーザーごとに１０件
                \App\Models\Event::factory(10)->create(
                // イベントテーブルのuser_idにusersテーブルのuser(上記で作成した)
                // のidを登録
                    ['user_id' => $user->id]
                );
            });
    }
}
