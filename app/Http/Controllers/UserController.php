<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserRequest;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends BaseController
{
    protected $role;
    /**
     * Constructor function
     *
     * @param UserService $menu
     */
    public function __construct(UserService $user, RoleService $role)
    {
        $this->service = $user;
        $this->role = $role;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index(){
        if(permission('user-access')){
            $this -> setPageData('User', 'User', 'fas fa-users');
            $roles = $this->role->index();
            return view('user.index', compact('roles'));
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
        if(permission('user-access')){
            if($request -> ajax()){
                $output = $this->service->getDataTableData($request);
            }else{
                $output = ['status'=>'error','message'=>'Unauthorize access blocked'];
            }
            return response()->json($output);
        }
    }

    /**
     * storeOrUppdate function
     *
     * @param  $request
     * @return void
     */

    public function storeOrUpdate(UserRequest $request){
        if($request->ajax()){
            if(permission('user-add') || permission('user-edit')){
                $result = $this->service->storeOrUpdate($request);
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
            if(permission('user-edit')){
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
     * View data
     */
    public function show(Request $request){
        if($request->ajax()){
            if(permission('user-show')){
                $user = $this->service->edit($request);
                return view('user.details', compact('user')) -> render();
            }
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
            if(permission('user-delete')){
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

    /**
     * Bulk Delete
     */

    public function bulkDelete(Request $request){
        if($request->ajax()){
            if(permission('user-bulk-delete')){
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

    public function changeStatus(Request $request){
        if($request->ajax()){
            if(permission('user-edit')){
                $result = $this->service->changeStatus($request);
                if($result){
                    return $this->responseJson($status='success',$message="Status changed successfull",$data=null,$response_code=200);
                }else{
                    return $this->responseJson($status='error',$message='Faield to change status',$data=null,$response_code=204);
                }
            }else{
                return $this->responseJson($status='error',$message='Unauthorized access blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }
    
}
