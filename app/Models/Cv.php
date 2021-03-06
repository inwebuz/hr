<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function save(array $options = [])
    {
        // add ip address and user agent
        if (!$this->ip_address && request()->ip()) {
            $this->ip_address = request()->ip();
        }
        if (!$this->user_agent && request()->header('User-Agent')) {
            $this->user_agent = request()->header('User-Agent');
        }

        parent::save();
    }
}
