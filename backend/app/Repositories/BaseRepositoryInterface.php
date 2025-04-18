<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function fetch(); // paginate

    public function find($id); // single collection
}
