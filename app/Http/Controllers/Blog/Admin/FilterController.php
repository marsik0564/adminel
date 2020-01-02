<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\FilterGroupRepository;
use App\Repositories\Admin\FilterValueRepository;
use MetaTag;
use App\Http\Requests\BlogGroupFilterRequest;
use App\Http\Requests\BlogValueFilterRequest;
use App\Models\Admin\AttributeGroup;
use App\Models\Admin\AttributeValue;

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
        $perpage = 10;
        $values = $this->filterValueRepository->getAllValuesFilter($perpage);
        $count = $this->filterGroupRepository->getCountGroupFilter();
        
        MetaTag::setTags(['title' => 'Фильтры']);
        return view('blog.admin.filter.value-filter', compact('values', 'count'));
    }
    
    /**
    * Add group of filters
    */
    
    public function groupFilterAdd(BlogGroupFilterRequest $request)
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
    
    public function groupFilterEdit(BlogGroupFilterRequest $request, $id)
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
            $group = $this->filterGroupRepository->getGroupInfo($id);
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
    
    
    /**
    * Add value of filters
    */
    
    public function valueFilterAdd(BlogValueFilterRequest $request)
    {
        if ($request->isMethod('post')) {
            $uniqueName = $this->filterValueRepository->checkUnique($request->value, $request->attr_group_id);
            if (!empty($uniqueName)) {
                return back()
                    ->withErrors(['msg' => 'Такое название фильтра в выбранной группе уже есть'])
                    ->withInput();
            }
            $data = $request->input();
            $value = (new AttributeValue())->create($data);
            $value->save();
            
            if (!empty($value)) {
            return redirect('/admin/filter/value-filter')
                ->with(['success' => 'Добавлено новое значение в группу']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка добавления'])
                    ->withInput();
            }
        }
        if ($request->isMethod('get')) {
            $group = $this->filterGroupRepository->getAllGroupsFilter();
            MetaTag::setTags(['title' => 'Новый атрибут для фильтра']);
            return view('blog.admin.filter.value-filter-add', compact('group'));
        }
    }
    
    /**
    * Edit value of filters
    */
    
    public function valueFilterEdit(BlogValueFilterRequest $request, $id)
    {
        if ($request->isMethod('post')) {
            $value = AttributeValue::find($id);
            $value->value = $request->value;
            $value->attr_group_id = $request->attr_group_id;
            $value->save();
            
            if (!empty($value)) {
            return redirect('/admin/filter/value-filter')
                ->with(['success' => 'Успешно изменено']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения']);
            }
        }
        if ($request->isMethod('get')) {
            $value = $this->filterValueRepository->getValueInfo($id);
            $group = $this->filterGroupRepository->getAllGroupsFilter();
            MetaTag::setTags(['title' => 'Редактирование фильтра']);
            return view('blog.admin.filter.value-filter-edit', compact('value', 'group'));
        }
    }
    
    /**
    * Delete value of filters
    */
    
    public function valueFilterDelete($id)
    {
       /* $count = $this->filterValueRepository->getCountFilterValuesById($id);
        
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
        }*/
    }
}
