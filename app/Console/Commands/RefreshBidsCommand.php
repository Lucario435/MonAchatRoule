<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshBidsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:bids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //This is the actual command that executes every 1min
        $this->info('Hello command executed successfully.');

    }
}
