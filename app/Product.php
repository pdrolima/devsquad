<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
        'price'
    ];

     /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['department'];

    /**
     * A product belongs to a department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }

    /**
     * Get product image.
     */
    public function getProductImage()
    {
        return ! is_null($this->image) 
            ? url($this->image)
            : null;
    }
}
