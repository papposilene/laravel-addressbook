<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Wikidata extends Model
{
    use HasTranslations, SoftDeletes;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses__wikipedia';
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
        'wikipedia_title' => 'array',
        'wikipedia_text' => 'array',
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
        'address_uuid',
        'wikidata_id',
        'wikipedia_pid',
        'wikipedia_title',
        'wikipedia_text',
    ];

    /**
     * The attributes that are visible.
     *
     * @var array
     */
    protected $visible = [
        'uuid',
        'address_uuid',
        'wikidata_id',
        'wikipedia_pid',
        'wikipedia_title',
        'wikipedia_text',
    ];

    public $translatable = [
        'wikipedia_title',
        'wikipedia_text'
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

}
