<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\AttributeValue as Model;

class FilterValueRepository extends CoreRepository
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
    * Get count values filter by id
    */
    public function getCountFilterValuesById($id)
    {
        $count = Model::where('attr_group_id', '=', $id)->count();
        
        return $count;
    }
    
    /**
    * Get all filter values with Group name
    */
    public function getAllValuesFilter($perpage)
    {
        $values = \DB::table('attribute_values')
            ->join('attribute_groups', 'attribute_groups.id', '=', 'attribute_values.attr_group_id')
            ->select('attribute_values.*', 'attribute_groups.title')
            ->paginate($perpage);
            
        return $values;
    }
    
    /**
    * Get filter values with Group name by id
    */
    
    public function getValueInfo($id)
    {
        $value = Model::find($id);
            
        return $value;
    }
    
    /**
    * Checking for unique name in same group
    */
    public function checkUnique($name, $id)
    {
        $unique = Model::where([['value', '=', $name], ['attr_group_id', '=', $id]])->first();
        
        return $unique;
    }
}