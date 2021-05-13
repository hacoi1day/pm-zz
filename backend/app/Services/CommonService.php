<?php

namespace App\Services;

use App\Models\User;

class CommonService
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function checkUnique ($value, $table, $column, $id = '')
    {
        $id = intval($id);
        switch ($table) {
            case 'users':
                $item = $this->user->where($column, $value)->first();
                if ($item && $item->id !== $id) return 0;
                break;
        }
        return 1;
    }
}
