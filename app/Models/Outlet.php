<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Outlet extends Model
{
    use HasFactory, UuidModel;

    public static $defaultPerPage = 10;

    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'phone_number',
        'description',
        'address',
        'latitude',
        'longitude',
    ];

    /**
     * Boot
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($outlet) {
            $outlet->id = (string) Str::uuid();
            $outlet->slug = Str::slug($outlet->name) . '-' . Str::random(5);
        });

        static::updating(function ($outlet) {
            if ($outlet->isDirty('name')) {
                $outlet->slug = Str::slug($outlet->name) . '-' . Str::random(5);
            }
        });
    }

    // Scopes

    /**
     * Get nearest outlet from location scope
     *
     * @param Builder $builder
     * @param string $latitude
     * @param string $longitude
     * @return Builder
     */
    public function scopeGetNearest(Builder $builder, string $latitude, string $longitude): Builder
    {
        $distanceFormula = '(6371 * acos(cos(radians(?)) * cos(radians(latitude))
            * cos(radians(longitude) - radians(?))
            + sin(radians(?)) * sin(radians(latitude))))';

        return $builder
            ->selectRaw(
                "outlets.*, $distanceFormula AS distance",
                [$latitude, $longitude, $latitude]
            )
            ->whereRaw("$distanceFormula <= 25.0", [$latitude, $longitude, $latitude]);
    }

    // Relation

    /**
     * Brand
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
