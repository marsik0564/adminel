<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\UserRepository;
use App\Repositories\Admin\MainRepository;
use MetaTag;
use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserEditRequest;
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
        $perpage = 10;
        $item = $this->userRepository->getID($id);
        if (empty($item)) {
            abort(404);
        }
        
        $orders = $this->userRepository->getUserOrders($id, $perpage);
        $role = $this->userRepository->getUserRole($id);
        $count = $this->userRepository->getCountOrders($id);
        Metatag::setTags(['title' => "Редактирование пользователя №{$item->id}"]);
        return view('blog.admin.user.edit', compact('orders', 'role', 'count',  'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AdminUserEditRequest  $request
     * @param  App\Models\Admin\User $user
     * @param  App\Models\Admin\UserRole $role
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserEditRequest $request, User $user, UserRole $role )
    {

        $user->name = $request['name'];
        $user->email = $request['email'];
        if (!empty($request['password'])){
            $user->password = bcrypt($request['password']);
        }
        $save = $user->save();
        
        if (!empty($save)) {
            $role->where('user_id', '=', $user->id)->update(['role_id' => (int)$request['role'] ]);
            return redirect()
                ->route('blog.admin.users.edit', $user->id)
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
     * @param  App\Models\Admin\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $user->forceDelete();
        if ($result){
            return redirect()
                ->route('blog.admin.users.index')
                ->with(['success' => "Пользователь {$user->name} успешно удален"]);
        } else {
            return back()
            ->withErrors(['msg' => 'Ошибка удаления']);
        }
    }
}
