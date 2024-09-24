<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetLog;
use App\Models\Category;
use App\Models\Media;
use App\Models\Designation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssetsExport;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Exports\LogsExport;

class AssetsController extends Controller
{
    // public function index()
    // {
    //      // Nombre d'éléments par page par défaut
    //      $perPage = $request->input('perPage', 10);
    //      $assets = Asset::where('deleted', false)->paginate($perPage);// Récupérer les assets qui ne sont pas supprimés
    // return view('clients.assetManagement', compact('assets'));
    //     //
    // }


    public function home2(Request $request)
    {
        // Retourner la vue avec les assets, catégories, localisations et états
        return view('simpleUsers.home2', compact('assets', 'categories', 'locations', 'etats'));
    }

    public function showAddAssetManagementPage(Request $request)
    {
        // Nombre d'éléments par page par défaut
        $perPage = $request->input('perPage', 5);

        // Récupérer les assets non supprimés et les trier par date d'achat décroissante avec pagination
        $lastAssets = Asset::where('deleted', false)
                           ->orderByDesc('created_at')
                           ->paginate($perPage);

        // Récupérer toutes les catégories actives
        $categories = Category::where('active', true)->get();

        // Récupérer les médias non supprimés
        $medias = Media::where('deleted', false)->get();
         // Récupérer toutes les désignations
        $designations = Designation::all();

        // Retourner la vue avec les données nécessaires
        return view('clients.addAssetManagement', compact('lastAssets', 'categories', 'medias', 'designations'));
    }

    public function addNewAssetInDb(Request $request)
    {
        // Mapping des options d'état
        $etatMapping = [
            'Neuf' => 'Neuf',
            'Bon' => 'Bon',
            'Passable' => 'Passable',
            'À Réparer' => 'A_Reparer',
            'À Déclasser' => 'A_Declasser',
            'Hors Service Bon' => 'Hors_Service_Bon',
            'Hors Service' => 'Hors_Service',
        ];

        // Mapping des catégories avec les années d'amortissement
        $amortizationCategories = [
            3 => 3,  // Matériel informatique
            // Ajoutez d'autres catégories avec leurs années d'amortissement ici
        ];

        // Valider les données de la requête
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'localisation' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie_ou_chassis' => 'nullable|string|max:255',
            'etat' => 'required|string|max:255',
            'situation_exacte_du_materiel' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'nullable|date',
            'valeur' => 'nullable|numeric|min:0',
            'numero_piece_comptables' => 'nullable|string|max:255',
            'fournisseur' => 'nullable|string|max:255',
            'bailleur' => 'nullable|string|max:255',
            'projet' => 'nullable|string|max:255',
            'date_de_sortie' => 'nullable|date',
            'codification' => 'nullable|string|max:255',
        ]);

        // Déboguer la valeur de category_id
        // dd($request->input('category_id'));

        // Remplacer les champs non renseignés par null
        foreach ($validatedData as $key => $value) {
            if ($value === '') {
                $validatedData[$key] = null;
            }
        }

        // Utiliser le mapping pour obtenir l'état simplifié
        $validatedData['etat'] = $etatMapping[$request->input('etat')];

        // Calculer si l'asset est amorti en fonction de sa catégorie et de la date d'achat
        $validatedData['amortis'] = 0; // Par défaut, non amorti
        if ($request->filled('date_achat')) {
            $categoryId = $request->input('category_id');
            $amortizationYears = $amortizationCategories[$categoryId] ?? 5; // Par défaut, 5 ans pour les catégories non spécifiées

            $dateAchat = \Carbon\Carbon::parse($request->input('date_achat'));
            $currentDate = now();
            $yearsDifference = $dateAchat->diffInYears($currentDate);

            // Marquer l'asset comme amorti si nécessaire
            if ($yearsDifference >= $amortizationYears) {
                $validatedData['amortis'] = 1;
            }
        }

        DB::beginTransaction();

        try {
            // Créer un nouvel asset avec les données validées
            $asset = new Asset($validatedData);
            $asset->save();

            // Enregistrer l'activité
            AssetLog::create([
                'user_id' => Auth::id(),
                'asset_id' => $asset->id,
                'action' => 'create',
                'description' => 'Asset created',
            ]);

            DB::commit();

            return redirect('/AddAssetManagement')->with('success', 'Asset created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage()); // Affiche le message d'erreur complet
            return redirect('/AddAssetManagement')->with('error', 'Failed to create asset. Please try again.')->withInput();
        }
    }

    public function getLatestSequenceNumber() {
        // Récupération du dernier enregistrement trié par ID décroissant
        $latestAsset = Asset::orderBy('id', 'desc')->first();
        $latestSequenceNumber = 0;

        if ($latestAsset) {
            // Extraction du numéro de séquence de la dernière codification
            $codificationParts = explode('/', $latestAsset->codification);
            // Le numéro de séquence est la dernière partie de la codification
            $latestSequenceNumber = (int)end($codificationParts);
        }

        // Renvoi du prochain numéro de séquence
        return response()->json(['sequenceNumber' => $latestSequenceNumber + 1]);
    }


//     public function showAssetManagementPage(Request $request)
// {
//     // Nombre d'éléments par page par défaut
//     $perPage = $request->input('perPage', 5);

//     // Récupérer l'utilisateur connecté et son niveau d'accès
//     $user = auth()->user();
//     $groupName = $user->group->level; // Récupérer le nom du groupe de l'utilisateur

//     // Construire la requête avec les conditions de filtrage
//     $query = Asset::where('deleted', false)->with('category.media');

//     // Appliquer les filtres s'ils sont présents
//     $filters = [
//         'category' => $request->input('category'),
//         'location' => $request->input('location'),
//         'etat' => $request->input('etat'),
//     ];

//     foreach ($filters as $key => $value) {
//         if ($value && $request->has($key)) {
//             $query->where($key, $value);
//         }
//     }

//     // Récupérer les assets paginés
//     $assets = $query->paginate($perPage);

//     // Récupérer les catégories avec leurs médias associés
//     $categories = Category::with('media')->get();

//     // Récupérer les localisations distinctes
//     $locations = Asset::distinct()->pluck('localisation');

//     // Récupérer les états distincts
//     $etats = Asset::distinct()->pluck('etat');

//     // Retourner la vue avec les assets, catégories, localisations et états, et le niveau d'accès de l'utilisateur
//     return view('clients.assetManagement', compact('assets', 'categories', 'locations', 'etats', 'groupName', 'user'));
// }
public function showAssetManagementPage(Request $request)
{
    // Nombre d'éléments par page par défaut
    $perPage = $request->input('perPage', 5);

    // Récupérer l'utilisateur connecté et son niveau d'accès
    $user = auth()->user();
    $groupName = $user->group->level; // Récupérer le nom du groupe de l'utilisateur

    // Construire la requête avec les conditions de filtrage
    $query = Asset::where('deleted', false)->with('category.media');

    // Appliquer les filtres s'ils sont présents
    $filters = [
        'category' => $request->input('category'),
        'location' => $request->input('location'),
        'etat' => $request->input('etat'),
    ];

    foreach ($filters as $key => $value) {
        if ($value && $request->has($key)) {
            $query->where($key, $value);
        }
    }

    // Rechercher en fonction du champ sélectionné
    $search = $request->input('search');
    $searchField = $request->input('search_field', 'all'); // Par défaut, rechercher dans tous les champs

    if ($search) {
        if ($searchField === 'all') {
            $query->where(function ($query) use ($search) {
                $query->where('designation', 'like', "%$search%")
                    ->orWhere('marque', 'like', "%$search%")
                    ->orWhere('modele', 'like', "%$search%")
                    ->orWhere('codification', 'like', "%$search%")
                    ->orWhere('responsable', 'like', "%$search%")
                    ->orWhere('etat', 'like', "%$search%")
                    ->orWhere('numero_serie_ou_chassis', 'like', "%$search%");
                // Ajoutez d'autres champs si nécessaire
            });
        } else {
            $query->where($searchField, 'like', "%$search%");
        }
    }

    // Récupérer les assets paginés
    $assets = $query->paginate($perPage);

    // Récupérer les catégories avec leurs médias associés
    $categories = Category::with('media')->get();

    // Récupérer les localisations distinctes
    $locations = Asset::distinct()->pluck('localisation');

    // Récupérer les états distincts
    $etats = Asset::distinct()->pluck('etat');

    // Retourner la vue avec les assets, catégories, localisations et états, et le niveau d'accès de l'utilisateur
    return view('clients.assetManagement', compact('assets', 'categories', 'locations', 'etats', 'groupName', 'user'));
}


public function filterAssets(Request $request)
{
    $query = Asset::query();

    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    if ($request->has('location') && $request->location != '') {
        $query->where('localisation', 'like', '%' . $request->location . '%');
    }

    if ($request->has('etat') && $request->etat != '') {
        $query->where('etat', $request->etat);
    }

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('designation', 'like', '%' . $search . '%')
            ->orWhere('localisation', 'like', '%' . $search . '%')
            ->orWhere('marque', 'like', '%' . $search . '%')
              ->orWhere('modele', 'like', '%' . $search . '%')
              ->orWhere('numero_serie_ou_chassis', 'like', '%' . $search . '%')
              ->orWhere('situation_exacte_du_materiel', 'like', '%' . $search . '%')
              ->orWhere('responsable', 'like', '%' . $search . '%')
              ->orWhere('quantite', 'like', '%' . $search . '%')
              ->orWhere('valeur', 'like', '%' . $search . '%')
              ->orWhere('numero_piece_comptables', 'like', '%' . $search . '%')
              ->orWhere('fournisseur', 'like', '%' . $search . '%')
              ->orWhere('bailleur', 'like', '%' . $search . '%')
              ->orWhere('codification', 'like', '%' . $search . '%');
        });
    }

      // Assurez-vous de charger les relations entre categorie et media
    // $assets = $query->get();
    $assets = $query->with('category.media')->get();

    return response()->json($assets);
}


public function filterAssetsforAssetManagment(Request $request)
{
    $query = Asset::query();

    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }

    if ($request->has('location') && $request->location != '') {
        $query->where('localisation', 'like', '%' . $request->location . '%');
    }

    if ($request->has('etat') && $request->etat != '') {
        $query->where('etat', $request->etat);
    }

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('designation', 'like', '%' . $search . '%')
              ->orWhere('marque', 'like', '%' . $search . '%')
              ->orWhere('localisation', 'like', '%' . $search . '%')
              ->orWhere('modele', 'like', '%' . $search . '%')
              ->orWhere('numero_serie_ou_chassis', 'like', '%' . $search . '%')
              ->orWhere('situation_exacte_du_materiel', 'like', '%' . $search . '%')
              ->orWhere('responsable', 'like', '%' . $search . '%')
              ->orWhere('quantite', 'like', '%' . $search . '%')
              ->orWhere('valeur', 'like', '%' . $search . '%')
              ->orWhere('numero_piece_comptables', 'like', '%' . $search . '%')
              ->orWhere('fournisseur', 'like', '%' . $search . '%')
              ->orWhere('bailleur', 'like', '%' . $search . '%')
              ->orWhere('codification', 'like', '%' . $search . '%');
        });
    }

    // $assets = $query->get();
    $assets = $query->with('category.media')->get();
    return response()->json($assets);
}




public function filterDeletedAssets(Request $request)
{
    $query = Asset::where('deleted', true);

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('location')) {
        $query->where('localisation', $request->location);
    }

    if ($request->filled('etat')) {
        $query->where('etat', $request->etat);
    }

    $filterDeletedAssets = $query->get();

    return response()->json($filterDeletedAssets);
}


public function restoreAsset(Request $request)
{
    $assetId = $request->input('id');
    $asset = Asset::find($assetId);
    if ($asset) {
        $asset->deleted = false; // Restaurer l'actif
        $asset->save();

        // Enregistrer l'activité
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'restore',
            'description' => 'Asset restored',

        ]);

        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}
    public function edit($id)
    {
        $asset = Asset::find($id);
        return view('clients.updateExistingAssets', compact('asset'));
    }


    public function showUpdateExistingAssetsPage(Request $request)
{
    // Récupérer l'ID de l'actif depuis la requête
    $assetId = $request->input('id');

    // Récupérer tous les actifs avec leurs catégories et médias associés
    $assets = Asset::with(['category', 'category.media'])->get();

    // Récupérer l'actif spécifique en fonction de l'identifiant
    $asset = Asset::find($assetId);

    // Vérifier si l'actif existe
    if (!$asset) {
        // Rediriger vers une page d'erreur ou renvoyer une réponse avec un message d'erreur
        return redirect()->route('clients.home')->with('error', 'Actif non trouvé.');
    }

    // Récupérer toutes les catégories existantes
    $categoriesInDb = Category::all();

    // Récupérer tous les médias (images)
    $medias = Media::where('deleted', false)->get();
    // Récupérer toutes les désignations disponibles
    $designations = Designation::all();

    // Passer les données de l'actif et d'autres éléments à la vue de la page de modification
    return view('clients.UpdateExistingAssets', compact('asset', 'assets', 'categoriesInDb', 'medias','designations'));

}


public function updateAsset(Request $request, $id)
{
    $asset = Asset::findOrFail($id);

    // Récupérer les données originales avant mise à jour
    $originalData = $asset->toArray();

    // Mettre à jour les champs de l'actif
    $asset->update($request->all());

    // Enregistrer l'activité
    AssetLog::create([
        'user_id' => Auth::id(),
        'asset_id' => $asset->id,
        'action' => 'update',
        'description' => 'Asset updated',

    ]);

    // Rediriger avec un message de succès
    return redirect()->route('assets.showUpdateExistingAssetsPage', ['id' => $id])->with('success', 'Asset updated successfully');
}

public function deleteAsset(Request $request)
{
    $assetId = $request->input('id');
    $asset = Asset::find($assetId);

    if ($asset) {
        $asset->deleted = true; // Mark the asset as deleted
        $asset->deleted_by = Auth::id(); // Save the user who deleted the asset
        $asset->save(); // Save the changes

        // Record the activity
        AssetLog::create([
            'user_id' => Auth::id(),
            'asset_id' => $asset->id,
            'action' => 'delete',
            'description' => 'Asset deleted',
        ]);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}



public function showDeletedAssetsPage(Request $request)
{
    $perPage = $request->input('perPage', 5);
    $user = Auth::user();

    // Base query for deleted assets
    $query = Asset::where('deleted', true)->with('category');

    // If the user is not an administrator, filter the assets deleted by the user
    if ($user->group && $user->group->level !== 'Administrator') {
        $query->where('deleted_by', $user->id);
    }

    // Paginate the deleted assets
    $numberOfDeletedAssets = $query->paginate($perPage);

    // Get all the deleted assets for filtering purposes
    $deletedAssets = $query->get();

    // Get distinct categories of deleted assets
    $categories = Category::whereHas('assets', function($query) use ($user) {
        $query->where('deleted', true);
        if ($user->group && $user->group->level !== 'Administrator') {
            $query->where('deleted_by', $user->id);
        }
    })->pluck('category_name');

    // Get distinct locations of deleted assets
    $locations = Asset::where('deleted', true)
        ->when($user->group && $user->group->level !== 'Administrator', function($query) use ($user) {
            return $query->where('deleted_by', $user->id);
        })
        ->select('localisation')
        ->distinct()
        ->pluck('localisation');

    // Get distinct states of deleted assets
    $etats = Asset::where('deleted', true)
        ->when($user->group && $user->group->level !== 'Administrator', function($query) use ($user) {
            return $query->where('deleted_by', $user->id);
        })
        ->select('etat')
        ->distinct()
        ->pluck('etat');

    // Return the view with the necessary data
    return view('clients.deletedAsset', compact('numberOfDeletedAssets', 'deletedAssets', 'categories', 'locations', 'etats'));
}


public function search(Request $request)
{
    $query = $request->get('query', '');
    $assets = Asset::where('designation', 'like', '%' . $query . '%')
        ->orWhere('marque', 'like', '%' . $query . '%')
        ->orWhere('modele', 'like', '%' . $query . '%')
        ->orWhere('localisation', 'like', '%' . $query . '%')
        ->get();

    return response()->json($assets);
}

public function searcha(Request $request)
{
    $query = $request->input('query');

    $assets = Asset::with(['category.media'])
        ->where('localisation', 'LIKE', "%{$query}%")
        ->orWhere('name', 'LIKE', "%{$query}%")
        ->orWhere('designation', 'LIKE', "%{$query}%")
        ->orWhere('marque', 'LIKE', "%{$query}%")
        ->orWhere('modele', 'LIKE', "%{$query}%")
        ->orWhere('numero_serie_ou_chassis', 'LIKE', "%{$query}%")
        ->orWhere('etat', 'LIKE', "%{$query}%")
        ->orWhere('situation_exacte_du_materiel', 'LIKE', "%{$query}%")
        ->orWhere('responsable', 'LIKE', "%{$query}%")
        ->orWhere('quantite', 'LIKE', "%{$query}%")
        ->orWhere('valeur', 'LIKE', "%{$query}%")
        ->orWhere('numero_piece_comptables', 'LIKE', "%{$query}%")
        ->orWhere('fournisseur', 'LIKE', "%{$query}%")
        ->orWhere('bailleur', 'LIKE', "%{$query}%")
        ->orWhere('codification', 'LIKE', "%{$query}%")
        ->get();

    return response()->json($assets);
}



// public function exportExcel(Request $request)
// {
//     $category = $request->input('category');
//     $location = $request->input('location');
//     $etat = $request->input('etat');
//     $search = $request->input('search');

//     return Excel::download(new AssetsExport($category, $location, $etat, $search), 'assets.xlsx');
// }

public function exportExcel(Request $request)
{
    $category = $request->input('category');
    $location = $request->input('location');
    $etat = $request->input('etat');
    $search = $request->input('search');
    $searchField = $request->input('search_field', 'all');

    return Excel::download(new AssetsExport($category, $location, $etat, $search, $searchField), 'assets.xlsx');
}

public function filter(Request $request)
{
    $query = Asset::query();

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('location')) {
        $query->where('location_id', $request->location);
    }

    if ($request->filled('etat')) {
        $query->where('etat', $request->etat);
    }

    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('label', 'like', '%'.$request->search.'%')
              ->orWhere('description', 'like', '%'.$request->search.'%')
              ->orWhere('price', 'like', '%'.$request->search.'%');
        });
    }

    $assets = $query->with(['category', 'location'])->get();

    $states = $assets->groupBy('etat')->map(function ($items, $key) {
        return ['etat' => $key, 'count' => $items->count()];
    })->values();

    $locations = $assets->groupBy('location.name')->map(function ($items, $key) {
        return ['name' => $key, 'count' => $items->count()];
    })->values();

    return response()->json([
        'assets' => $assets,
        'states' => $states,
        'locations' => $locations,
    ]);
}

//gestion des logs
public function showActivityLogs(Request $request)
{
    $perPage = $request->input('perPage', 5); // Nombre d'éléments par page par défaut
    $logs = AssetLog::with('user', 'asset')
        ->orderBy('created_at', 'desc')
        ->paginate($perPage); // Utilisation de paginate pour paginer les résultats
    return view('clients.activityLogs', compact('logs'));
}

public function deleteMultipleLogs(Request $request)
{
    $ids = explode(',', $request->input('ids'));
    DB::table('asset_logs')->whereIn('id', $ids)->delete();

    return redirect()->route('logs.index')->with('success', 'Les logs sélectionnés ont été supprimés.');
}


public function filterLogsByDate(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Valider et formater les dates si nécessaire
    $logs = AssetLog::whereBetween('created_at', [$startDate, $endDate])
                ->with('user', 'asset')
                ->get();

    return response()->json($logs); // Retourner les logs sous forme JSON
}





public function index()
    {
        // Récupérer les logs d'activités paginés
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(10); // paginer par 10 éléments par page
        return view('clients.activityLogs', compact('logs'));
    }




    public function exportLogExcel(Request $request)
{
    return Excel::download(new LogsExport, 'logs.xlsx');
}


  // Méthode pour afficher les actifs amortis
    public function showAmortized(Request $request)
    {
        // Récupérer les paramètres de pagination et de filtrage
        $perPage = $request->input('perPage', 5);
        $category = $request->input('category');
        $locationFilter = $request->input('locationFilter');
        $etatFilter = $request->input('etatFilter');

        // Préparer la requête pour récupérer les actifs amortis
        $query = Asset::where('amortis', true); // Filtrer les actifs qui sont amortis

        // Filtrer par catégorie si spécifié
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('category_name', $category);
            });
        }

        // Filtrer par localisation si spécifié
        if ($locationFilter) {
            $query->where('localisation', $locationFilter);
        }

        // Filtrer par état si spécifié
        if ($etatFilter) {
            $query->where('etat', $etatFilter);
        }

        // Paginer les résultats
        $amortizedAssets = $query->paginate($perPage);

        // Récupérer le groupe de l'utilisateur connecté
        $user = Auth::user();
        $groupName = $user->isAdmin() ? 'Administrator' : 'Simple User';

        // Récupérer la liste des localisations et des états pour les filtres
        $locations = Asset::distinct('localisation')->pluck('localisation');
        $etats = Asset::distinct('etat')->pluck('etat');

        // Passez les données à la vue appropriée
        return view('clients.amortized', [
            'amortizedAssets' => $amortizedAssets,
            'perPage' => $perPage,
            'category' => $category,
            'locationFilter' => $locationFilter,
            'etatFilter' => $etatFilter,
            'locations' => $locations,
            'etats' => $etats,
            'groupName' => $groupName, // Passer le nom du groupe à la vue
            'user'=> $user,
        ]);
    }

    public function showNonAmortized(Request $request)
    {
        // Récupérer les paramètres de pagination et de filtrage
        $perPage = $request->input('perPage', 5);
        $category = $request->input('category');
        $locationFilter = $request->input('locationFilter');
        $etatFilter = $request->input('etatFilter');

        // Préparer la requête pour récupérer les actifs non amortis
        $query = Asset::where('amortis', false); // Filtrer les actifs qui ne sont pas amortis

        // Filtrer par catégorie si spécifié
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('category_name', $category); // Assurez-vous que 'category_name' est bien le champ de la table 'categories'
            });
        }

        // Filtrer par localisation si spécifié
        if ($locationFilter) {
            $query->where('localisation', $locationFilter);
        }

        // Filtrer par état si spécifié
        if ($etatFilter) {
            $query->where('etat', $etatFilter);
        }

        // Paginer les résultats
        $nonAmortizedAssets = $query->paginate($perPage);

        // Récupérer le groupe de l'utilisateur connecté
        $user = Auth::user();
        $groupName = $user->isAdmin() ? 'Administrator' : 'Simple User';

        // Récupérer la liste des localisations et des états pour les filtres
        $locations = Asset::distinct('localisation')->pluck('localisation');
        $etats = Asset::distinct('etat')->pluck('etat');

        // Passez les données à la vue appropriée
        return view('clients.non_amortized', [
            'nonAmortizedAssets' => $nonAmortizedAssets,
            'perPage' => $perPage,
            'category' => $category,
            'locationFilter' => $locationFilter,
            'etatFilter' => $etatFilter,
            'locations' => $locations,
            'etats' => $etats,
            'groupName' => $groupName, // Passer le nom du groupe à la vue
            'user'=> $user,
        ]);
    }

    public function showInvalidAssets(Request $request)
    {
        // Récupérer les paramètres de pagination et de filtrage
        $perPage = $request->input('perPage', 5);
        $category = $request->input('category');
        $locationFilter = $request->input('locationFilter');
        $etatFilter = $request->input('etatFilter');

        // Récupérer la date actuelle pour comparaison
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');

        // Préparer la requête pour récupérer les actifs avec des données invalides (date d'achat non renseignée ou dans le futur)
        $query = Asset::where(function ($query) use ($currentDate) {
            $query->whereNull('date_achat') // Date d'achat non renseignée
            ->orWhere('date_achat', '>', $currentDate); // Date d'achat dans le futur
        });

        // Filtrer par catégorie si spécifié
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('category_name', $category); // Assurez-vous que 'category_name' est bien le champ de la table 'categories'
            });
        }

        // Filtrer par localisation si spécifié
        if ($locationFilter) {
            $query->where('localisation', $locationFilter);
        }

        // Filtrer par état si spécifié
        if ($etatFilter) {
            $query->where('etat', $etatFilter);
        }

        // Paginer les résultats
        $invalidAssets = $query->paginate($perPage);

        // Récupérer le groupe de l'utilisateur connecté
        $user = Auth::user();
        $groupName = $user->isAdmin() ? 'Administrator' : 'Simple User';

        // Récupérer la liste des localisations et des états pour les filtres
        $locations = Asset::distinct('localisation')->pluck('localisation');
        $etats = Asset::distinct('etat')->pluck('etat');

        // Passez les données à la vue appropriée
        return view('clients.invalidDate', [
            'invalidAssets' => $invalidAssets,
            'perPage' => $perPage,
            'category' => $category,
            'locationFilter' => $locationFilter,
            'etatFilter' => $etatFilter,
            'locations' => $locations,
            'etats' => $etats,
            'groupName' => $groupName, // Passer le nom du groupe à la vue
            'user'=> $user,
        ]);
    }

    public function checkAmortizationTask()
{
    // Vérifiez ici l'état de la tâche et récupérez les informations nécessaires
    // Par exemple, $success pourrait être un booléen indiquant si la tâche est configurée avec succès
    // $errors pourrait être un tableau d'erreurs ou de messages en cas d'échec

    $success = true; // Exemple, à remplacer par la vraie logique de vérification
    $errors = []; // Exemple, à remplacer par les vraies erreurs

    return view('clients.checkAmortizationTask', compact('success', 'errors'));
}



}



