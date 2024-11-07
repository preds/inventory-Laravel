<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function showCategoryManagementPage(Request $request) {

        $query = Category::query();
        // Récupérer les variables pour le filtrage du tableau

        $categories=Category::All();
        // $categories = Category::where('deleted', false)->get();
        //recuperer les photos
        $medias = Media::where('deleted', false)->get();
        // Retourner la vue avec les données nécessaires
        return view('clients.categoryManagement', compact('categories','medias'));
    }

    public function addNewCategoryInDb(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'categoryName' => 'required|string|max:255',
            'photo_id' => 'required|exists:media,id', // Assurez-vous que l'ID de l'image existe dans la table des médias
        ]);

        // Convertir le nom de la catégorie en minuscule pour garantir l'unicité
        $normalizedCategoryName = strtolower($validatedData['categoryName']);

        // Vérifier si la catégorie existe déjà (indépendamment de la casse)
        $existingCategory = Category::whereRaw('LOWER(category_name) = ?', [$normalizedCategoryName])->first();

        if ($existingCategory) {
            return redirect('/categoryManagement')->with('error', 'Category already exists.')->withInput();
        }

        DB::beginTransaction();

        try {
            // Création d'une nouvelle instance de modèle Category
            $category = new Category();
            $category->category_name = $normalizedCategoryName;
            $category->photo_id = $validatedData['photo_id']; // Stockez l'ID de l'image
            $category->save();

            DB::commit();

            return redirect('/categoryManagement')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/categoryManagement')->with('error', 'Failed to create category. Please try again.')->withInput();
        }
    }


    public function showUpdateExistingCategoryPage(Request $request)
{
    // Récupérer l'ID de la catégorie depuis la requête
    $categoryId = $request->input('id');

    // Récupérer la catégorie en fonction de l'identifiant
    $category = Category::find($categoryId);

    // Vérifier si la catégorie existe
    if (!$category) {
        // Rediriger vers une page d'erreur ou renvoyer une réponse avec un message d'erreur
        return redirect()->route('clients.UpdateExistingCategory')->with('error', 'Category non trouvé.');
    }

    // Récupérer toutes les images disponibles
    $medias = Media::all();
    $categories=Category::all();

    // Passer les données de la catégorie et des médias à la vue de la page de modification
    return view('clients.UpdateExistingCategory', compact('category', 'medias','categories'));
}


public function updateCategory(Request $request, $id)
{
    // Valider les données de la requête
    $validatedData = $request->validate([
        'categoryName' => 'required|string|max:255',
        'photo_id' => 'nullable|exists:media,id', // Assurez-vous que l'id de l'image existe dans la table des médias
    ]);

    // Récupérer la catégorie existante
    $category = Category::findOrFail($id);

    // Mettre à jour le nom de la catégorie
    $category->category_name = $validatedData['categoryName'];

    // Mettre à jour l'image associée à la catégorie si une nouvelle image est sélectionnée
    if ($request->has('photo_id')) {
        $category->photo_id = $validatedData['photo_id'];
    }

    // Sauvegarder les changements
    $category->save();

    // Rediriger avec un message de succès
    return redirect()->route('category.showUpdateExistingCategoryPage', ['id' => $id])->with('success', 'Category updated successfully');
}

public function showdeletedCategoryPage(Request $request) {


    // Récupérer tous les assets supprimés et charger la relation category
    $deletedCategories = Category::where('deleted', true)->get();

    $medias = Media::where('deleted', false)->get();



    return view('clients.deletedCategory', compact('deletedCategories', 'medias'));
}



public function edit($id)
{
    $asset = Asset::find($id);
    return view('clients.updateExistingAssets', compact('asset'));
}


public function deleteCategory(Request $request) {
    $categoryId = $request->input('id');

    // Trouver la catégorie dans la base de données
    $category = Category::find($categoryId);

    // Vérifier si la catégorie existe
    if ($category) {
        // Supprimer la catégorie de la base de données
        $category->delete();

        return redirect()->route('category.showCategoryManagementPage')->with('success', 'Category deleted successfully');
    } else {
        return redirect()->route('category.showCategoryManagementPage')->with('error', 'Category deleted failed');
    }
}


    public function restoreCategory(Request $request)
{
    $category = Category::find($request->id);

    if ($category) {
        $category->deleted = !$category->deleted; // Inverse l'état de suppression de la catégorie
        $category->save();
        return response()->json(['success' => true, 'deleted' => $category->deleted]);
    }

    return response()->json(['success' => false, 'message' => 'Category not found.']);
}

    public function changeCategory(Request $request)
{
    $categoryId = $request->input('id');
    $category = Category::find($categoryId);

    if ($category) {
        // Inverser le statut de la catégorie
        $category->active = !$category->active;
        $category->save();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Category not found.']);
}


public function toggleStatus(Request $request)
{
    Log::info('toggleStatus called with ID: ' . $request->id);

    $category = Category::find($request->id);

    if (!$category) {
        Log::error('Category not found with ID: ' . $request->id);
        return redirect()->route('category.showCategoryManagementPage')->with('error', 'Category not found');
    }

    $category->active = !$category->active;
    $category->save();

    Log::info('Category status updated. New status: ' . ($category->active ? 'Active' : 'Inactive'));

    return redirect()->route('category.showCategoryManagementPage')->with('success', 'Category status updated successfully');
}

public function restoreOrDeleteCategory(Request $request)
{
    Log::info('restoreOrDeleteCategory called with ID: ' . $request->id . ' and action: ' . $request->action);

    $category = Category::find($request->id);
    if (!$category) {
        Log::error('Category not found with ID: ' . $request->id);
        return redirect()->route('category.showCategoryManagementPage')->with('error', 'Category not found');
    }

    if ($request->action == 'delete') {
        $category->deleted = true;
        $category->active = False;
        Log::info('Category marked as deleted with ID: ' . $request->id);
    } else if ($request->action == 'restore') {
        $category->deleted = false;
        $category->active = True;
        Log::info('Category restored with ID: ' . $request->id);
    }
    $category->save();

    return redirect()->route('category.showCategoryManagementPage')->with('success', 'Category restored successfully');
}

public function deleteMultipleCategories(Request $request)
{
    $ids = explode(',', $request->input('ids'));
    DB::table('categories')->whereIn('id', $ids)->delete();

    return redirect()->route('category.showCategoryManagementPage')->with('success', 'Les catégories sélectionnées ont été supprimées.');
}

}
