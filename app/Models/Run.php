<?php

namespace App\Models;

use App\Services\CarSynchronizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['path'];

    protected $casts = [
        'path' => 'array',
    ];

    public function sync()
    {
        $syncService = new CarSynchronizer($this->path);
        $syncService->sync();
    }
}
