<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['designation', 'slug', 'vehicle_constructor_id', 'is_visible'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFullDesignationAttribute()
    {
        return $this->vehicleConstructor->designation . ' ' . $this->designation;
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('is_visible', true);
    }

    public function vehicleConstructor(): BelongsTo
    {
        return $this->belongsTo(VehicleConstructor::class)->withTrashed();
    }

    public function vehicleSpecifications(): HasMany
    {
        return $this->hasMany(VehicleSpecification::class);
    }

    public function catchers(): MorphMany
    {
        return $this->morphMany(Catcher::class, 'catcherable');
    }
}
