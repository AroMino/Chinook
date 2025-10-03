<?php

namespace Chinook\Services;

use Chinook\Models\Base\GenreQuery;

class GenreService {
  public function getAllGenres() 
  {
    $genres = GenreQuery::create()
    ->find()
    ->toArray();
    return array_values($genres);
  }
}