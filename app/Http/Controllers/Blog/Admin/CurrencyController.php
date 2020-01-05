<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;
use App\Repositories\Admin\CurrencyRepository;
use App\Models\Admin\Currency;
use App\Http\Requests\AdminCurrencyRequest;

class CurrencyController extends AdminBaseController
{
    private $currencyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRepository = app(CurrencyRepository::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = $this->currencyRepository->getAllCurrency();
        
        MetaTag::setTags(['title' => 'Валюта магазина']);
        return view('blog.admin.currency.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        MetaTag::setTags(['title' => 'Добавление валюты']);
        return view('blog.admin.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCurrencyRequest $request)
    {
        $data = $request->input();
        $data['base'] = $request->base ? '1' : '0';
        
        if ($data['base'] == '1') {
            $this->currencyRepository->switchBaseCurrency();
        }
        
        $currency = (new Currency())->create($data);
        $save = $currency->save();
        
        if (!empty($save)) {
            return redirect()
                ->route('blog.admin.currencies.index')
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
        $currency = $this->currencyRepository->getCurrencyById($id);
        
        MetaTag::setTags(['title' => 'Редактирование валюты']);
        return view('blog.admin.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCurrencyRequest $request, $id)
    {
        $currency = Currency::find($id); 
        if (empty($currency)) {
            return back()
                ->withErrors(['msg' => "Запись N$id не найдена"])
                ->withInput;
        }    
        
        $data = $request->all();        
        $data['base'] = $request->base ? '1' : '0';
        if ($data['base'] == '1' && $currency->base == '0') {
            $this->currencyRepository->switchBaseCurrency();
        }
        $result = $currency->update($data);
        
        if (!empty($result)) {
            return redirect()
                ->route('blog.admin.currencies.edit', $id)
                ->with(['success' => "Успешно сохранено"]);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения']);
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
    
    public function delete($id)
    { 
        $delete = $this->currencyRepository->deleteCurrency($id);
        if (!empty($delete)) {
            return redirect()
            ->route('blog.admin.currencies.index')
            ->with(['success' => "Запись №$id удалена"]);
        } else {
            return back()
            ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
