<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    public function tags() {
        return $this->hasMany(Tag::class, 'cliente_id');
    }
}
