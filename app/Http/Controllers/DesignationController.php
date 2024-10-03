<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DesignationsImport;

class DesignationController extends Controller
{


    // public function showAddDesignationPage(Request $request) {
    //     $perPage = $request->get('perPage', 10); // Nombre d'items par page, par défaut 10
    //     $designations = Designation::paginate($perPage);
    //
    // }

    public function showAddDesignationPage(Request $request) {
        $perPage = $request->get('perPage', 10); // Nombre d'items par page, par défaut 10
        $search = $request->get('search');
        $searchField = $request->get('search_field', 'all'); // Search field: all, designation, description, or code

        $query = Designation::query();

        // Apply search conditions
        if ($search) {
            if ($searchField === 'all') {
                $query->where('designation_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('abbreviation_code', 'like', '%' . $search . '%');
            } else {
                $query->where($searchField, 'like', '%' . $search . '%');
            }
        }

        // Paginate the results
        $designations = $query->paginate($perPage);

        return view('administration.addNewDesignation', compact('designations'));
    }


    public function getDesignationById($id)
    {
        // Recherchez la désignation par ID
        $designation = Designation::find($id);

        // Vérifiez si la désignation existe
        if ($designation) {
            return response()->json(['designation_name' => $designation->designation_name]);
        } else {
            return response()->json(['error' => 'Designation not found'], 404);
        }
    }
    public function add(Request $request) {
        // Validation des données
        $request->validate([
            'designation_name' => 'required|string|max:255|unique:designations,designation_name',
            'description' => 'nullable|string|max:255:designations,description',
            'abbreviation_code' => 'required|string|max:255|unique:designations,abbreviation_code',
        ]);

        // Transformation des données
        $designationName = ucfirst(strtolower($request->designation_name));
        $abbreviationCode = strtoupper($request->abbreviation_code);

        // Création de la désignation
        Designation::create([
            'designation_name' => $designationName,
            'description' => $request->description,
            'abbreviation_code' => $abbreviationCode,
        ]);

        return redirect()->back()->with('success', 'Désignation ajoutée avec succès.');
    }


    public function import(Request $request) {
        $request->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new DesignationsImport, $request->file('excelFile'));

        return redirect()->back()->with('success', 'Désignations importées avec succès.');
    }

    public function toggleStatus(Request $request) {
        $designation = Designation::find($request->id);
        $designation->active = !$designation->active;
        $designation->save();

        return redirect()->back();
    }

    public function delete(Request $request) {
        $designation = Designation::find($request->id);
        $designation->delete();

        return redirect()->back()->with('success', 'Désignation supprimée avec succès.');
    }

   public function deleteMultiple(Request $request) {
    $ids = $request->input('ids');

    if ($ids) {
        $idsArray = explode(',', $ids); // Convertir la chaîne d'IDs en tableau
        Designation::destroy($idsArray); // Supprimer les désignations par leurs IDs
        return redirect()->back()->with('success', 'Désignations supprimées avec succès.');
    }

    return redirect()->back()->with('error', 'Aucun ID fourni.');
}


}
