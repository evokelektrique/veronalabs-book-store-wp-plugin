<?php

namespace BookStorePlugin\Models;

use Illuminate\Database\Eloquent\Model;

class BookInfo extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "books_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'isbn',
    ];
}
