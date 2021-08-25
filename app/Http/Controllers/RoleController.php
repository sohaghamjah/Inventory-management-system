<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;

class RoleController extends BaseController
{
    /**
     * Constructor function
     *
     * @param RoleService $menu
     */
    public function __construct(RoleService $role)
    {
        $this->service = $role;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index(){
        if(permission('role-access')){
            $this -> setPageData('Role', 'Role', 'fas fa-th-list');
            return view('role.index');
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }

    /**
     * getDataTableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDataTableData(Request $request){
        if(permission('role-access')){
            if($request -> ajax()){
                $output = $this->service->getDataTableData($request);
            }else{
                $output = ['status'=>'error','message'=>'Unauthorize access blocked'];
            }
            return response()->json($output);
        }
    }

    public function create(){
        if(permission('role-add')){
            $this -> setPageData('Add Role', 'Create Role', 'fas fa-th-list');
            $data = $this->service->permissionModuleList();
            return view('role.create', compact('data'));
        }else{
            $this->unauthorizedAccessBlocked();
        }
    }

    /**
     * storeOrUpdate function
     *
     * @param RoleRequest $request
     * @return void
     */

    public function storeOrUpdate(RoleRequest $request){
        if($request->ajax()){
            if(permission('role-add') || permission('role-add')){
                $result = $this->service->storeOrUpdate($request);
                if($result){
                    if($request -> update_id){
                        return $this->responseJson($status='success',$message='Data has been updated successfull',$data=null,$response_code=204);
                    }else{
                        return $this->responseJson($status='success',$message='Data has been saved successfull',$data=null,$response_code=204);
                    }
                }else{
                    if($request->update_id){
                        return $this->responseJson($status='error',$message='Data can not update',$data=null,$response_code=204);
                    }else{
                        return $this->responseJson($status='error',$message='Data can not save',$data=null,$response_code=204);
                    }
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * Edit function
     *
     * @param Request $request
     * @return void
     */
    public function edit(int $id){
        if(permission('role-edit')){
            $this -> setPageData('Edit Role', 'Edit Role', 'fas fa-th-list');
            $data = $this->service->permissionModuleList();
            $permission_data = $this->service->edit($id);
            return view('role.edit', compact('data', 'permission_data'));
        }else{
            $this->unauthorizedAccessBlocked();
        }
    }

    /**
     * show function
     *
     * @param Request $request
     * @return void
     */
    public function show(int $id){
        if(permission('role-show')){
            $this -> setPageData('Role Details', 'Role Details', 'fas fa-th-list');
            $data = $this->service->permissionModuleList();
            $permission_data = $this->service->edit($id);
            return view('role.view', compact('data', 'permission_data'));
        }else{
            $this->unauthorizedAccessBlocked();
        }
    }

    /**
     * delete function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request){
        if($request->ajax()){
            if(permission('role-delete')){
                $result = $this->service->delete($request);
                if($result == 1){
                    return $this->responseJson($status='success',$message="Data has been deleted successfull",$data=null,$response_code=200);
                }elseif($result == 2){
                    return $this->responseJson($status='error',$message="Data can not delet becouse it's releted with many users",$data=null,$response_code=200);
                }else{
                    return $this->responseJson($status='error',$message='Data can not delete',$data=null,$response_code=204);
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function bulkDelete(Request $request){
        if($request->ajax()){
            if(permission('role-bulk-delete')){
                $result = $this->service->bulkDelete($request);
                if($result['status'] == 1){
                    return $this->responseJson($status='success',$message = !empty($result['message']) ? $result['message'] : "Data has been deleted successfull",$data=null,$response_code=200);
                }elseif($result == 2){
                    return $this->responseJson($status='error', $message = !empty($result['message']) ? $result['message'] : "Selected data can not delete" , $data=null,$response_code=200);
                }else{
                    return $this->responseJson($status='error',$message= !empty($result['message']) ? $result['message'] : 'Selected data can not delete',$data=null,$response_code=204);
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }
}
