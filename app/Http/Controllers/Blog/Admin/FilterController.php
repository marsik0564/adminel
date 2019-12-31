<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\FilterGroupRepository;
use App\Repositories\Admin\FilterValueRepository;
use MetaTag;

class FilterController extends AdminBaseController
{
    private $filterGroupRepository;
    private $filterValueRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->filterGroupRepository = app(FilterGroupRepository::class);
        $this->filterValueRepository = app(FilterValueRepository::class);
    }
    
    /**
    * Show all groups of filter
    */
    public function groupFilter()
    {
        $filter_groups = $this->filterGroupRepository->getAllGroupsFilter();
        
        MetaTag::setTags(['title' => 'Группы фильтров']);
        return view('blog.admin.filter.filter-group', compact('filter_groups'));
    }
    
    public function valueFilter()
    {
         dd(__METHOD__);
    }
}
