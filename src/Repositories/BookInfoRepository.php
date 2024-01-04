<?php

namespace BookStorePlugin\Repositories;

use BookStorePlugin\Models\BookInfo;

class BookInfoRepository {
    public function __construct() {
    }

    public function updateOrCreate(array $data): BookInfo {
        return BookInfo::updateOrCreate(['post_id' => $data['post_id']], $data);
    }
}
