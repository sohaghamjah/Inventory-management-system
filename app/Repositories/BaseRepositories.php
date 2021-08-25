<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositories{
    // =============== Datatable Default option set property===============
    protected $model;
    protected $column_order;

    protected $orderValue;
    protected $dirValue;
    protected $lengthValue;
    protected $startValue;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * create function
     *
     * @param array $attributes
     * @return void
     */
    public function create(array $attributes){
        return $this->model->create($attributes);
    }

    /**
     * insert function
     *
     * @param array $attributes
     * @return void
     */
    public function insert(array $attributes){
        return $this->model->insert($attributes);
    }

    /**
     * update function
     *
     * @param array $attributes
     * @param [type] $id
     * @return boolean
     */
    public function update(array $attributes, $id) :bool{
        return $this->model->find($id)->update($attributes);
    }

    /**
     * updateOrCreate function
     *
     * @param array $search_data
     * @param array $attributes
     * @return void
     */
    public function updateOrCreate(array $search_data,array $attributes){
        return $this->model->updateOrCreate($search_data,$attributes);
    }

    /**
     * updateOrInsert function
     *
     * @param array $search_data
     * @param array $attributes
     * @return void
     */
    public function updateOrInsert(array $search_data,array $attributes){
        return $this->model->updateOrInsert($search_data,$attributes);
    }

    /**
     * Undocumented function
     *
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return void
     */
    public function all($columns=array('*'), string $orderBy='id', string $sortBy='desc'){
        return $this->model->orderBy($orderBy,$sortBy)->get($columns);
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id){
        return $this->model->find($id);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * @throws ModelNotFountException
     */
    public function findOrFail($id){
        return $this->model->findOrFail($id);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return void
     */
    public function findBy(array $data){
        return $this->model->where($data)->get();
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return void
     */
    public function findOneBy(array $data){
        return $this->model->where($data)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneByFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        return $this->model->find($id)->delete();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function destroy(array $data) : bool
    {
        return $this->model->destroy($data);
    }

    // ================Datatable Defalut option set method===============

    public function setOrderValue($orderValue){
        $this->orderValue = $orderValue;
    }

    public function setDirValue($dirValue){
        $this->dirValue = $dirValue;
    }

    public function setLengthValue($lengthValue){
        $this->lengthValue = $lengthValue;
    }

    public function setStartValue($startValue){
        $this->startValue = $startValue;
    }
}
