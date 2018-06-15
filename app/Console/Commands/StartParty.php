<?php

namespace App\Console\Commands;

use App\Models\Party;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * Class StartParty
 * @package App\Console\Commands
 */
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
        $playlist = new Playlist();
        $qband = User::where('email', 'qband@local.loc')->first();

        foreach ($parties as $party) {
            date_default_timezone_set('Europe/Belgrade');

            if (date('Y-m-d H:i') >= date('Y-m-d H:i', strtotime($party->date))) {
                $checkPlaylist = $playlist->where('party_id', $party->id)->where('user_id', null)->get();
                if (count($checkPlaylist) > 0) {
                    $playlist->where('user_id', null)->update(['user_id' => $qband->id]);
                    $party->start = 1;
                    $party->update();
                } else {
                    $party->start = 1;
                    $party->update();
                }

            }

        }
    }
}
