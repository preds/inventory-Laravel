<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjetImport;
use Illuminate\Support\Facades\Log;
class ProjetController extends Controller
{




    public function showAddProjetPage(Request $request) {
        $perPage = $request->get('perPage', 10); // Nombre d'items par page, par défaut 10
        $search = $request->get('search');
        $searchField = $request->get('search_field', 'all'); // Search field: all, projet, description, or code

        $query = Projet::query();

        // Apply search conditions
        if ($search) {
            if ($searchField === 'all') {
                $query->where('projet_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('abbreviation_code', 'like', '%' . $search . '%');
            } else {
                $query->where($searchField, 'like', '%' . $search . '%');
            }
        }

        // Paginate the results
        $projets = $query->paginate($perPage);

        return view('administration.addNewProjet', compact('projets'));
    }


    public function getProjetById($id)
    {
        // Recherchez la désignation par ID
        $projet = Projet::find($id);

        // Vérifiez si la désignation existe
        if ($projet) {
            return response()->json(['projet_name' => $projet->projet_name]);
        } else {
            return response()->json(['error' => 'projet not found'], 404);
        }
    }
    public function add(Request $request) {
        // Validation des données
        $request->validate([
            'projet_name' => 'required|string|max:255|unique:projets,projet_name',
            'description' => 'nullable|string|max:255',
            'abbreviation_code' => 'required|string|max:255|unique:projets,abbreviation_code',
        ]);

        // Transformation des données
        $projetName = ucfirst(strtolower($request->projet_name));
        $abbreviationCode = strtoupper($request->abbreviation_code);

        // Création de la désignation
        Projet::create([
            'projet_name' => $projetName,
            'description' => $request->description,
            'abbreviation_code' => $abbreviationCode,
        ]);

        return redirect()->back()->with('success', 'Désignation ajoutée avec succès.');
    }


    // public function import(Request $request) {
    //     $request->validate([
    //         'excelFile' => 'required|mimes:xlsx,xls,csv',
    //     ]);

    //     Excel::import(new projetImport, $request->file('excelFile'));

    //     return redirect()->back()->with('success', 'projets importées avec succès.');
    // }


    // public function import(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'excelFile' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max size
    //         ]);
    
    //         Excel::import(new projetImport, $request->file('excelFile'));
    
    //         // Vérification : compte le nombre de projets dans la DB
    //         $projetsCount = projet::count();
    
    //         return redirect()->back()->with('success', 'projets importées avec succès. Nombre de projets enregistrés : ' . $projetsCount);
    //     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //         return redirect()->back()->with('error', 'Erreur dans le fichier Excel. Veuillez vérifier les données.');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return redirect()->back()->with('error', 'Le fichier téléchargé n\'est pas valide. Veuillez télécharger un fichier Excel ou CSV valide.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Une erreur inconnue est survenue lors de l\'importation. Veuillez réessayer.');
    //     }
    // }
    

    public function import(Request $request)
{
    // Validation du fichier
    $request->validate([
        'excelFile' => 'required|mimes:xlsx,xls,csv',
    ]);

    try {
        // Log pour vérifier que l'import commence
        Log::info('Import started.');

        // Importer les données
        Excel::import(new ProjetImport, $request->file('excelFile'));

        // Log après l'importation
        Log::info('Import completed successfully.');

        return redirect()->back()->with('success', 'projets importées avec succès.');
    } catch (\Exception $e) {
        // Log d'erreur détaillé
        Log::error('Import error: ', ['error' => $e->getMessage()]);

        return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'importation. Veuillez réessayer.');
    }
}

    
    public function toggleStatus(Request $request) {
        $projet = Projet::find($request->id);
        $projet->active = !$projet->active;
        $projet->save();

        return redirect()->back();
    }

    public function delete(Request $request) {
        $projet = Projet::find($request->id);
        $projet->delete();

        return redirect()->back()->with('success', 'Désignation supprimée avec succès.');
    }

   public function deleteMultiple(Request $request) {
    $ids = $request->input('ids');

    if ($ids) {
        $idsArray = explode(',', $ids); // Convertir la chaîne d'IDs en tableau
        Projet::destroy($idsArray); // Supprimer les désignations par leurs IDs
        return redirect()->back()->with('success', 'Désignations supprimées avec succès.');
    }

    return redirect()->back()->with('error', 'Aucun ID fourni.');
}


}
