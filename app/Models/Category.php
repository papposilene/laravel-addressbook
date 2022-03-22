<?php

namespace App\Models;

use App\Exceptions\CategoryDoesNotExist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories__';
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
        'slug',
        'name',
        'icon_image',
        'icon_style',
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
     * Find a category by its uuid.
     *
     * @param string $uuid
     *
     * @throws \App\Exceptions\CategoryDoesNotExist
     *
     * @return Category
     */
    public static function findById(string $uuid): Category
    {
        $category = static::find($uuid);

        if (!$category) {
            throw CategoryDoesNotExist::withId($uuid);
        }

        return $category;
    }

    /**
     * Find a category by its name.
     *
     * @param string $name
     *
     * @throws \App\Exceptions\CategoryDoesNotExist
     *
     * @return Category
     */
    public static function findByName(string $name): Category
    {
        $category = self::where('name', $name)->first();

        if (!$category) {
            throw CategoryDoesNotExist::named($name);
        }

        return $category;
    }

    /**
     * Find a subcategory by its slug.
     *
     * @param string $slug
     *
     * @throws \App\Exceptions\CategoryDoesNotExist
     *
     * @return Category
     */
    public static function findBySlug(string $slug): Category
    {
        $category = self::where('slug', $slug)->first();

        if (!$category) {
            throw CategoryDoesNotExist::withSlug($slug);
        }

        return $category;
    }

    /**
     * A category has many subcategories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasSubcategories(): HasMany
    {
        return $this->hasMany(
            Subcategory::class,
            'category_slug',
            'slug'

        );
    }

}
