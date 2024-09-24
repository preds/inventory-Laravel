<?php
namespace App\Imports;

use App\Models\Designation;
use Maatwebsite\Excel\Concerns\ToModel;

class DesignationsImport implements ToModel
{
    public function model(array $row)
    {
        return new Designation([
            'designation_name' => $row[0],
            'description' => $row[1],          // Supposons que la description soit dans la deuxième colonne du fichier Excel
            'abbreviation_code' => $row[2],    // Supposons que le code d'abréviation soit dans la troisième colonne du fichier Excel
        ]);
    }
}
