<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\ModuleRepositories as Module;
use App\Repositories\MenuRepositories as Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class ModuleService extends BaseService{
    protected $menu;
    protected $module;

    public function __construct(Module $module, Menu $menu)
    {
        $this->menu = $menu;
        $this->module = $module;
    }


    public function index(int $id){ 
        $data['menu'] = $this->menu->withMenuItems($id);
        return $data;
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated());
        $menu_id = $request -> menu_id;

        $created_at = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection -> merge(compact('updated_at'));
        }else{
            $collection = $collection -> merge(compact('menu_id','created_at'));
        }

        $result = $this->module->updateOrCreate(['id' => $request->update_id], $collection->all());

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionModule();
            }
        }

        return $result;
    }

    public function edit($menu_id, $module_id){
        $data['menu'] = $this->menu->withMenuItems($menu_id);
        $data['module'] = $this->module->findOrFail($module_id);
        return $data;
    }

    public function delete($module){
        $result =  $this->module->delete($module);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionModule();
            }
        }

        return $result;
    }

    public function restoreSessionModule(){
        
        $modules = $this->module->moduleSessionList();

        if(!$modules->isEmpty()){
            Session::forget('menu');
            Session::put('menu', $modules);
            return true;
        }
        return false;

    }

}
