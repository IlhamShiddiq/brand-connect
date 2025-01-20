<?php

namespace App\Models;

use App\Traits\UuidModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use UuidModel;

    public static $defaultPerPage = 15;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Boot
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name) . '-' . Str::random(5);
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name) . '-' . Str::random(5);
            }
        });
    }
}
