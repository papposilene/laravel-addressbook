<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        //'uuid' => 'uuid',
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
        'city_uuid',
        'region_uuid',
        'country_cca3',
        'address_lat',
        'address_lon',
        'details_openinghours',
        'details_phone',
        'details_website',
        'details_wikidata',
        'description',
        'category_uuid',
        'country_uuid',
        'osm_id',
        'osm_place_id',
        'gmap_pluscode',
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
        'city_uuid',
        'region_uuid',
        'country_cca3',
        'address_lat',
        'address_lon',
        'details_openinghours',
        'details_phone',
        'details_website',
        'details_wikidata',
        'description',
        'category_uuid',
        'country_uuid',
        'osm_id',
        'osm_place_id',
        'gmap_pluscode',
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
    public function belongsToCategory()
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
    public function belongsToSubcategory()
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
    public function belongsToCountry()
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
    public function belongsToCity()
    {
        return $this->belongsTo(
            City::class,
            'city_uuid',
            'uuid'
        );
    }

}
