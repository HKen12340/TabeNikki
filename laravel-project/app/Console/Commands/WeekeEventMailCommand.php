<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RandomFoodRecMail;

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
            $test = Content::where('user_id',$user->id)->get();

            $max = Content::where('user_id',$user->id)->count();

            if($max != 0){
                $mail_content = $test->get(rand(0,$max));
                Log::debug($mail_content->food_name);

                $mail_content_name = $mail_content->food_name;
                Log::debug($mail_content_name);

                Mail::to($user->email)
                ->send(new RandomFoodRecMail($user,$mail_content));
            }
        }
    }
}
