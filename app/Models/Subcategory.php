<?php

namespace App\Models;

use App\Exceptions\SubcategoryDoesNotExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Subcategory extends Model
{
    use HasTranslations, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories__subcategories';
    protected $primaryKey = 'slug';

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
        'category_slug',
        'slug',
        'name',
        'icon_image',
        'icon_style',
        'icon_color',
        'translations',
        'descriptions',
    ];

    public $translatable = [
        'descriptions',
        'translations'
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
     * A subcategory belongs to one category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToCategory(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_slug',
            'slug'
        );
    }

    /**
     * A subcategory has many addresses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasAddresses(): HasMany
    {
        return $this->hasMany(
            Address::class,
            'subcategory_slug',
            'slug'
        );
    }

    /**
     * Find a subcategory by its uuid.
     *
     * @param string $uuid
     *
     * @throws \App\Exceptions\SubcategoryDoesNotExist
     *
     * @return Subcategory
     */
    public static function findById(string $uuid): Subcategory
    {
        $subcategory = static::find($uuid);

        if (!$subcategory) {
            throw SubcategoryDoesNotExist::withId($uuid);
        }

        return $subcategory;
    }

    /**
     * Find a subcategory by its name.
     *
     * @param string $name
     *
     * @throws \App\Exceptions\SubcategoryDoesNotExist
     *
     * @return Subcategory
     */
    public static function findByName(string $name): Subcategory
    {
        $subcategory = self::where('name', $name)->first();

        if (!$subcategory) {
            throw SubcategoryDoesNotExist::named($name);
        }

        return $subcategory;
    }

    /**
     * Find a subcategory by its slug.
     *
     * @param string $slug
     *
     * @throws \App\Exceptions\SubcategoryDoesNotExist
     *
     * @return Subcategory
     */
    public static function findBySlug(string $slug): Subcategory
    {
        $subcategory = self::where('slug', $slug)->first();

        if (!$subcategory) {
            throw SubcategoryDoesNotExist::withSlug($slug);
        }

        return $subcategory;
    }
}
