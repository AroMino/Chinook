<?php
namespace Chinook\Services;

use Chinook\Models\Playlist;
use Chinook\Models\PlaylistQuery;
use Chinook\Models\TrackQuery;


class PlaylistService
{
  public function getAllPlaylistsWithDetails()
  {
    $playlists = PlaylistQuery::create()
    ->leftJoin('Playlist.PlaylistTrack')
    ->leftJoin('PlaylistTrack.Track')
    ->withColumn('COUNT(PlaylistTrack.TrackId)', 'TrackCount')
    ->withColumn('SUM(Track.UnitPrice)', 'TotalRevenue')
    ->withColumn('SUM(Track.Milliseconds)', 'TotalDuration')
    ->groupBy('Playlist.PlaylistId')
    ->find();
    $playlists = $playlists->toArray();
    foreach ($playlists as &$row) {
      $row['TotalRevenue'] = (float) $row['TotalRevenue'];
      if ($row['TotalDuration'] === null) $row['TotalDuration'] = 0;
    }
    return array_values($playlists);
  }

  public function getPlaylistTracks(int $id)
  {
    $tracks = TrackQuery::create()
    ->usePlaylistTrackQuery()
        ->filterByPlaylistId($id)
    ->endUse()
    ->joinWithAlbum()
    ->useAlbumQuery()
      ->joinWithArtist()
    ->endUse()
    ->joinWithGenre()
    ->joinWithMediaType()
    ->withColumn('Album.Title', 'AlbumTitle')
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Genre.Name', 'GenreName')
    ->withColumn('MediaType.Name', 'MediaTypeName')
    ->select([
        'TrackId',
        'Name',
        'AlbumId',
        'MediaTypeId',
        'GenreId',
        'Composer',
        'Milliseconds',
        'Bytes',
        'UnitPrice'
    ])
    ->find();

    $tracks = $tracks->toArray();
    foreach ($tracks as &$row) {
      $row['UnitPrice'] = (float) $row['UnitPrice'];
    }
    return array_values($tracks);
  }

  public function getPlaylist(int $id)
  {
    $playlist = PlaylistQuery::create()
    ->findByPlaylistId($id);
    $playlist = $playlist->toArray();

    return array_values($playlist);
  }
  
  public function savePlaylist($data) 
  {
    try {
      $playlist = new Playlist();
      $playlist->setTitle($data["Name"]);
      $playlist->save();

      http_response_code(201);
      echo json_encode([
        "success" => true,
        "message" => "Playlist created successfully",
        "playlist" => $playlist->toArray()
      ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function updatePlaylist($data) 
  {
    try {
      $playlist = PlaylistQuery::create()->findPk($data["PlaylistId"]);
      if (!$playlist) {
        http_response_code(404);
        echo json_encode(["error" => "Playlist not found"]);
        return;
      }
        if (isset($data["Name"])) {
          $playlist->setTitle($data["Title"]);
        }

        $playlist->save(); // Update

        http_response_code(200);
        echo json_encode([
          "success" => true,
          "message" => "Playlist updated successfully",
          "playlist" => $playlist->toArray()
        ]);

    } catch (\Exception $e) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
      ]);
    }
  }
  public function delete($id) 
  {
    try {
      $playlist = PlaylistQuery::create()->findPk($id);
      if (!$playlist) {
        http_response_code(404);
        echo json_encode(["error" => "Playlist not found"]);
        return;
      }

      $playlist->delete();

      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "Playlist deleted successfully",
        "PlaylistId" => $id
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
