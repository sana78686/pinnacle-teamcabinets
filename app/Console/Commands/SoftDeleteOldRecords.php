<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SoftDeleteOldRecords extends Command
{
    protected $signature = 'softdelete:old-records';
    protected $description = 'Soft delete records older than 60 days for all models';

    public function handle()
    {
        $this->info('Running soft delete for all models with records older than 60 days...');

        $models = [
            User::class,
            // YourModel2::class,
            // Add other models here
        ];

        foreach ($models as $model) {
            $this->softDeleteOldRecords($model);
        }

        $this->info('Soft delete completed!');
    }

    /**
     * Soft delete records older than 60 days for a given model.
     *
     * @param string $model
     * @return void
     */
    protected function softDeleteOldRecords($model)
    {
        $date = Carbon::now()->subDays(60); // 60 days ago

        // Soft delete records older than 60 days
        $model::whereNull('deleted_at') // Ensure they are not already soft deleted
            ->where('created_at', '<', $date)
            ->get()
            ->each(function ($record) {
                $record->delete();
                $this->info("Soft deleted record with ID: {$record->id} from {$record->getTable()}");
            });
    }
}
