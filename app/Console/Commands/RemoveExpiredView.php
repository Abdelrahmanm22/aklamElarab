<?php

namespace App\Console\Commands;

use App\Models\Bookview;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RemoveExpiredView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to remove expired Views';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Bookview::where('expiration_date', '<', Carbon::now())->delete();

        $this->info('Expired items removed from the watchlist.');
    }
}
