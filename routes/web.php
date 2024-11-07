
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ClientsController,
    AssetsController,
    UserController,
    GroupController,
    LoginController,
    CategoryController,
    MediaController,
    PasswordController,
    TaskLogController,
    DesignationController,
    BailleurController,
    ProjetController
    };



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route par default / *********************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {--
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::get('/api/latest-sequence-number', [AssetsController::class, 'getLatestSequenceNumber']);
// Dans votre routes/web.php
Route::get('/search-assets', [AssetsController::class, 'showAssetManagementPage']);

Route::get('/search-designations', [DesignationController::class, 'showAddDesignationPage']);
Route::get('/search-bailleurs', [BailleurController::class, 'showAddBailleurPage']);
Route::get('/search-projets', [ProjetController::class, 'showAddProjetPage']);

// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion du login***************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//Route pour la navigation vers la login page
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion du pasword***************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
Route::get('define-New-Password', [PasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('password/change', [PasswordController::class, 'changePassword'])->name('password.update');
// Route::get('/UpdateGroupsInformations', 'ClientsController@UpdateGroupsInformations')->name('clients.UpdateGroupsInformations');
// Route::get('/UpdateInformations', 'ClientsController@UpdateInformations')->name('clients.UpdateInformations');
// Route::get('/UpdateUsersInformations', 'ClientsController@UpdateUsersInformations')->name('clients.UpdateUsersInformations');
// Route::get('/register', 'ClientsController@register')->name('clients.register');
// Route::get('/requestpassword', 'ClientsController@requestPassword')->name('clients.requestPassword');


// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Debut du middleware*********************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::middleware(['auth', 'force.password.change'])->group(function () {
Route::get('/dashboard', [ClientsController::class, 'showHomePage'])->name('dashboard');
// Autres routes protégées...

    // {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route pour la gestion des codification *********************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

    Route::get('/api/get-last-codification-number', function() {
        $lastAsset = Asset::orderBy('id', 'desc')->first();
        $lastNum = 0;

        if ($lastAsset) {
            $lastCodification = $lastAsset->codification;
            preg_match('/(\d{3})$/', $lastCodification, $matches);
            if ($matches) {
                $lastNum = intval($matches[1]);
            }
        }

        return response()->json(['last_num' => $lastNum]);
    });
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de Navigation (nav bar route)*********************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// Route de navigation pour la gestion des catégories
Route::get('/categoryManagement', [CategoryController::class, 'showCategoryManagementPage'])->name('category.showCategoryManagementPage');
// Routes protégées par middleware auth et admin
Route::middleware(['auth', 'admin'])->group(function () {

// Route de navigation pour l'affichage de la page de creation de groupe
// Route::get('/groupManagement','ClientsController@groupManagement')->name('clients.groupManagement');
Route::get('/groupManagement', [GroupController::class, 'showGroupManagementPage'])->name('groups.showGroupManagementPage');
// Route de navigation pour l'affichage de la page de gestion des utilisateur
Route::get('/UserManagementPage', [UserController::class, 'showUserManagementPage'])->name('users.showUserManagementPage');
// Route de navigation pour la page des médias
Route::get('/media', [MediaController::class, 'showMediaPage'])->name('media.showMediaPage');
// Route et fonction pour afficher la page avec les categories supprimées
Route::get('/showdeletedCategoryPage', [CategoryController::class, 'showdeletedCategoryPage'])->name('showdeletedCategoryPage');

});

Route::get('/logs', 'AssetsController@showActivityLogs')->name('logs.index');


Route::get('/home', [ClientsController::class, 'showHomePage'])->name('clients.showHomePage');

// Route de navigation pour l'affichage de la page de gestion des assets
Route::get('/assetManagement', [AssetsController::class, 'showAssetManagementPage'])->name('assets.showAssetManagementPage');

// Route de navigation pour l'affichage de la page d'ajout de nouveaux assets
Route::get('/AddAssetManagement', [AssetsController::class, 'showAddAssetManagementPage'])->name('assets.showAddAssetManagementPage');



Route::get('/profil', [UserController::class, 'showProfilPage'])->name('users.showProfilPage');

// Route et fonction pour afficher la page avec les assets supprimés
Route::get('/showDeletedAssetsPage', [AssetsController::class, 'showDeletedAssetsPage'])->name('showDeletedAssetsPage');


// Route  pour afficher la page homeclient
Route::get('/HomeClientPage', [ClientsController::class, 'showHomeClientPage'])->name('clients.homeClient');


// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion d'assets****************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

// Route pour ajouter un nouvel asset dans la db
Route::post('/addNewAssetInDb', [AssetsController::class, 'addNewAssetInDb'])->name('assets.addNewAssetInDb');

// Route pour les navsearch
//Route::get('/search-assets', 'AssetController@searchAssets')->name('assets.search');

// Route pour filtrer l'affichage du tableau
Route::get('/filter-assets', [AssetsController::class, 'filterAssets'])->name('filterAssets');

// Route pour filtrer l'affichage du tableau dans assetManagement
Route::get('/filterAssetsforAssetManagment', [AssetsController::class, 'filterAssetsforAssetManagment'])->name('filterAssetsforAssetManagment');

// Route pour filtrer les assets supprimés
Route::get('/filterDeletedAssets', [AssetsController::class, 'filterDeletedAssets'])->name('filterDeletedAssets');

// Route pour mettre à jour un asset existant
Route::get('/updateExistingAsset', [AssetsController::class, 'showUpdateExistingAssetsPage'])->name('assets.showUpdateExistingAssetsPage');

// Route pour restaurer les assets supprimés
Route::post('/assets/restore', [AssetsController::class, 'restoreAsset'])->name('assets.restore');

// Route pour mettre à jour un asset
Route::put('/asset/update/{id}', [AssetsController::class, 'updateAsset'])->name('assetUpdate');

// Route pour supprimer un asset
Route::delete('/assets/deleteAsset', [AssetsController::class, 'deleteAsset'])->name('assets.delete');

//Route pour afficher selon les filtres de date les logs des activité utilisateur :
Route::get('/filter-logs-by-date', [AssetsController::class, 'filterLogsByDate'])->name('filterLogsByDate');
Route::delete('/logs/delete-multiple', [AssetsController::class, 'deleteMultipleLogs'])->name('logs.deleteMultipleLogs');



// Route pour afficher les assets amortis
Route::get('/assets/amortized', [AssetsController::class, 'showAmortized'])->name('assets.amortized');

// Route pour afficher les assets non amortis
Route::get('/assets/non-amortized', [AssetsController::class, 'showNonAmortized'])->name('assets.non_amortized');

// Route pour afficher les assets avec dates invalides
Route::get('/assets/invalid-dates', [AssetsController::class, 'showInvalidAssets'])->name('assets.invalid_dates');


// gestion des logs pour la mis ajours automatique de l'\amortissement des assets

Route::get('/task-log', [TaskLogController::class, 'showLogs'])->name('task.log');

//suppression multiples des logs
Route::post('/logs/deleteMultiple', [TaskLogController::class, 'deleteMultiple'])->name('logs.deleteMultiple');

// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des comptes utilisateurs************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::post('/users.store', [UserController::class, 'store'])->name('users.store');
Route::get('/check-username', [UserController::class, 'checkUsername'])->name('check-username');

Route::post('/users/toggle-status', [UserController::class, 'toggleUserStatus']);
Route::post('/users/delete', [UserController::class, 'deleteUser']);
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/update/{id}', [UserController::class, 'updateUser'])->name('users.update');

Route::post('/update-photo', [UserController::class, 'updatePhoto'])->name('users.updatePhoto');
Route::post('/users/{id}/update-photo', [UserController::class, 'updateUsersPhoto'])->name('users.updateUsersPhoto');
// route pour reinitialiser le mot de passe
Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset_password');



// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des groupes*************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::get('/groups/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
Route::put('/groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
Route::post('groups/{group}/changeStatus', [App\Http\Controllers\GroupController::class, 'changeStatus'])->name('groups.changeStatus');
Route::delete('groups/{group}', [App\Http\Controllers\GroupController::class, 'destroy'])->name('groups.destroy');


// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des categories**********************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
Route::get('/updateExistingCategory', [App\Http\Controllers\CategoryController::class, 'showUpdateExistingCategoryPage'])->name('category.showUpdateExistingCategoryPage');
Route::post('/categories', [CategoryController::class, 'addNewCategoryInDb'])->name('categories.addNewCategoryInDb');
Route::post('/category/{id}', 'CategoryController@updatecategory')->name('categoryUpdate');
Route::delete('/categories/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('category.deleteCategory');
Route::post('/category/changeCategory', [CategoryController::class, 'changeCategory'])->name('category.changeCategory');
Route::post('/category/restore', 'CategoryController@restoreCategory')->name('category.restoreCategory');
Route::post('toggleStatus', 'CategoryController@toggleStatus')->name('category.toggleCategoryStatus');
Route::post('restoreOrDelete', 'CategoryController@restoreOrDeleteCategory')->name('category.restoreOrDeleteCategory');
Route::delete('/categories/delete-multiple', [CategoryController::class, 'deleteMultipleCategories'])->name('category.deleteMultipleCategories');


// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des medias photos*******************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
Route::delete('/medias/delete-bulk', [MediaController::class, 'deleteBulk'])->name('medias.delete.bulk');
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des Designation***************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
Route::get('/ajouterDesignation', [DesignationController::class, 'showAddDesignationPage'])->name('designations.showAddDesignationPage');
Route::post('/designations/add', [DesignationController::class, 'add'])->name('designations.add');
Route::post('/designations/import', [DesignationController::class, 'import'])->name('designations.import');
Route::post('/designations/toggleStatus', [DesignationController::class, 'toggleStatus'])->name('designations.toggleStatus');
Route::delete('/designations/delete', [DesignationController::class, 'delete'])->name('designations.delete');
Route::get('/designations/{id}', [DesignationController::class, 'getDesignationById']);
Route::delete('/designations/delete-multiple', [DesignationController::class, 'deleteMultiple'])->name('designations.delete.bulk');

// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des Bailleur***************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
    Route::get('/ajouterBailleur', [BailleurController::class, 'showAddBailleurPage'])->name('bailleurs.showAddBailleurPage');
    Route::post('/bailleurs/add', [BailleurController::class, 'add'])->name('bailleurs.add');
    Route::post('/bailleurs/import', [BailleurController::class, 'import'])->name('bailleurs.import');
    Route::post('/bailleurs/toggleStatus', [BailleurController::class, 'toggleStatus'])->name('bailleurs.toggleStatus');
    Route::delete('/bailleurs/delete', [BailleurController::class, 'delete'])->name('bailleurs.delete');
    Route::get('/bailleurs/{id}', [bailleurController::class, 'getBailleurById']);
    Route::delete('/bailleurs/delete-multiple', [BailleurController::class, 'deleteMultiple'])->name('bailleurs.delete.bulk');

// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route de la gestion des Projet***************************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
Route::get('/ajouterProjet', [ProjetController::class, 'showAddProjetPage'])->name('projets.showAddProjetPage');
Route::post('/projets/add', [ProjetController::class, 'add'])->name('projets.add');
Route::post('/projets/import', [ProjetController::class, 'import'])->name('projets.import');
Route::post('/projets/toggleStatus', [ProjetController::class, 'toggleStatus'])->name('projets.toggleStatus');
Route::delete('/projets/delete', [ProjetController::class, 'delete'])->name('projets.delete');
Route::get('/projets/{id}', [ProjetController::class, 'getProjetById']);
Route::delete('/projets/delete-multiple', [ProjetController::class, 'deleteMultiple'])->name('projets.delete.bulk');




// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route d'export de fichier en exel ou pdf****************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// Route::post('/xport-excel', [AssetsController::class, 'exportExcel'])->name('export-excel');
// Route::get('/export-excel', [AssetsController::class, 'exportExcel'])->name('assets.exportExcel');
Route::get('/assets/export', [AssetsController::class, 'exportExcel'])->name('assets.exportExcel');
Route::get('/log/export', [AssetsController::class, 'exportLogExcel'])->name('assets.exportLogExcel');


// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
//Route pour les graphique du dashboard****************************************************
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}
// {-----------------------------------------------------------------------------------------}

Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/api/getChartData', [ChartController::class, 'getChartData'])->name('api.getChartData');
Route::post('/api/assets', [AssetsController::class, 'filter'])->name('assets.filter');

});
});
