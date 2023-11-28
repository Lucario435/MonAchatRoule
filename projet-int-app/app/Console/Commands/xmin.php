<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class xmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:xmin';

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
        //executer chaque min

        // print("slaut");
        $this->info("salut");
    }
}
