<?php

namespace App\Http\Controllers\Market\Admin;

use App\Http\Controllers\Market\BaseController as MainBaseController;
use Illuminate\Http\Request;

abstract class AdminBaseController extends MainBaseController
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('status');
        
    }
}
