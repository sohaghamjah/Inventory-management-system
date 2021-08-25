<?php
namespace App\Services;

use App\Models\ModuleRole;
use App\Models\PermissionRole;
use App\Services\BaseService;
use App\Repositories\RoleRepositories as Role;
use App\Repositories\ModuleRepositories as Module;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoleService extends BaseService{
    protected $role;
    protected $module;

    public function __construct(Role $role, Module $module)
    {
        $this->role = $role;
        $this->module = $module;
    }

    public function index(){
        return $this->role->all();
    }

    /**
     * getDatatableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDatatableData(Request $request){
        if($request -> ajax()){

            // Filter datatable
            if(!empty($request->role_name)){
                $this->role-> setRoleName($request->role_name);
            }

            // Show uer list
            $this->role-> setOrderValue($request->input('order.0.column'));
            $this->role-> setDirValue($request->input('order.0.dir'));
            $this->role-> setLengthValue($request->input('length'));
            $this->role-> setStartValue($request->input('start'));

            $list = $this->role-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if (permission('role-edit')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" href="'.route('role.edit', ['id' => $value->id]).'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if (permission('role-show')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" href="'.route('role.view', ['id' => $value->id]).'"><i class="fas fa-eye text-warning"></i> View</a>';
                }
                if (permission('role-delete')){
                    if($value->deletable == 2){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->role_name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                }

                $row = [];
                if (permission('role-bulk-delete')){
                    $row [] = ($value->deletable == 2) ? tableCheckBox($value->id) : '';
                }

                $row []    = $no;
                $row []    = $value->role_name;
                $row []    = DELETABLE[$value->deletable];
                $row []    = actionButton($action);
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->role-> countFilter(), $this->role-> countAll(), $data);
        }
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated());

        $role = $this->role->updateOrCreate(['id' => $request->update_id], $collection->all());
        if($role){
            $role->module_role()->sync($request->module);
            $role->permission_role()->sync($request->permission);
             return true;
        }
        return false;
    }

    public function edit(int $id){
        $role = $this->role->findDataWithModulePermission($id);
        $module_role = [];
        if(!$role->module_role->isEmpty()){
            foreach ($role->module_role as $value) {
                array_push($module_role, $value->id);
            }
        }
        $permission_role = [];
        if(!$role->permission_role->isEmpty()){
            foreach ($role->permission_role as $value) {
                array_push($permission_role, $value->id);
            }
        }

        $data = [
            'role' => $role,
            'module_role' => $module_role,
            'permission_role' => $permission_role,
        ];

        return $data;
    }

    public function delete(Request $request){
        $role = $this->role->findDataWithModulePermission($request -> id);
        if($role->users->count() > 0){
            $response = 2;
        }else{
            $role->module_role()->detach();
            $role->permission_role()->detach();
            $role->delete();
            $response = 1;
        }
        return $response;
    }

    public function bulkDelete(Request $request){
        if(!empty($request->ids)){
            $delete_list = [];
            $undelete_list = [];
            foreach ($request->ids as $id) {
                $role = $this->role->find($id);
                if($role->users->count() > 0){
                    array_push($undelete_list, $role->role_name);
                }else{
                    array_push($delete_list, $role->id);
                }
            }
            $message = !empty($undelete_list) ? 'These Roles('.implode(',', $undelete_list).') can\'t delete becouse they are related to mannu users' : '';
            if(!empty($delete_list)){
                $delete_module_role = ModuleRole::whereIn('role_id',$delete_list)->delete();
                $delete_permission_role = PermissionRole::whereIn('role_id',$delete_list)->delete();
                if($delete_module_role && $delete_permission_role){
                    $this->role->destroy($delete_list);
                    $response = ['status' => 1, 'message' => $message];
                }else{
                    $response = ['status' => 2, 'message' => $message];
                }
            }else{
                $response = ['status' => 3, 'message' => $message];
            }
            return $response;
        }
    }



    // Module list

    public function permissionModuleList(){
        return $this->module->permissionModuleList();
    }
}
