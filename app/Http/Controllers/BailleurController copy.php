<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bailleur;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BailleurImport;
use Illuminate\Support\Facades\Log;
class BailleurController extends Controller
{




    public function showAddBailleurPage(Request $request) {
        $perPage = $request->get('perPage', 10); // Nombre d'items par page, par défaut 10
        $search = $request->get('search');
        $searchField = $request->get('search_field', 'all'); // Search field: all, Bailleur, description, or code

        $query = Bailleur::query();

        // Apply search conditions
        if ($search) {
            if ($searchField === 'all') {
                $query->where('bailleur_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('abbreviation_code', 'like', '%' . $search . '%');
            } else {
                $query->where($searchField, 'like', '%' . $search . '%');
            }
        }

        // Paginate the results
        $bailleurs = $query->paginate($perPage);

        return view('administration.addNewBailleur', compact('bailleurs'));
    }


    public function getBailleurById($id)
    {
        // Recherchez la désignation par ID
        $bailleur = Bailleur::find($id);

        // Vérifiez si la désignation existe
        if ($bailleur) {
            return response()->json(['Bailleur_name' => $bailleur->bailleur_name]);
        } else {
            return response()->json(['error' => 'bailleur not found'], 404);
        }
    }
    public function add(Request $request) {
        // Validation des données
        $request->validate([
            'bailleur_name' => 'required|string|max:255|unique:bailleurs,bailleur_name',
            'description' => 'nullable|string|max:255',
            'abbreviation_code' => 'required|string|max:255|unique:bailleurs,abbreviation_code',
        ]);

        // Transformation des données
        $bailleurName = ucfirst(strtolower($request->bailleur_name));
        $abbreviationCode = strtoupper($request->abbreviation_code);

        // Création de la désignation
        Bailleur::create([
            'bailleur_name' => $bailleurName,
            'description' => $request->description,
            'abbreviation_code' => $abbreviationCode,
        ]);

        return redirect()->back()->with('success', 'Désignation ajoutée avec succès.');
    }


    // public function import(Request $request) {
    //     $request->validate([
    //         'excelFile' => 'required|mimes:xlsx,xls,csv',
    //     ]);

    //     Excel::import(new BailleurImport, $request->file('excelFile'));

    //     return redirect()->back()->with('success', 'Bailleurs importées avec succès.');
    // }


    // public function import(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'excelFile' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max size
    //         ]);
    
    //         Excel::import(new BailleurImport, $request->file('excelFile'));
    
    //         // Vérification : compte le nombre de bailleurs dans la DB
    //         $bailleursCount = Bailleur::count();
    
    //         return redirect()->back()->with('success', 'Bailleurs importées avec succès. Nombre de bailleurs enregistrés : ' . $bailleursCount);
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
            // Importer les données
            Excel::import(new BailleurImport, $request->file('excelFile'));
    
            return redirect()->back()->with('success', 'Bailleurs importées avec succès.');
        } catch (\Exception $e) {
            // Afficher un message d'erreur détaillé
            Log::error('Import error:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    
    public function toggleStatus(Request $request) {
        $bailleur = Bailleur::find($request->id);
        $bailleur->active = !$bailleur->active;
        $bailleur->save();

        return redirect()->back();
    }

    public function delete(Request $request) {
        $bailleur = Bailleur::find($request->id);
        $bailleur->delete();

        return redirect()->back()->with('success', 'Désignation supprimée avec succès.');
    }

   public function deleteMultiple(Request $request) {
    $ids = $request->input('ids');

    if ($ids) {
        $idsArray = explode(',', $ids); // Convertir la chaîne d'IDs en tableau
        Bailleur::destroy($idsArray); // Supprimer les désignations par leurs IDs
        return redirect()->back()->with('success', 'Désignations supprimées avec succès.');
    }

    return redirect()->back()->with('error', 'Aucun ID fourni.');
}


}
