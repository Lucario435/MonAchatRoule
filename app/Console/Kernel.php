<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\Jobs\Job;
use App\Jobs\ContinuousTaskJob;
use App\Mail\PublicationAuctionExpired;
use App\Models\Publication;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\error;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command("xmin")->everyMinute();


        $schedule->call(function () {
            //get les enchère qui sont de type enchères
            $encheres = Publication::all()
                ->where('type', "1")
                ->where('publicationStatus', 'En vente');

            //Pour chaque enchère
            foreach ($encheres as $enchere) {
                //On vérifie si cet enchère a déjà un flag En cours
                if (strtotime($enchere->expirationOfBid) <= time()) {
                    // En attente | Vendu | En vente
                    $enchere->publicationStatus = 'En attente';
                    $enchere->save();
                    error_log("Enchère " . $enchere->title . " modifié dans la BD");

                    sendNotification($enchere->user_id,
                    "Votre enchère s'est terminée!","Jetez un coup d'oeil sur les offres reçues"
                    ,"/auction/ended/".$enchere->id);

                    $bidersEmail = DB::table('bids')
                        ->join('publications', 'bids.publication_id', '=', 'publications.id')
                        ->join('users', 'users.id', '=', 'bids.user_id')
                        ->where('bids.publication_id', '=', $enchere->id)
                        ->select('users.*')->get();

                    foreach ($bidersEmail as $bider) {
                        //dd($sub->email);
                        try {
                            //code...
                            Mail::to($bider->email)->queue(new PublicationAuctionExpired ($enchere));
                        } catch (\Throwable $th) {
                            error_log("Error: ". $th);
                        }


                        $notificationWebsiteMessage = "L'enchère : $enchere->title que vous suiviez vient de se terminer.";

                        try {
                            sendNotification(
                                $bider->id,
                                $enchere->title,
                                $notificationWebsiteMessage,
                                url("publication/detail/{$enchere->id}")
                            );
                        } catch (\Throwable $th) {
                            error_log("Error: ". $th);
                        }

                    }
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
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
