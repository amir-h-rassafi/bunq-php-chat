<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Database\Capsule\Manager as DB;

class BaseRepository
{
    public function __construct(DB $db)
    {
        BaseModel::$db = $db;
    }

}
