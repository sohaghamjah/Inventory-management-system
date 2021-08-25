<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\Permission;

class PermissionRepositories extends BaseRepositories{

    protected $order = array('id' => 'desc');
    protected $name;
    protected $module_id;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function setName($name){
        $this->name = $name;
    }
    public function setModuleId($module_id){
        $this->module_id = $module_id;
    }

    // datatable list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('permission-bulk-delete')){
            $this->column_order = [null,'id','module_id','name','slug',null];
        }else{
            $this->column_order = ['id','module_id','name','slug',null];
        }
        // datatable list query
        $query = $this->model->with('module:id,module_name');

        // datatable data filter query
        if(!empty($this->name)){
            $query->where('name', 'like','%' .$this->name. '%');
        }
        if(!empty($this->module_id)){
            $query->where('module_id', $this->module_id);
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

    public function permissionSessionList(){
        return $this->model->select('slug')->get();
    }

}
