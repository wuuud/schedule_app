<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Schedule;
use App\Models\User;
use Illuminate\Support\Carbon;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'mail:send';
    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    // コマンドの説明
    protected $description = 'Scheduled email sending';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 1.return 0;
        // ターミナルに出力される
        // echo 'SendMail';

        // コマンドでメールを送信できるように記載
        // 送信先を選択、user classのデータの最初の方
        // 普通のメールならこれでもいいが、スケジュールを含むと長くなるのでMailを設定
        // $user = User::first();
        // // テキストメールで短文の場合。第二引数が関数。関数で帰ってきた値を送信できる。
        // Mail::raw('本文です', function ($message) use ($user) {
        //     // userのemailアドレスを？
        //     $message->to($user->email)
        //         ->subject('タイトルです');
        // });
        // // メール用クラスのMailableを利用する場合
        // // 送信先
        // Mail::to($user->email)
        // // 送信
        //     ->send(new Schedule($user));

        // ２.スケジュールメール
        // 2-1.全員に送信
        // $users = User::all();
        // foreach ($users as $user) {
        //     Mail::to($user->email)
        //         ->send(new Schedule($user));
        // }

        // 2−２.翌日のスケジュールが存在するユーザのみに送信
        // リレーション先の条件で絞り込み
        // whereHas(リレーション名, <callback>) ※ callbackとは、ざっくり言うと関数
        // callback関数の処理結果をwhereHasの結果として返す
        // 今回は無名関数　＝　クロージャーを使います。whereHas(リレーション名, function() { 処理 })
        //                                         queryを返す
        // $users = User::whereHas('events', function ($query) {
        //     // 日付で絞り込み       一日先の日
        //     $tomorrow = Carbon::now()->addDay(1);
        //     // 　　　　　　　　スタートの日が明日かどうか
        //     $query->whereDate('start', $tomorrow);

        //     // 範囲指定の方法(翌日から1週間)
        //     // $from = Carbon::now()->addDay(1);
        //     // $to = Carbon::now()->addWeeK(1);
        //     // $query->whereDate('start', '>=', $from)
        //     //     ->whereDate('start', '<=', $to);

        //     // ユーザーを絞り込んでGET
        // })->get();
        // foreach ($users as $user) {
        //     Mail::to($user->email)
        //         ->send(new Schedule($user));

        // 2-3.翌日のスケジュールある方
        $users = User::whereHas('events', function ($query) {
            // 日付で絞り込み
            $tomorrow = Carbon::now()->addDay(1);
            $query->whereDate('start', $tomorrow);
        })->with(['events' => function ($query) {
            // 日付で絞り込み
            $tomorrow = Carbon::now()->addDay(1);
            $query->whereDate('start', $tomorrow);
        }])->get();
        foreach ($users as $user) {
            Mail::to($user->email)
                ->send(new Schedule($user));
        }
    }
}
