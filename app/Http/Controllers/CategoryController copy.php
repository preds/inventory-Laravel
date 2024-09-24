<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function showCategoryManagementPage(Request $request) {
   
        $query = Category::query();
        // Récupérer les variables pour le filtrage du tableau
   
        $categories=Category::all();
        // $categories = Category::where('deleted', false)->get();

        // Retourner la vue avec les données nécessaires
        return view('clients.categoryManagement', compact('categories'));
    }

    public function addNewCategoryInDb(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'categoryName' => 'required|string|unique:categories,category_name|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Création d'une nouvelle instance de modèle Category
            $category = new Category();
            $category->category_name = $validatedData['categoryName'];
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
        // Récupérer l'ID de l'actif depuis la requête
        $categoryId = $request->input('id'); 
    
        // Récupérer l'actif en fonction de l'identifiant
        $category = Category::find($categoryId); //recuperer la category qui a pour id categoryId recuperer dans le formulaire caché
     
        // Vérifier si l'actif existe
        if (!$category) {
            // Rediriger vers une page d'erreur ou renvoyer une réponse avec un message d'erreur
            return redirect()->route('clients.UpdateExistingCategory')->with('error', 'Category non trouvé.');
        }
    
        // Passer les données de l'actif à la vue de la page de modification
        // $categories = Category::select('category_name')->distinct()->pluck('category_name');
        $categories = Category::all();
    
        return view('clients.UpdateExistingCategory', compact('categories', 'category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->category_name = $request->categoryName;

        // Update other fields as needed
        $category->save();
    
        return redirect()->route('category.showUpdateExistingCategoryPage', ['id' => $id])->with('success', 'Category updated successfully');
    }
    
 

    public function deleteCategory(Request $request) {
        $categoryId = $request->input('id');
    
        // Trouver la catégorie dans la base de données
        $category = Category::find($categoryId);
    
        // Vérifier si la catégorie existe
        if ($category) {
            // Marquer la catégorie comme supprimée
            $category->deleted = true;
            $category->save(); // Sauvegarder les modifications dans la base de données
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function activateCategory(Request $request)
    {
        $category = Category::find($request->id);
    
        if ($category) {
            $category->active = true; // Assurez-vous que votre modèle Category a un attribut "active"
            $category->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
    
    public function toggleCategoryStatus(Request $request)
    {
        $category = Category::find($request->id);
    
        if ($category) {
            $category->active = !$category->active; // Inverse le statut de la catégorie
            $category->save();
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
}
