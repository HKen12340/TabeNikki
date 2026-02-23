<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RandomFoodRecMail;

class RandomFoodMailCommand extends Command
{

    private Mailer $mailer;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:random-food-mail-command';

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

    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::get();

        //ランダムで選ばれた料理情報を載せたメールを総世親
        foreach($users as $user){
            //ユーザIDに該当する料理を抽出
            $test = Content::where('user_id',$user->id)->get();

            $max = Content::where('user_id',$user->id)->count();

            if($max != 0){
                //ランダムで料理を選ぶ
                $mail_content = $test->get(rand(0,$max));
                Log::debug($mail_content->food_name);

                $mail_content_name = $mail_content->food_name;
                Log::debug($mail_content_name);

                //メール送信
                Mail::to($user->email)
                ->send(new RandomFoodRecMail($user,$mail_content));
            }
        }
    }
}
