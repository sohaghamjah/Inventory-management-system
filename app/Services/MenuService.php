<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\MenuRepositories as Menu;
use App\Repositories\ModuleRepositories as Module;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MenuService extends BaseService{
    protected $menu;
    protected $module;

    public function __construct(Menu $menu, Module $module)
    {
        $this->menu = $menu;
        $this->module = $module;
    }

    /**
     * getDatatableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDatatableData(Request $request){
        if($request -> ajax()){

            // Filter datatable
            if(!empty($request->menu_name)){
                $this->menu-> setMenuName($request->menu_name);
            }

            // Show uer list
            $this->menu-> setOrderValue($request->input('order.0.column'));
            $this->menu-> setDirValue($request->input('order.0.dir'));
            $this->menu-> setLengthValue($request->input('length'));
            $this->menu-> setStartValue($request->input('start'));

            $list = $this->menu-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('menu-builder')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item" href="'.route('menu.builder', $value->id).'" ><i class="fas fa-th-list text-success"></i> Builder</a>';
                }
                if(permission('menu-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('menu-delete')){
                    if($value->deletable == 2){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->menu_name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                }

                $row = [];
                if(permission('menu-bulk-delete')){
                    $row [] = ($value->deletable == 2) ? tableCheckBox($value->id) : '';
                }

                $row []    = $no;
                $row []    = $value->menu_name;
                $row []    = DELETABLE[$value->deletable];
                $row []    = actionButton ($action);
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->menu-> countFilter(), $this->menu-> countAll(), $data);
        }
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated());
        $created_at = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection -> merge(compact('updated_at'));
        }else{
            $collection = $collection -> merge(compact('created_at'));
        }

        return $this->menu->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit(Request $request){
        return $this->menu->find($request->id);
    }

    public function delete(Request $request){
        return $this->menu->delete($request->id);
    }

    public function bulkDelete(Request $request){
        return $this->menu->destroy($request->ids);
    }

    public function orderMenu(array $menu_items, $parent_id){
        foreach($menu_items as $index => $menu_item){
            $item = $this->module->findOrFail($menu_item -> id);
            $item->order = $index + 1;
            $item->parent_id = $parent_id;
            $item->save();
            if(isset($menu_item->children)){
                $this->orderMenu($menu_item->children, $item -> id);
            }
        }
    }
}
