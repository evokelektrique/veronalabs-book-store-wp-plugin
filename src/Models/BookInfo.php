<?php

namespace BookStorePlugin\Models;

use Illuminate\Database\Eloquent\Model;

class BookInfo extends Model {
    protected $table = "books_info";

    protected $fillable = [
        'post_id',
        'isbn',
    ];
}
