<?php
namespace App\Services;

class BaseService{
    protected function datatableDraw($draw, $recordsTotal, $recordsFiltered, $data){
        return array(
            "draw" => $draw,
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        );
    }
}
