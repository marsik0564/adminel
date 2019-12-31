<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\AttributeGroup as Model;

class FilterGroupRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    public function getAllGroupsFilter()
    {
        $groups_filter = Model::all();
        return $groups_filter;
    }   
}