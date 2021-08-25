<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Services\PermissionService;

class PermissionController extends BaseController
{
    /**
     * Constructor function
     *
     * @param PermissionService $menu
     */
    public function __construct(PermissionService $permission)
    {
        $this->service = $permission;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index(){
        if(permission('permission-access')){
            $this -> setPageData('Permisssion', 'Permisssion', 'fas fa-th-list');
            $data = $this->service->index();
            return view('permission.index', compact('data'));
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
        if(permission('permission-access')){
            if($request -> ajax()){
                $output = $this->service->getDataTableData($request);
            }else{
                $output = ['status'=>'error','message'=>'Unauthorize access blocked'];
            }
            return response()->json($output);
        }
    }

    /**
     * storeOrUpdate function
     *
     * @param PermissionRequest $request
     * @return void
     */

    public function store(PermissionRequest $request){
        if($request->ajax()){
            if(permission('permission-add')){
                $result = $this->service->store($request);
                if($result){
                    return $this->responseJson($status='success',$message='Data has been saved successfull',$data=null,$response_code=204);
                }else{
                    return $this->responseJson($status='error',$message='Data can not save',$data=null,$response_code=204);
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
    public function edit(Request $request){
        if($request->ajax()){
            if(permission('permission-edit')){
                $data = $this->service->edit($request);
                if($data -> count()){
                    return $this -> responseJson($status='success',$message=null,$data=$data,$response_code=201);
                }else{
                    return $this->responseJson($status='error',$message='No Data Found',$data=null,$response_code=204);
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * update function
     *
     * @param PermissionUpdateRequest $request
     * @return void
     */

    public function update(PermissionUpdateRequest $request){
        if($request->ajax()){
            if(permission('permission-edit')){
                $result = $this->service->update($request);
                if($result){
                    return $this->responseJson($status='success',$message='Data has been updated successfull',$data=null,$response_code=204);
                }else{
                    return $this->responseJson($status='error',$message='Data can not update',$data=null,$response_code=204);
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
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
            if(permission('permission-delete')){
                $result = $this->service->delete($request);
                if($result){
                    return $this->responseJson($status='success',$message="Data has been deleted successfull",$data=null,$response_code=200);
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
            if(permission('permission-bulk-delete')){
                $result = $this->service->bulkDelete($request);
                if($result){
                    return $this->responseJson($status='success',$message="Data has been deleted successfull",$data=null,$response_code=200);
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

}
