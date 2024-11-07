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
    // Log de chaque ligne avant d'essayer de l'importer
    Log::info('Importing Row:', $row);

    // Vérification si le bailleur existe déjà en fonction du 'bailleur_name' (nom)
    $existingBailleur = Bailleur::where('bailleur_name', $row['nom'])->first();

    // Si le bailleur existe déjà, on ignore cette ligne
    if ($existingBailleur) {
        Log::info('Skipping duplicate bailleur:', $row);
        return null; // Ignorer la ligne si elle existe déjà
    }

    try {
        // Sinon, créer un enregistrement dans la base de données
        return new Bailleur([
            'bailleur_name' => $row['nom'],
            'description' => $row['description'] ?? null,
            'abbreviation_code' => $row['code'] ?? null,
        ]);
    } catch (\Exception $e) {
        // Si une erreur survient pour une ligne, enregistrez-la dans les logs
        Log::error('Error importing row:', [
            'row' => $row,
            'error' => $e->getMessage()
        ]);
        return null; // Retourner null si la ligne ne peut pas être importée
    }
}

    
}
