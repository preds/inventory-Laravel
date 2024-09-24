<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Category;

class ChartController extends Controller
{
    public function getChartData(Request $request)
    {
        $category = $request->input('category');
        $location = $request->input('location');
        $etat = $request->input('etat');
        $search = $request->input('search');

        // Query to get total assets and deleted assets based on filters
        $assetsQuery = Asset::query();
        $deletedAssetsQuery = Asset::onlyTrashed();

        if ($category) {
            $assetsQuery->where('category_id', $category);
            $deletedAssetsQuery->where('category_id', $category);
        }

        if ($location) {
            $assetsQuery->where('location', $location);
            $deletedAssetsQuery->where('location', $location);
        }

        if ($etat) {
            $assetsQuery->where('etat', $etat);
            $deletedAssetsQuery->where('etat', $etat);
        }

        if ($search) {
            $assetsQuery->where('name', 'like', "%{$search}%");
            $deletedAssetsQuery->where('name', 'like', "%{$search}%");
        }

        $totalAssets = $assetsQuery->count();
        $totalDeletedAssets = $deletedAssetsQuery->count();

        // Query to get assets count by category based on filters
        $categories = Category::withCount(['assets' => function ($query) use ($category, $location, $etat, $search) {
            if ($category) {
                $query->where('category_id', $category);
            }

            if ($location) {
                $query->where('location', $location);
            }

            if ($etat) {
                $query->where('etat', $etat);
            }

            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }
        }])->get();

        return response()->json([
            'totalAssets' => $totalAssets,
            'totalDeletedAssets' => $totalDeletedAssets,
            'categories' => $categories
        ]);
    }
}
