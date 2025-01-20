<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Outlet extends Model
{
    use UuidModel;

    public static $defaultPerPage = 15;

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
            $outlet->slug = Str::slug($outlet->name) . '-' . Str::random(5);
        });

        static::updating(function ($outlet) {
            if ($outlet->isDirty('name')) {
                $outlet->slug = Str::slug($outlet->name) . '-' . Str::random(5);
            }
        });
    }
}
