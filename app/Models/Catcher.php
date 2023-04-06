<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catcher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['designation'];

    public function catcherable(): MorphTo
    {
        return $this->morphTo();
    }
}
