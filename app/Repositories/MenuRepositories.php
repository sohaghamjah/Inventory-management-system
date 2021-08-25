<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\Menu;

class MenuRepositories extends BaseRepositories{

    protected $order = array('id' => 'desc');
    protected $menu_name;

    public function __construct(Menu $model)
    {
        $this->model = $model;
    }

    public function setMenuName($menu_name){
        $this->menu_name = $menu_name;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('menu-bulk-delete')){
          $this->column_order = [null,'id','menu_name','deletable',null];
        }else{
            $this->column_order = ['id','menu_name','deletable',null];
        }
        
        // user list query
        $query = $this->model::toBase();

        // Menu data filter query
        if(!empty($this->menu_name)){
            $query->where('menu_name', 'like','%' .$this->menu_name. '%');
        }

        // Sorting
        if(isset($this->orderValue) && isset($this->dirValue)){
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        }else if(isset($this->order)){
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDataTableList()
    {
        $query = $this->getDataTableQuery();
        if ($this->lengthValue != -1) {
            $query->offset($this->startValue)->limit($this->lengthValue);
        }
        return $query->get();
    }

    // count function
    public function countFilter(){
        $query = $this->getDataTableQuery();
        return $query->get()->count();
    }

    public function countAll(){
        return $this->model::toBase()->get()->count();
    }

    public function withMenuItems($id)
    {
        return $this->model->with('menuItems')->findOrFail($id);
    }
}
