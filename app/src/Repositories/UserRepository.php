<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use App\Utils\Pager;

class UserRepository extends BaseRepository
{
    public function getUserById($id): ?User
    {
        return User::find($id);
    }

    public function getUsersJson(Pager $pager): string
    {
        return User::skip($pager->getOffset())->take($pager->size)->get()->toJson();
    }

    public function addUser(string $username): User
    {
        //todo add business exception
        if (empty($username)) {
            throw new \Exception('Empty username');
        }
        
        $user = new User;
        
        $user->username = $username;
        $user->save();

        return $user;
    }
}
