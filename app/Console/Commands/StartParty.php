<?php

namespace App\Console\Commands;

use App\Models\Party;
use Illuminate\Console\Command;

class StartParty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:party';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start party';

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
        $parties = Party::all();

        foreach ($parties as $party) {
            if ($party->start == 0) {
                date_default_timezone_set('Europe/Belgrade');

                if (date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime($party->date))) {
                    $party->start = 1;
                    $party->update();
                }
            }
        }
    }
}
