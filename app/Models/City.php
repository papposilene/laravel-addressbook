<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $primaryKey = 'uuid';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extra' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'laravel_through_key',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_cca3',
        'region_uuid',
        'osm_id',
        'osm_type',
        'osm_admin_level',
        'name_slug',
        'name_local',
        'name_translations',
        'extra',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = [
        'name_translations'
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'country_cca3',
        'region_uuid',
        'osm_id',
        'osm_type',
        'osm_admin_level',
        'name_slug',
        'name_local',
        'name_translations',
        'extra',
    ];

    public function getTable()
    {
        return 'geodata__cities';
    }

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * A city belongs to one country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_cca3',
            'cca3'
        );
    }

    /**
     * A city belongs to one region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToRegion(): BelongsTo
    {
        return $this->belongsTo(
            Region::class,
            'region_uuid',
            'uuid'
        );
    }

    /**
     * A city can have many addresses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasAddresses(): HasMany
    {
        return $this->hasMany(
            Address::class,
            'city_uuid',
            'uuid'
        );
    }
}
