<?php

namespace App\Imports;

use App\Models\Bailleur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class BailleurImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Row data for import:', $row);
    
        // Vérification que les données obligatoires sont présentes
        if (empty($row['nom']) || empty($row['code'])) {
            Log::error('Missing required data:', $row);
            return null; // Ignorer la ligne si des champs sont manquants
        }
    
        return new Bailleur([
            'bailleur_name' => $row['nom'],
            'description' => $row['description'] ?? null,
            'abbreviation_code' => $row['code'] ?? null,
        ]);
    }
    
}
