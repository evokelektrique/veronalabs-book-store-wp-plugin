<?php

namespace BookStorePlugin\Repositories;

use BookStorePlugin\Models\BookInfo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BookInfoRepository
 *
 * Handles database operations for the BookInfo model.
 *
 * @package BookStorePlugin\Repositories
 */
class BookInfoRepository {

    /**
     * Constructor for the BookInfoRepository class.
     */
    public function __construct() {
    }

    /**
     * Retrieve all BookInfo records from the database.
     *
     * @return Collection
     */
    public function all(): Collection {
        return BookInfo::all();
    }

    /**
     * Update or create a BookInfo record in the database.
     *
     * @param array $data The data to update or create the record.
     *
     * @return BookInfo
     */
    public function updateOrCreate(array $data): BookInfo {
        return BookInfo::updateOrCreate(['post_id' => $data['post_id']], $data);
    }
}
