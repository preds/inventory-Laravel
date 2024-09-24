<?php
// app/Http/Controllers/GroupController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    
    public function showGroupManagementPage () {

        $groups = Group::All();
      
        return view('clients.groupManagement',compact('groups'));
    }

    public function store(Request $request)
    {
     
        $validatedData =  $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:Administrator,Simple User,Guest',
          
        ]);
    
        DB::beginTransaction();
    
        try {
            // Créer un nouvel asset avec les données validées
            $group = new Group($validatedData);
            $group->save();
    
            DB::commit();
    
            return redirect()->route('groups.showGroupManagementPage')->with('success', 'Group created successfully.');
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('groups.showGroupManagementPage')->with('error', 'Failed to create group: ' . $e->getMessage());
        }
    }
    
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        return view('clients.updateExistingGroup', compact('group'));
    }
    

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'groupname' => 'required|string|max:255',
            'level' => 'required|in:Administrator,Simple User,Guest',
        ]);
    
        try {
            $group = Group::findOrFail($id);
            $group->update($validatedData);
    
            return redirect()->route('groups.showGroupManagementPage')->with('success', 'Group updated successfully.');
        } catch (\Exception $e) {
            // Log the error or handle it as necessary
            return redirect()->route('groups.showGroupManagementPage')->with('error', 'Failed to update group. Please try again.');
        }
    }
    

    
    
    public function changeStatus($id)
    {
        $group = Group::findOrFail($id);
        $group->status = !$group->status;
        $group->save();
    
        return redirect()->route('groups.showGroupManagementPage')->with('success', 'Group deactivated successfully.');
    }
    
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
    
        return redirect()->route('groups.showGroupManagementPage')->with('success', 'Group deleted successfully.');
    }
    
}
