<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses__';
    protected $primaryKey = 'uuid';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
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
        'uuid',
        'place_name',
        'place_status',
        'address_number',
        'address_street',
        'address_postcode',
        'address_city',
        'city_uuid',
        'region_uuid',
        'country_cca3',
        'address_lat',
        'address_lon',
        'description',
        'details',
        'subcategory_slug',
        'osm_id',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'uuid',
        'place_name',
        'place_status',
        'address_number',
        'address_street',
        'address_postcode',
        'address_city',
        'city_uuid',
        'region_uuid',
        'country_cca3',
        'address_lat',
        'address_lon',
        'description',
        'details',
        'subcategory_slug',
        'osm_id',
    ];

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
     * Get the category for a specific place.
     */
    public function belongsToCategory(): HasOneThrough
    {
        return $this->hasOneThrough(
            Category::class,
            Subcategory::class,
            'slug',
            'slug',
            'subcategory_slug',
            'category_slug'
        );
    }

    /**
     * Get the subcategory for a specific place.
     */
    public function belongsToSubcategory(): BelongsTo
    {
        return $this->belongsTo(
            Subcategory::class,
            'subcategory_slug',
            'slug'
        );
    }

    /**
     * Get the country for a specific place.
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
     * Get the city for a specific place.
     */
    public function belongsToCity(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'city_uuid',
            'uuid'
        );
    }

    /**
     * Get the city for a specific place.
     */
    public function hasWikipedia(): HasOne
    {
        return $this->hasOne(
            Wikidata::class,
            'address_uuid',
            'uuid'
        );
    }

}
