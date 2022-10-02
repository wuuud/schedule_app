<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Schedule extends Mailable
{
    use Queueable, SerializesModels;

    // このクラス内で使える変数として定義
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        // return $this->view('mail.test');
        return $this->subject('Test Mail')
            // ->view('mail.test')
            ->view('mail.schedules')
            ->subject('Test Mail')
            // インスタント変数なのでthisが必要。with(compact())は使えない。
            ->with(['user' => $this->user]);
    }
}
