<?php

namespace App\Console\Commands;

use App\UserAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TimeInspector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find properties with few days left and warn users, unpublish properties
    with time exhausted.';


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
     * @return mixed
     */
    public function handle()
    {
        foreach(Config::get('app.daysToWarn') as $days){
            $soonexpireds = UserAction::getSoonExpireds($days);
            try{
                foreach($soonexpireds as $exp){
                    if(preg_match_all(Config::get('app.mail_regex'),$exp->mail))
                        Mail::send('mail.soonexpired', ['data'=>$exp, 'days'=>$days], function($message) use($exp, $days){
                            $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                            $message->to($exp->mail)
                                ->subject('Propiedad expira en '.$days.' dias');
                        });
                }
            }
            catch(\Exception $e){
                Log::error($e);
            }
        }
        $expireds = UserAction::getExpireds();
        UserAction::deActivateExpireds();

        try{
            foreach($expireds as $exp){
                if(preg_match_all(Config::get('app.mail_regex'),$exp->mail))
                    Mail::send('mail.expired', ['data'=>$exp], function($message) use ($exp){
                        $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                        $message->to($exp->mail)
                            ->subject('Propiedad expirada');
                    });
            }
            Mail::send('mail.adminexpired', ['data'=>$expireds], function($message) use($expireds){
                $message->from(Config::get('mail.from')['address'], Config::get('mail.from')['address']);
                $message->to(Config::get('mail.from')['address'], Config::get('mail.from')['name'])
                    ->subject(count($expireds).' Propiedades expiradas hoy');
            });
        }
        catch(\Exception $e){
            Log::error($e);
        }

    }
}
