<?php

namespace Chinook\Services;

use Chinook\Models\Base\TrackQuery;
use Chinook\Models\Track;

class TrackService {
  private AlbumService $albumService;
  private GenreService $genreService;
  private MediaTypeService $mediaTypeService;

  public function __construct()
  {
    $this->albumService = new AlbumService();
    $this->genreService = new GenreService();
    $this->mediaTypeService = new MediaTypeService();
  }
  public function getAllTracks() 
  {
    $tracks = TrackQuery::create()
    ->joinWithAlbum()
    ->useAlbumQuery()
      ->joinWithArtist()
    ->endUse()
    ->joinWithGenre()
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Genre.Name', 'GenreName')
    ->withColumn('Album.Title', 'AlbumTitle')
    ->select(['Name', 'Composer', 'Milliseconds', 'Bytes', 'UnitPrice', 'TrackId', 'AlbumId', 'GenreId'])
    ->find()
    ->toArray();
    foreach ($tracks as &$row) {
      $row['UnitPrice'] = (float) $row['UnitPrice'];
    }
    return array_values($tracks);
  }

  public function getAllTracksWithDetails() 
  {
    $tracks = TrackQuery::create()
    ->leftJoinWithAlbum()
    ->useAlbumQuery()
      ->leftJoinWithArtist()
    ->endUse()
    ->leftJoinWithGenre()
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Genre.Name', 'GenreName')
    ->withColumn('Album.Title', 'AlbumTitle')
    ->select(['Name', 'Composer', 'Milliseconds', 'Bytes', 'UnitPrice', 'TrackId', 'AlbumId', 'GenreId'])
    ->find()
    ->toArray();
    foreach ($tracks as &$row) {
      $row['UnitPrice'] = (float) $row['UnitPrice'];
    }
    return array_values($tracks);
  }

  public function getFormUtils() {
    $albums = $this->albumService->getAllAlbums();
    $genres = $this->genreService->getAllGenres();
    $types = $this->mediaTypeService->getAllTypes();

    $results = [
      "albums" => $albums,
      "genres" => $genres,
      "mediaTypes" => $types
    ];
    return $results;
  }

  public function saveTrack($data)
  {
    try {
      $track = new Track();
      $track->setName($data["Name"]);
      $track->setMilliseconds($data["Milliseconds"]);
      $track->setMediaTypeId($data["MediaTypeId"]);
      $track->setUnitPrice($data["UnitPrice"]);
      if(isset($data["AlbumId"])) $track->setAlbumId($data["AlbumId"]);
      if(isset($data["Composer"])) $track->setComposer($data["Composer"]);
      if(isset($data["GenreId"]))  $track->setGenreId($data["GenreId"]);
      $track->save();

      http_response_code(201);
      echo json_encode([
        "success" => true,
        "message" => "Track created successfully",
        "album" => $track->toArray()
      ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }

  public function updateTrack($data) 
  {
    try {
      $track = TrackQuery::create()->findPk($data["TrackId"]);
      if (!$track) {
        http_response_code(404);
        echo json_encode(["error" => "Track not found"]);
        return;
      }
      if(isset($data["Name"])) $track->setName($data["Name"]);
      if(isset($data["Milliseconds"])) $track->setMilliseconds($data["Milliseconds"]);
      if(isset($data["MediaTypeId"])) $track->setMediaTypeId($data["MediaTypeId"]);
      if(isset($data["UnitPrice"])) $track->setUnitPrice($data["UnitPrice"]);
      if(isset($data["AlbumId"])) $track->setAlbumId($data["AlbumId"]);
      if(isset($data["Composer"])) $track->setComposer($data["Composer"]);
      if(isset($data["GenreId"]))  $track->setGenreId($data["GenreId"]);

      $track->save();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Track updated successfully",
        "album" => $track->toArray()
      ]);
    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function deleteTrack($id) 
  {
    try {
      $track = TrackQuery::create()->findPk($id);
      if (!$track) {
        http_response_code(404);
        echo json_encode(["error" => "Track not found"]);
        return;
      }

      $track->delete();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Track deleted successfully",
        "AlbumId" => $id
      ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
}