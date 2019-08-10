<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * A product belongs to a department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category');
    }
}
