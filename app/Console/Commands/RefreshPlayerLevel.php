<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class RefreshPlayerLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oversquad:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh players levels';

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
         $users = User::all();
         foreach ($users as $user) {
             $level = $user->getLevel();
             $user->level = $level;
             $user->save();
         }
         foreach ($users as $user) {
             $hero1 = $user->getHeroWithRank(0);
             $hero2 = $user->getHeroWithRank(1);
             $hero3 = $user->getHeroWithRank(2);
             $user->hero1 = $hero1;
             $user->hero2 = $hero2;
             $user->hero3 = $hero3;
             $user->save();
         }
     }
}
