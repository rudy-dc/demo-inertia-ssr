<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function vehicleConstructor(): BelongsTo
    {
        return $this->belongsTo(VehicleConstructor::class)->withTrashed();
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class)->withTrashed();
    }

    public function vehicleSpecification(): BelongsTo
    {
        return $this->belongsTo(VehicleSpecification::class)->withTrashed();
    }
}
