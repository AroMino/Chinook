<?php

namespace Chinook\Services;

use Chinook\Models\Base\MediaTypeQuery;

class MediaTypeService {
  public function getAllTypes() 
  {
    $types = MediaTypeQuery::create()
    ->find()
    ->toArray();
    return array_values($types);
  }
}