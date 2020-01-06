<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MetaTag;

class SearchController extends AdminBaseController
{    
    /**
    * Show result of search
    */
    
    public function index(Request $request)
    {
        $query = trim($request->search) ?? null;
        
        $products = \DB::table('products')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->get();
            
        $currency = \DB::table('currencies')
            ->where('base', '=', '1')
            ->first();    
            
        MetaTag::setTags(['title' => 'Результаты поиска']);
        return view('blog.admin.search.result', compact('query', 'products', 'currency'));
    }
    
    /**
    * For Ajax search
    */
    public function search(Request $request)
    {
        $search = $request->get('term');
         
        $result = \DB::table('products')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->pluck('title');
            
        return response()->json($result);
    }
}
