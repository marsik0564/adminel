<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\Product as Model;

class ProductRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    public function getLastProducts($perpage)
    {
        $get = $this->startConditions()
            ->orderBy('id', 'DESC')
            ->limit($perpage)
            ->get();
        
        return $get;
    }
    
    public function getAllProducts($perpage)
    {
        $get_all = $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy/*Raw('LENGTH(products.title)',*/('products.title')
            ->paginate($perpage);
         
        return $get_all;
    }
}