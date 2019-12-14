<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\UserRepository;
use App\Repositories\Admin\MainRepository;
use MetaTag;
use App\Http\Requests\AdminUserCreateRequest;
use App\Models\Admin\User;
use App\Models\UserRole;

class UserController extends AdminBaseController
{
    private $userRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 8;
        $countUsers = MainRepository::getCountUsers();
        $paginator = $this->userRepository->getAllUsers($perpage);
        
        Metatag::setTags(['title' => 'Список пользователей']);
        return view('blog.admin.user.index', compact('countUsers', 'paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Metatag::setTags(['title' => 'Добавление пользователя']);
        return view('blog.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        
        if (!empty($user)) {
            $role = UserRole::create([
                'user_id' => $user->id,
                'role_id' => (int)$request['role'],
            ]);
            
            if (!empty($role)) {
            return redirect()
                ->route('blog.admin.users.index')
                ->with(['success' => "Успешно сохранено"]);
            } else {
                return back()
                    ->withErrors(['msg' => 'Ошибка сохранения роли'])
                    ->withInput();
            }
            
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
        dd(__METHOD__, $id);
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
        dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
}
