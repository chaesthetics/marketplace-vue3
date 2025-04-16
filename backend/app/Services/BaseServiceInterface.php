<?php

namespace App\Services;

interface BaseServiceInterface
{
    public function create(array $payload): mixed;

    public function update($id, array $payload): mixed;

    public function destroy($id);
}
