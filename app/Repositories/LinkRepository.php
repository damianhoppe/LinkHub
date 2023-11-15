<?php

namespace App\Repositories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;

class LinkRepository {

    public function getAll(): Collection {
        return Link::all()->sortBy("order_position");
    }
}