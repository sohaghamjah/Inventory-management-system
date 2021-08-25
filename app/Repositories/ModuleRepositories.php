<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\Module;

class ModuleRepositories extends BaseRepositories{

    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    public function module_list(int $menu_id){
        $modules = $this->model->orderBY('order', 'asc')
        ->where(['type'=>2,'menu_id'=>$menu_id])
        ->get()
        ->nest()
        ->setIndent('-- ')
        ->listsFlattened('module_name');

        return $modules;
    }

    public function permissionModuleList(){
        return $this->model->doesntHave('parent')
        ->select('id','type','divider_name','module_name','order')
        ->orderBy('order','asc')
        ->with('permission:id,module_id,name','submenu:id,parent_id,module_name')->get();
    }


    public function moduleSessionList(){
        return $this->model::doesntHave('parent')
        ->orderBy('order','asc')
        ->with('children')->get();
    }

}
