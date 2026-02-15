<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;

class WeekeEventMailCommand extends Command
{

    private Mailer $mailer;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weeke-event-mail-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function __construct(Mailer $mailer)
    {
        return parent::__construct();
        $this->mailer = $mailer;
        //メール内容を持ってくるサービスコンテナを記述

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //コンストラクタで持ってきたサービスコンテナのメソッドを呼び出し

        $users = User::get();

        foreach($users as $user){
            //メール送信処理
        }
    }
}
