<?php

namespace App\Repositories\Admin;

use App\Repositories\CoreRepository;
use App\Models\Admin\User as Model;

class UserRepository extends CoreRepository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    protected function getModelClass()
    {
        return Model::class;
    }
    
    public function getAllUsers($perpage)
    {
        $users = $this->startConditions()
            ->join('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_roles.role_id')
            ->select('users.id', 'users.name', 'users.email', 'roles.name as role')
            ->orderBy('users.id')
            ->toBase()
            ->paginate($perpage);
            
        return $users;
    }
}