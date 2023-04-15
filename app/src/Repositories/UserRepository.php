<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;

class UserRepository extends BaseRepository
{
    public function getUserById($id): ?User
    {
        return User::find($id);
    }

    public function getUsersJson($count): string
    {
        return User::take($count)->get()->toJson();
    }

    public function addUser(string $username): User
    {
        $user = new User;
        
        $user->username = $username;
        $user->save();

        return $user;
    }
}
