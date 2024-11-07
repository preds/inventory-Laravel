<?php

namespace App\Imports;

use App\Models\Projet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProjetImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
{
    // Log de chaque ligne avant d'essayer de l'importer
    Log::info('Importing Row:', $row);

    // Vérification si le projet existe déjà en fonction du 'projet_name' (nom)
    $existingProjet = Projet::where('projet_name', $row['nom'])->first();

    // Si le projet existe déjà, on ignore cette ligne
    if ($existingProjet) {
        Log::info('Skipping duplicate projet:', $row);
        return null; // Ignorer la ligne si elle existe déjà
    }

    try {
        // Sinon, créer un enregistrement dans la base de données
        return new Projet([
            'projet_name' => $row['nom'],
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
