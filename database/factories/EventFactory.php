<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateStr = Carbon::now()->toDateString();
        $start = Carbon::create($dateStr)
            ->addDay(random_int(-30,30))
            // Hourと大文字で書く
            ->addHour(random_int(9, 18));
        $end = Carbon::create($start)->addHour(random_int(1,3));
        return [
            // randomなのでユーザー１すらできない可能性あり。
            // ユーザーID＝１を設定
            'user_id' => 1,
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            'start' => $start,
            'end' => $end
            ];
    }
}
