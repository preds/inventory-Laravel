<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    //

    public function showMediaPage(Request $request)
    {
        $perPage = $request->get('perPage', 10); // Nombre d'éléments par page, valeur par défaut de 10
        $medias = Media::where('deleted', false)->paginate($perPage);
        return view('clients.media', compact('medias'));
    }
    

  
    public function upload(Request $request)
    {
        // Validez la requête
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Récupérer le fichier de l'image
        $file = $request->file('photo');
        // Convertir le nom de l'image en minuscules pour éviter les doublons à cause de la casse
        $photoName = strtolower($file->getClientOriginalName());
        // Définir le chemin de stockage de l'image
        $photoPath = 'public/photos/' . $photoName;
    
        // Calculer le hash de l'image pour vérifier son unicité
        $fileHash = md5_file($file->getPathname());
    
        // Vérifiez si un fichier avec le même hash existe déjà dans la base de données
        $existingMedia = Media::where('photo_hash', $fileHash)->first();
    
        if ($existingMedia) {
            // Redirigez avec un message d'avertissement si l'image existe déjà
            return redirect()->route('media.showMediaPage')->with('warning', 'This photo already exists.');
        }
    
        // Enregistrez l'image dans le dossier de stockage si elle n'existe pas déjà
        if (!Storage::exists($photoPath)) {
            $file->storeAs('public/photos', $photoName);
        }
    
        // Enregistrez les détails de l'image dans la base de données
        $media = new Media();
        $media->photo = 'photos/' . $photoName; // Notez que nous stockons seulement le chemin relatif
        $media->photo_name = $photoName;
        $media->photo_type = $file->getClientOriginalExtension();
        $media->photo_hash = $fileHash;
        $media->save();
    
        // Redirigez avec un message de succès
        return redirect()->route('media.showMediaPage')->with('success', 'Photo uploaded successfully.');
    }
    
    public function deleteBulk(Request $request)
{
    $ids = $request->input('ids');
    if ($ids) {
        // Convertir la chaîne d'IDs en tableau
        $idsArray = explode(',', $ids);
        
        // Supprimer les médias avec les IDs fournis
        Media::whereIn('id', $idsArray)->update(['deleted' => true]); // ou Media::destroy($idsArray); si vous supprimez directement
        
        return redirect()->route('media.showMediaPage')->with('success', 'Médias supprimés avec succès.');
    }

    return redirect()->route('media.showMediaPage')->with('error', 'Aucun média sélectionné pour la suppression.');
}


}

