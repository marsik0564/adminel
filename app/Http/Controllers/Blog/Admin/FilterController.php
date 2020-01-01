<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\FilterGroupRepository;
use App\Repositories\Admin\FilterValueRepository;
use MetaTag;
use App\Http\Requests\BlogGroupFilterAddRequest;
use App\Models\Admin\AttributeGroup;

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
        return view('blog.admin.filter.group-filter', compact('filter_groups'));
    }
    
    public function valueFilter()
    {
        $values = $this->filterValueRepository->getAllValuesFilter();
        $count = $this->filterGroupRepository->getCountGroupFilter();
        
        MetaTag::setTags(['title' => 'Фильтры']);
        return view('blog.admin.filter.group-filter', compact('values', 'count'));
    }
    
    public function groupFilterAdd(BlogGroupFilterAddRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();
            $group = (new AttributeGroup())->create($data);
            $group->save();
            
            if (!empty($group)) {
            return redirect('/admin/filter/group-filter')
                ->with(['success' => 'Добавлена новая группа']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка создания новой группы'])
                    ->withInput();
            }
        }
        if ($request->isMethod('get')) {
            MetaTag::setTags(['title' => 'Новая группа фильтров']);
            return view('blog.admin.filter.group-filter-add');
        }
    }
    
    /**
    * Edit group of filters
    */
    
    public function groupFilterEdit(BlogGroupFilterAddRequest $request, $id)
    {
        if ($request->isMethod('post')) {
            $group = AttributeGroup::find($id);
            $group->title = $request->title;
            $group->save();
            
            if (!empty($group)) {
            return redirect('/admin/filter/group-filter')
                ->with(['success' => 'Успешно изменено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения']);
            }
        }
        if ($request->isMethod('get')) {
            $group = $this->filterGroupRepository->getInfoProduct($id);
            MetaTag::setTags(['title' => 'Редактирование группы фильтров']);
            return view('blog.admin.filter.group-filter-edit', compact('group'));
        }
    }
    
    /**
    * Delete group of filters
    */
    
    public function groupFilterDelete($id)
    {
        $count = $this->filterValueRepository->getCountFilterValuesById($id);
        
        if ($count > 0) {
                return back()
                    ->withErrors(['msg' => 'Ошибка удаления, нельзя удалить группу с атрибутами']);
            }
            
        $delete = $this->filterGroupRepository->deleteGroupFilter($id);
        
        if (!empty($delete)) {
            return redirect('/admin/filter/group-filter')
                ->with(['success' => 'Успешно удалено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
