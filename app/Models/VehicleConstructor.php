<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleConstructor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['designation', 'slug'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function vehicleModels(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function vehicleSpecifications(): HasMany
    {
        return $this->hasMany(VehicleSpecification::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function catchers(): MorphMany
    {
        return $this->morphMany(Catcher::class, 'catcherable');
    }
}
