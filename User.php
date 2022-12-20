<?php

namespace App\Service;

use App\Models\User;
use App\Models\Category;
use App\Models\Permission;

class UserService
{
    public function __construct(
        User $user,
        Category $category, 
        Permission $permission
    ) {
        $this->user = $user;
        $this->category = $category;
        $this->permission = $permission;
    }

    public function createUser($params)
    {
        $user = [
            'name' => $param['name'],
            'email' => $param['email']
        ];
        
        if (isset($param['password'])) {
        	$user['password'] = bcrypt($param['password']);
        }
        
        return $this->user->create($user);
    }

    public function search($param){
    	$userSearch = $this->user;
        
    	if ($param['keyword']) {
    		$userSearch->where('name', 'like', '%' . $param['keyword']);
    	}
        
    	return $userSearch->with("role",'group')
            ->where('status', true)
            ->whereHas('schedule')
            ->paginate(5);
    }
}
