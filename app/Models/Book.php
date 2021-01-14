<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Class Book
 * @package App\Models
 */
class Book extends Model
{
    protected $table = "Books";

    protected $guarded = ['id'];

    public function detail(): HasOne
    {
        return $this->hasOne(Detail::class, 'book_id', 'id');
    }
}
