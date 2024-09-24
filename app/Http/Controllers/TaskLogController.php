<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TaskLog;
use App\Models\Asset;
class TaskLogController extends Controller
{
    public function showLogs(Request $request)
    {
        // Récupérer le nombre d'éléments par page, avec une valeur par défaut de 10
        $perPage = $request->get('perPage', 10);
        
        // Récupérer les logs avec la pagination
        $logs = DB::table('task_logs')->orderBy('created_at', 'desc')->paginate($perPage);
        
        // Retourner la vue avec les logs
        return view('clients.taskLog', ['logs' => $logs]);
    }
    
    



    public function deleteMultiple(Request $request)
{
    $selectedLogs = $request->input('selectedLogs');

    if ($selectedLogs) {
        // Utilisez le modèle TaskLog pour effectuer la suppression
        TaskLog::whereIn('id', $selectedLogs)->delete();

        return redirect()->back()->with('success', 'Les logs sélectionnés ont été supprimés.');
    }

    return redirect()->back()->with('error', 'Aucun log sélectionné.');
}



}
