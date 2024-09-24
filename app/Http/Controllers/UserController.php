<?php
// use app/Http/Controllers/UserController;

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function showUserManagementPage () {

        $groups=Group::where('status', true)->get();
        $users = User::all();

        return view('clients.userManagement',compact('groups','users'));
    }

    public function showProfilPage() {

        $groups=Group::where('status', true)->get();
        $users = User::all();

        return view('clients.profils',compact('groups','users'));
    }




    public function index()
    {
        $users = User::all();
        $groups=Group::where('status', true)->get();
        return view('users.index', compact('users','groups'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('users.create', compact('groups'));
    }

public function store(Request $request)
{
    $validatedData = $request->validate([
        'localisation' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'group_id' => 'required|exists:groups,id'
    ]);

    // Générer un mot de passe aléatoire
    $password = Str::random(10);

    // Création de l'utilisateur avec les données validées
    $user = User::create([
        'localisation' => $validatedData['localisation'],
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'username' => $validatedData['username'],
        'password' => Hash::make($password), // Hashage du mot de passe avant de le stocker
        'group_id' => $validatedData['group_id'], // Assignation du groupe à l'utilisateur
        'password_reset_required' => true, // Indiquer que l'utilisateur doit réinitialiser son mot de passe
    ]);

    // Envoyer le mot de passe généré à l'utilisateur
    // Vous pouvez utiliser un service de notification pour cela

    // Rediriger avec un message de succès
    return redirect()->route('users.showUserManagementPage')->with('success', 'User created successfully. Password: ' . $password);
}


public function checkUsername(Request $request)
{
    $username = $request->get('username');
    $exists = User::where('username', $username)->exists();
    return response()->json(['exists' => $exists]);
}



// Fonction pour mettre à jour un utilisateur
public function updateUser(Request $request, $id)
{
    // Valider les données de la requête
    $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $id,
    ];

    // Si l'utilisateur n'est pas admin, exclure les champs group_id et localisation
    if (!auth()->user()->isAdmin()) {
        unset($rules['group_id']);
        unset($rules['localisation']);
    }

    // Valider les données de la requête avec les règles ajustées
    $validatedData = $request->validate($rules);

    // Récupérer l'utilisateur existant
    $user = User::findOrFail($id);

    // Mettre à jour les informations de l'utilisateur
    $user->fill($validatedData);

    // Mettre à jour le mot de passe si fourni et non vide
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    // Mettre à jour le group_id seulement si l'utilisateur est admin
    if (auth()->user()->isAdmin()) {
        $user->group_id = $request->input('group_id');
        $user->localisation = $request->input('localisation');
    }

    // Sauvegarder les changements
    $user->save();

    // Rediriger avec un message de succès
    if (auth()->user()->isAdmin()) {
        return redirect()->route('users.showUserManagementPage')->with('success', 'User updated successfully');
    } else {
        return redirect()->route('users.showProfilPage')->with('success', $user->username . ' profile updated successfully');
    }
}


// Fonction pour supprimer un utilisateur
public function deleteUser(Request $request)
{
    $userId = $request->input('id');

    // Trouver l'utilisateur dans la base de données
    $user = User::find($userId);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Supprimer l'utilisateur
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User successfully deleted.']);
    } else {
        return response()->json(['success' => false, 'message' => 'User not found.']);
    }
}

// Fonction pour activer/désactiver un utilisateur
public function toggleUserStatus(Request $request)
{
    $userId = $request->input('id');

    // Trouver l'utilisateur dans la base de données
    $user = User::find($userId);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Alterner le statut de l'utilisateur
        $user->status = !$user->status;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User status successfully updated.']);
    } else {
        return response()->json(['success' => false, 'message' => 'User not found.']);
    }
}


public function edit($id)
{
    // Récupérer l'utilisateur à modifier
    $user = User::findOrFail($id);

    // Récupérer tous les groupes pour le sélecteur de groupes
    $groups = Group::all();

    // Liste des localisations disponibles
    $localisations = ['Ouagadougou', 'Ouahigouya', 'Koudougou', 'Kaya'];

    // Passer les données de l'utilisateur, des groupes et des localisations à la vue
    return view('clients.UpdateUsersInformations', compact('user', 'groups', 'localisations'));
}


public function updatePhoto(Request $request)
{
    // Validez la requête
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Vérifie que le fichier est une image et ne dépasse pas 2 Mo
    ]);

    // Récupérer l'utilisateur authentifié
    $user = Auth::user();

    // Supprimer l'ancienne photo s'il y en a une
    if ($user->photo) {
        // Supprimez l'ancienne photo du stockage
        Storage::delete('public/avatars_photos/' . $user->photo);
    }

    // Récupérer le fichier de l'image
    $file = $request->file('photo');

    // Convertir le nom de l'image en minuscules pour éviter les doublons à cause de la casse
    $photoName = strtolower($file->getClientOriginalName());

    // Enregistrez la nouvelle photo dans le stockage
    $file->storeAs('public/avatars_photos', $photoName);

    // Mettre à jour le champ photo de l'utilisateur avec le nom de fichier de la nouvelle photo
    $user->photo = $photoName; // Stockez seulement le nom de fichier
    $user->save();

    // Redirigez avec un message de succès
    return redirect()->back()->with('success', 'Photo updated successfully.');
}

public function updateUsersPhoto(Request $request, $id)
{
    // Valider la requête
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Récupérer l'utilisateur par son ID
    $user = User::findOrFail($id);

    // Vérifier s'il existe déjà une photo et la supprimer si nécessaire
    if ($user->photo) {
        Storage::delete('public/avatars_photos/' . $user->photo);
    }

    // Sauvegarder la nouvelle photo
    $newPhoto = $request->file('photo');
    $fileName = time() . '_' . $newPhoto->getClientOriginalName();
    $newPhoto->storeAs('public/avatars_photos', $fileName);

    // Mettre à jour le champ 'photo' de l'utilisateur
    $user->photo = $fileName;
    $user->save();

    return redirect()->back()->with('success', 'Photo updated successfully');
}

// reinitialiser le mot de passe

public function resetPassword($id)
{
    $user = User::findOrFail($id);

    // Générer un nouveau mot de passe
    $newPassword = Str::random(10);
    $user->password = Hash::make($newPassword);
    $user->password_reset_required = true;
    $user->save();

    // return redirect()->route('users.edit')->with('success', 'password reset succefully. New-Password: ' . $password);
    return response()->json(['success' => true, 'new_password' => $newPassword]);
}

}


