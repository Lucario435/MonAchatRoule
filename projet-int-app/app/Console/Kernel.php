<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\Jobs\Job;
use App\Jobs\ContinuousTaskJob;
use App\Models\Publication;

use function Laravel\Prompts\error;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function(){
            //get les enchère qui sont de type enchères
            $encheres = Publication::all()
            ->where('type', "1")
            ->where('publicationStatus','En vente');

            //Pour chaque enchère
            foreach($encheres as $enchere)
            {
                //On vérifie si cet enchère a déjà un flag En cours
                if(strtotime($enchere->expirationOfBid) <= time())
                {
                    // En attente | Vendu | En vente
                    $enchere->publicationStatus = 'En attente';
                    $enchere->save();
                    error_log("Enchère " . $enchere->title . " modifié dans la BD");
                }
            }

        })->everyTenSeconds();
    }
    protected $commands = [
        \App\Console\Commands\RefreshBidsCommand::class,
    ];
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
