<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DeleteOldStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete students whose kohort is older than 5 years.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $threshold = Carbon::now()->year - 6;

        $deleted = DB::table('students')
            ->whereNotNull('kohort')
            ->where('kohort', '<>', '')
            ->whereRaw('CAST(kohort AS SIGNED) <= ?', [$threshold])
            ->delete();

        $this->info("Deleted {$deleted} student(s) with kohort <= {$threshold}.");
        Log::info("students:cleanup deleted {$deleted} students with kohort <= {$threshold}.");

        return 0;
    }
}
