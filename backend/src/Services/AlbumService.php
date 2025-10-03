<?php
namespace Chinook\Services;

use Chinook\Models\Album;
use Chinook\Models\AlbumQuery;
use Chinook\Models\TrackQuery;


class AlbumService
{
  public function getAllAlbums()
  {
    $albums = AlbumQuery::create()
    ->leftJoinWithArtist()
    ->withColumn("Artist.Name", "ArtistName")
    ->select(['AlbumId', 'Title', 'ArtistId'])
    ->find()
    ->toArray();
    return array_values($albums);
  }

  public function getAllAlbumsWithDetails()
  {
    $albums = AlbumQuery::create()
    ->leftJoin('Album.Artist')
    ->leftJoin('Album.Track')
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Artist.ArtistId', 'ArtistId')
    ->withColumn('COUNT(Track.TrackId)', 'TrackCount')
    ->withColumn('SUM(Track.UnitPrice)', 'TotalRevenue')
    ->withColumn('SUM(Track.Milliseconds)', 'TotalDuration')
    ->groupBy('Album.AlbumId')
    ->find();
    $albums = $albums->toArray();
    foreach ($albums as &$row) {
      $row['TotalRevenue'] = (float) $row['TotalRevenue'];
    }
    return array_values($albums);
  }



  public function getAlbumTracks(int $id)
  {
    $tracks = TrackQuery::create()
    ->findByAlbumId($id);
    $tracks = $tracks->toArray();

    foreach ($tracks as &$row) {
      $row['UnitPrice'] = (float) $row['UnitPrice'];
    }
    return array_values($tracks);
  }

  public function getAlbum(int $id)
  {
    $album = AlbumQuery::create()
    ->findByAlbumId($id);
    $album = $album->toArray();

    return array_values($album);
  }
  
  public function saveAlbum($data) 
  {
    try {
      $album = new Album();
      $album->setTitle($data["Title"]);
      $album->setArtistId($data["ArtistId"]);
      $album->save();

      http_response_code(201);
      echo json_encode([
        "success" => true,
        "message" => "Album created successfully",
        "album" => $album->toArray()
      ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function updateAlbum($data) 
  {
    try {
      $album = AlbumQuery::create()->findPk($data["AlbumId"]);
      if (!$album) {
        http_response_code(404);
        echo json_encode(["error" => "Album not found"]);
        return;
      }
      if (isset($data["Title"])) {
        $album->setTitle($data["Title"]);
      }
      if (isset($data["ArtistId"])) {
        $album->setArtistId($data["ArtistId"]);
      }

      $album->save();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Album updated successfully",
        "album" => $album->toArray()
      ]);
    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function deleteAlbum($id) 
  {
    try {
      $album = AlbumQuery::create()->findPk($id);
      if (!$album) {
        http_response_code(404);
        echo json_encode(["error" => "Album not found"]);
        return;
      }

      $album->delete();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Album deleted successfully",
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
