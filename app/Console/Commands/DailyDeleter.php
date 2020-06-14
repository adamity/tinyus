<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Link;
use Carbon\Carbon;

class DailyDeleter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired link(s) daily';

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
        $today = Carbon::now()->toDateTimeString();
        $expired = date('Y-m-d 00:00:00', strtotime($today));
        $links = Link::all()->where('expired_at',$expired);
        if(count($links)>0)
        {
            foreach($links as $link)
            {
                $link->delete();
            }
        }
    }
}
