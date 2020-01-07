<?php

namespace App\Http\Controllers\Market\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\CategoryRepository;
use App\Models\Admin\Category;
use App\Http\Requests\marketCategoryCreateRequest;
use App\Http\Requests\marketCategoryUpdateRequest;

class CategoryController extends AdminBaseController
{
    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arrMenu = Category::all();

        $menu = $this->categoryRepository->buildMenu($arrMenu);

        Metatag::setTags(['title' => 'Список категорий']);
        
        return view('market.admin.category.index', ['menu' => $menu]);
    }
    
    /**
    * @throws \Exception
    */
    public function mydel()
    {
        $id = $this->categoryRepository->getRequestID();
        
        if (empty($id)) {
            return back()
                ->withErrors(['msg' => 'ошибка идентификатора']);
        }
        
        $children = $this->categoryRepository->checkChildren($id);
        if (!empty($children)) {
            return back()
            ->withErrors(['msg' => 'Удаление невозможно, у выбранной категории есть вложенные категории']);
        }
        
        $parent = $this->categoryRepository->checkParentsProducts($id);
        if (!empty($parent)) {
            return back()
            ->withErrors(['msg' => 'Удаление невозможно, в категории есть товары']);
        }
        
        $delete = $this->categoryRepository->deleteCategory($id);
        if (!empty($delete)) {
            return redirect()
            ->route('market.admin.categories.index')
            ->with(['success' => "Запись №$id удалена"]);
        } else {
            return back()
            ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Category();
        $categoryList = $this->categoryRepository->getComboBoxCategories();
        
        Metatag::setTags(['title' => 'Создание новой категории']);
        return view('market.admin.category.create',[
            'categories' => Category::with('children')
                ->where('parent_id', '=', '0')
                ->get(),
            'delimiter' => '-',
            'item' => $item,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(marketCategoryCreateRequest $request)
    {
        $name = $this->categoryRepository->checkUniqueName($request->title, $request->parent_id);
        
        if (!empty($name)) {
            return back()
                ->withErrors(['msg' => 'В одной категории не может быть двух одинаковых имен.'])
                ->withInput();
        }
        
        $data = $request->input();
        $item = new Category();
        $result = $item->fill($data)->save();
        
        if (!empty($result)) {
            return redirect()
                ->route('market.admin.categories.edit', $item->id)
                ->with(['success' => "Успешно сохранено"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->categoryRepository->getID($id);
        if (empty($item)) {
            abort(404);
        }    
        
        Metatag::setTags(['title' => "Редактирование категории №$id"]);
        return view('market.admin.category.edit',[
            'categories' => Category::with('children')
                ->where('parent_id', '=', '0')
                ->get(),
            'delimiter' => '-',
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(marketCategoryUpdateRequest $request, $id)
    {
        $item = $this->categoryRepository->getID($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись N$id не найдена"])
                ->withInput;
        }    
        
        $data = $request->all();
        $result = $item->update($data);
        
        if (!empty($result)) {
            return redirect()
                ->route('market.admin.categories.edit', [$item->id])
                ->with(['success' => "Успешно сохранено"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
