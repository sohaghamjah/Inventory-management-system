<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\RoleRequest;
use App\Services\MenuService;
use App\Services\ModuleService;

class MenuController extends BaseController
{
    protected $module;
    /**
     * Constructor function
     *
     * @param MenuService $menu
     */
    public function __construct(MenuService $menu, ModuleService $module)
    {
        $this->service = $menu;
        $this->module = $module;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index(){
        if(permission('menu-access')){
            $this -> setPageData('Menu', 'Menu', 'fas fa-th-list');
            return view('menu.index');
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
       if(permission('menu-access')){
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

    public function storeOrUpdate(MenuRequest $request){
        if($request->ajax()){
            if(permission('menu-add') || permission('menu-edit')){
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
            if(permission('menu-add')){
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
     * delete function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request){
        if($request->ajax()){
            if(permission('menu-delete')){
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
            if(permission('menu-bulk-delete')){
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

    public function orderItem(Request $request){
        $menu_item_order = json_decode($request->input('order'));
        $this->service->orderMenu($menu_item_order, null);
        $this->module->restoreSessionModule();
    }
}
