<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class UpdateAssetAmortization extends Command
{
    protected $signature = 'asset:update-amortization';
    protected $description = 'Update asset amortization status';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
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

            $this->info('Asset amortization status updated successfully.');
        } catch (\Exception $e) {
            // Log error
            DB::table('task_logs')->insert([
                'status' => 'error',
                'message' => $e->getMessage(),
                'created_at' => now(),
            ]);

            $this->error('Failed to update asset amortization status.');
        }
    }
}
