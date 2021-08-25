<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\User;

class UserRepositories extends BaseRepositories{

    protected $order = array('id' => 'desc');

    protected $role_id;
    protected $name;
    protected $email;
    protected $mobile;
    protected $status;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function setRoleId($role_id){
        $this->role_id = $role_id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    public function setStatus($status){
        $this->status = $status;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('user-balk-delete')){
            $this->column_order = [null,'id','id','name','role_id','email','mobile','status','gender',null];
        }else{
            $this->column_order = ['id','id','name','role_id','email','mobile','status','gender',null];
        }
        // user list query
        $query = $this->model->with('role:id,role_name');

        // Menu data filter query
        if(!empty($this->name)){
            $query->where('name', 'like','%' .$this->name. '%');
        }
        if(!empty($this->role_id)){
            $query->where('role_id', 'like','%' .$this->role_id. '%');
        }
        if(!empty($this->email)){
            $query->where('email', 'like','%' .$this->email. '%');
        }
        if(!empty($this->mobile)){
            $query->where('mobile', 'like','%' .$this->mobile. '%');
        }
        if(!empty($this->status)){
            $query->where('status', $this->status);
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
}
