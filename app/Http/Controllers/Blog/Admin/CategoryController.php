<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\CategoryRepository;
use App\Models\Admin\Category;

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
        
        return view('blog.admin.category.index', ['menu' => $menu]);
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
            ->route('blog.admin.categories.index')
            ->with(['success' => "Запись №$id удалена"]);
        } else {
            return back()
            ->withErrors(['msg' => 'ошибка удаления']);
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
        return view('blog.admin.category.create',[
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
