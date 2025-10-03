<?php
namespace Chinook\Services;

use Chinook\Models\Artist;
use Chinook\Models\ArtistQuery;
use Chinook\Models\Base\AlbumQuery;


class ArtistService
{
  public function getAllArtists()
  {
    $artists = ArtistQuery::create()
      ->find()
      ->toArray();
    return array_values($artists);
  }

  public function getAllArtistsWithDetails()
  {
    $artists = ArtistQuery::create()
    ->leftJoin('Album')
    ->leftJoin('Album.Track')
    ->withColumn('COUNT(DISTINCT Album.AlbumId)', 'AlbumCount')
    ->withColumn('COUNT(Track.TrackId)', 'TrackCount')
    ->groupBy('Artist.ArtistId')
    ->find()
    ->toArray();
    return array_values($artists);
  }

  public function getArtistAlbums($id)
  {
    $albums = AlbumQuery::create()
    ->leftJoin('Album.Artist')
    ->useArtistQuery()
      ->filterByArtistId($id)
    ->endUse()
    ->leftJoin('Album.Track')
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Artist.ArtistId', 'ArtistId')
    ->withColumn('COUNT(Track.TrackId)', 'TrackCount')
    ->withColumn('SUM(Track.UnitPrice)', 'TotalRevenue')
    ->withColumn('SUM(Track.Milliseconds)', 'TotalDuration')
    ->groupBy('Album.AlbumId')
    ->find()
    ->toArray();
    foreach ($albums as &$row) {
      $row['TotalRevenue'] = (float) $row['TotalRevenue'];
    }
    return array_values($albums);
  }

  public function saveArtist($data) 
  {
    try {
      $artist = new Artist();
      $artist->setName($data["Name"]);
      $artist->save();

      http_response_code(201);
      echo json_encode([
        "success" => true,
        "message" => "Artist created successfully",
        "artist" => $artist->toArray()
      ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function updateArtist($data) 
  {
    try {
      $artist = ArtistQuery::create()->findPk($data["ArtistId"]);
      if (!$artist) {
        http_response_code(404);
        echo json_encode(["error" => "Artist not found"]);
        return;
      }
      if (isset($data["Name"])) {
        $artist->setName($data["Name"]);
      }

      $artist->save();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Artist updated successfully",
        "artist" => $artist->toArray()
      ]);
    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function deleteArtist($id) 
  {
    try {
      $artist = ArtistQuery::create()->findPk($id);
      if (!$artist) {
        http_response_code(404);
        echo json_encode(["error" => "Artist not found"]);
        return;
      }

      $artist->delete();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Artist deleted successfully",
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
