<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Category;
use App\Models\Media;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    
        // Construire la requête de base avec les relations category et les filtres
        $query = Asset::with('category')->where('deleted', false);
    
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
    
        // Filtrer les actifs amortis et non amortis
        $query->where(function ($q) {
            $q->where('amortis', true)
                ->orWhereNull('date_achat')
                ->orWhere('date_achat', '>', now());
        });
    
        // Récupérer les assets paginés
        $assetData = $query->paginate($perPage);
    
        // Récupérer les variables à afficher dans les cartes du tableau de bord
        $totalUsers = User::count();
        $totalCategories = Category::where('active', true)->orWhere('deleted', true)->count();
    
        // Récupérer les données sur la répartition des actifs par catégorie
        $assetsData = Asset::join('categories', 'categories.id', '=', 'assets.category_id')
            ->where('assets.deleted', false)
            ->select('categories.category_name as category', \DB::raw('count(assets.id) as total'))
            ->groupBy('categories.category_name')
            ->get();
    
        $assetsLabels = $assetsData->pluck('category')->toArray();
        $assetsValues = $assetsData->pluck('total')->toArray();
    
        // Récupérer les données sur la répartition des actifs par état
        $assetsStateData = Asset::select('etat', \DB::raw('count(id) as total'))
            ->where('deleted', false)
            ->groupBy('etat')
            ->get();
    
        $assetsStateLabels = $assetsStateData->pluck('etat')->toArray();
        $assetsStateValues = $assetsStateData->pluck('total')->toArray();
    


        $amortizationData = DB::table('assets')
        ->join('categories', 'categories.id', '=', 'assets.category_id')
        ->where('assets.deleted', false)
        ->select('categories.category_name as category',
            DB::raw("sum(case when assets.amortis = true then 1 else 0 end) as amorti"),
            DB::raw("sum(case when assets.amortis = false then 1 else 0 end) as non_amorti"),
            DB::raw("sum(case when assets.date_achat is null or assets.date_achat > now() then 1 else 0 end) as date_invalide")
        )
        ->groupBy('categories.category_name')
        ->get()
        ->keyBy('category')
        ->map(function ($item) {
            return [
                'amorti' => $item->amorti,
                'non_amorti' => $item->non_amorti,
                'date_invalide' => $item->date_invalide
            ];
        })
        ->toArray();
    
        // Récupérer les logs de requêtes pour vérifier la requête SQL exécutée
    
    
        $amortizedCount = array_sum(array_column($amortizationData, 'amorti'));
        $notAmortizedCount = array_sum(array_column($amortizationData, 'non_amorti'));
    
        $amortizationLabels = ['Amorti', 'Non Amorti'];
        $amortizationValues = [$amortizedCount, $notAmortizedCount];
    
        // Récupérer les actifs supprimés par l'utilisateur authentifié
        $authUser = auth()->user();
    
        $userDeletedAssets = 0; // Initialisation
    
        // Vérifier le niveau d'autorisation de l'utilisateur
        if ($authUser->group && $authUser->group->level === 'Administrator') {
            // Si l'utilisateur est administrateur, récupérer tous les actifs supprimés
            $totals = Asset::selectRaw('count(id) as totalAssets, sum(deleted) as totalDeletedAssets')->first();
            $userDeletedAssets = Asset::where('deleted', true)->count();
        } else {
            // Sinon, récupérer seulement les actifs supprimés par l'utilisateur
            $totals = Asset::selectRaw('count(id) as totalAssets')->first();
            $userDeletedAssets = Asset::where('deleted', true)->where('deleted_by', $authUser->id)->count();
        }
    
        // Retourner la vue avec les données nécessaires
        return view('clients.home', compact(
            'assetsLabels', 'assetsValues',
            'assetsStateLabels', 'assetsStateValues',
            'assetData', 'totalUsers', 'totals',
            'totalCategories',
            'perPage', 'category', 'location', 'etat',
            'amortizationLabels', 'amortizationValues',
            'amortizationData', // Nouvelle variable pour les détails de l'amortissement
            'userDeletedAssets' // Nouvelle variable pour les actifs supprimés par l'utilisateur
        ));
    }
    
    
    
 
    public function showHomeClientPage () {
        return view('clients.homeClient');
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

}
