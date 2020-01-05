<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\Currency as Model;

class CurrencyRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    /**
    * Return all currency
    */
    public function getAllCurrency()
    {
        $currency = Model::all();
        
        return $currency;
    }
    
    public function switchBaseCurrency()
    {
        Model::where('base', '=', '1')->update(['base' => '0']);
    }
    
    public function getCurrencyById($id)
    {
        $currency = $this->startConditions()->find($id);
        
        return $currency;
    }
    
    public function deleteCurrency($id)
    {
        $delete = $this->startConditions()
            ->where('id', '=', $id)
            ->forceDelete();
            
        return $delete;
    }
}
