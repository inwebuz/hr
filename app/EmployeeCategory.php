<?php

namespace App;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class EmployeeCategory extends Model
{
    use HasFactory;
    use Resizable;
    use Translatable;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $translatable = ['name'];

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
