<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Media;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // fonction d'afichage de page
    


    public function showHomePage(Request $request)
{
    // Récupérer les paramètres de pagination et de filtrage
    $perPage = $request->input('perPage', 10);
    $category = $request->input('category');
    $location = $request->input('location');
    $etat = $request->input('etat');

    // Construire la requête de base avec la relation category
    $query = Asset::with('category')->where('deleted', false);

    // Appliquer les filtres
    if ($category) {
        $query->whereHas('category', function ($q) use ($category) {
            $q->where('category_name', $category);
        });
    }
    if ($location) {
        $query->where('localisation', $location);
    }
    if ($etat) {
        $query->where('etat', $etat);
    }

    // Récupérer les assets paginés
    $assets = $query->paginate($perPage);

    // Récupérer les variables à afficher dans les cartes du tableau de bord
    $totalAssets = Asset::where('deleted', false)->count();
    $totalCategories = Category::count();
    $totalDeletedAssets = Asset::where('deleted', true)->count();

    // Récupérer les variables pour le filtrage du tableau
    $categories = Category::all();
    $locations = Asset::where('deleted', false)->pluck('localisation')->unique();
    $etats = Asset::where('deleted', false)->pluck('etat')->unique();

    // Retourner la vue avec les données nécessaires
    return view('clients.home', compact('assets', 'totalAssets', 'totalCategories', 'totalDeletedAssets', 'categories', 'locations', 'etats', 'perPage', 'category', 'location', 'etat'));
}

    

    

    
    //  public function deletedAssets() {
    //     // Récupérer les assets supprimés depuis la base de données
    //     $deletedAssets = Asset::where('deleted', true)->get();
    //     // Vous pouvez également réutiliser les variables récupérées dans la méthode home ici si nécessaire
    //     $categories = Asset::where('deleted', true)->select('category')->distinct()->pluck('category');
    //     $locations = Asset::where('deleted', true)->select('localisation')->distinct()->pluck('localisation');
    //     $etats = Asset::where('deleted', true)->select('etat')->distinct()->pluck('etat');
    //     // Retourner la vue clients.deletedAsset avec les données nécessaires
    //     return view('clients.deletedAsset', compact('deletedAssets', 'categories', 'locations', 'etats'));
    // }

    // public function deletedAssets() {
    //     // Récupérer les assets supprimés depuis la base de données
    //     $deletedAssets = Asset::where('deleted', true)->get();
    //     // Vous pouvez également réutiliser les variables récupérées dans la méthode home ici si nécessaire
    //     $categories = Asset::where('deleted', true)->select('category')->distinct()->pluck('category');
    //     $locations = Asset::where('deleted', true)->select('localisation')->distinct()->pluck('localisation');
    //     $etats = Asset::where('deleted', true)->select('etat')->distinct()->pluck('etat');
    //     // Retourner la vue clients.deletedAsset avec les données nécessaires
    //     return view('clients.deletedAsset', compact('deletedAssets', 'categories', 'locations', 'etats'));
    // }
    
    public function showUserManagementPage () {

        $groups=Group::where('status', true)->get();
        $users = User::all();
  
        return view('clients.userManagement',compact('groups','users'));
    }

    public function userManagement () {
        return view('clients.userManagement');
    }
    public function groupManagement () {
        return view('clients.groupManagement');
    }
    public function categoryManagement () {
        return view('clients.categoryManagement');
    }
    public function assetManagement () {
        return view('clients.assetManagement');
    }

   public function UpdateExistingAsset($id)
    {
        // Récupérer l'actif en fonction de l'identifiant
        $asset = Asset::find($id);

        // Vérifier si l'actif existe
        if (!$asset) {
            // Rediriger vers une page d'erreur ou renvoyer une réponse avec un message d'erreur
            return redirect()->route('clients.home')->with('error', 'Actif non trouvé.');
        }

        // Passer les données de l'actif à la vue de la page de modification
        $categories = Asset::select('category')->distinct()->pluck('category');
        $locations = Asset::select('localisation')->distinct()->pluck('localisation');
        $etats = Asset::select('etat')->distinct()->pluck('etat');

        return view('clients.UpdateExistingAssets', compact('asset', 'categories', 'locations', 'etats'));
    }

    

    
    public function restore(Request $request)
    {
        // Récupérer l'ID de l'asset à restaurer depuis la requête
        $assetId = $request->input('asset_id');

        // Rechercher l'asset correspondant dans la base de données
        $asset = Asset::findOrFail($assetId);

        // Mettre à jour le champ 'deleted' de l'asset à false pour le restaurer
        $asset->deleted = false;
        $asset->save();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'L\'asset a été restauré avec succès.');
    }




    // public function AddAssetManagement () {
    //     // return view('clients.AddAssetManagement');
    //     return view('clients.addAssetManagement', compact('assets')); // la variable asset est appeler grace a la ligne use App\Models\Asset;
    // }

      // public function AddAssetManagement () {
    //     return view('clients.AddAssetManagement');
    // }
  
    public function login () {
        return view('clients.login');
    }
      
    public function register () {
        return view('clients.register');
    }
    public function  requestPassword () {
        return view('clients.register');
    }
   
    public function UpdateUsersInformations () {
        return view('clients.UpdateUsersInformations');
    }

    public function UpdateGroupsInformations () {
        return view('clients.UpdateGroupsInformations');
    }
    public function UpdateInformations () {
        return view('clients.UpdateInformations');
    }
  







     //fonction genere
    public function index()
    {
         // Nombre d'éléments par page par défaut
         $perPage = $request->input('perPage', 10); 
         $assets = Asset::where('deleted', false)->paginate($perPage);// Récupérer les assets qui ne sont pas supprimés
    return view('clients.home', compact('assets'));
        //
    }

    public function indexfordeletedasset()
    {
         // Nombre d'éléments par page par défaut
         $perPage = $request->input('perPage', 10); 
         $assets = Asset::where('deleted', true)->paginate($perPage);// Récupérer les assets qui ne sont pas supprimés
    return view('clients.deletedasset', compact('assets'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
