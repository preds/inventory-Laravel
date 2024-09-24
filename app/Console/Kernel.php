<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Asset;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            try {
                Log::channel('single')->info('Scheduled task started.');
    
                // Mapping des catégories avec les années d'amortissement
                $amortizationCategories = [
                    1 => 5,  // fourniture scolaire
                    2 => 5,  // fourniture de bureau
                    3 => 3,  // Matériel informatique
                    4 => 5,  // mobilier de bureau
                    5 => 5,  // parc automobile
                    // Ajoutez d'autres catégories avec leurs années d'amortissement ici
                ];
    
                $currentDate = now();
    
                $assets = Asset::all();
                foreach ($assets as $asset) {
                    // Intentionnellement provoquer une erreur en accédant à une propriété inexistante
                    $undefinedProperty = $asset->undefined_property;  // Cette ligne provoquera une erreur
    
                    $amortizationYears = $amortizationCategories[$asset->category_id] ?? 5; // Default to 5 years if not specified
                    $dateAchat = \Carbon\Carbon::parse($asset->date_achat);
                    $yearsDifference = $dateAchat->diffInYears($currentDate);
    
                    $asset->amortis = $yearsDifference >= $amortizationYears ? 1 : 0;
                    $asset->save();
                }
    
                // Log success
                DB::table('task_logs')->insert([
                    'status' => 'success',
                    'message' => 'Asset amortization status updated successfully.',
                    'created_at' => $currentDate,
                ]);
    
                Log::channel('single')->info('Scheduled task completed successfully.');
            } catch (\Exception $e) {
                // Log error
                DB::table('task_logs')->insert([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'created_at' => now(),
                ]);
    
                Log::channel('single')->error('Scheduled task encountered an error: ' . $e->getMessage());
            }
        })->everyMinute();
    }
    
}    