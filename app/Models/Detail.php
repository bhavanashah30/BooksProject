<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Detail
 * @package App\Models
 */
class Detail extends Model
{

    protected $table = "Details";

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
