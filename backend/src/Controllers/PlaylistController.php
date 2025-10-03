<?php
namespace Chinook\Controllers;

use Chinook\Services\PlaylistService;

class PlaylistController
{
	private PlaylistService $playlistService;

	public function __construct()
	{
		$this->playlistService = new PlaylistService();
	}
	public function index()
	{
		echo json_encode($this->playlistService->getAllPlaylistsWithDetails(), JSON_PRETTY_PRINT);
	}
	public function tracks(int $id)
	{
		echo json_encode($this->playlistService->getPlaylistTracks($id), JSON_PRETTY_PRINT);
	}
	
	public function store()
	{
		$rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
    $this->playlistService->savePlaylist($data);
	}
	public function update()
	{
		$rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
		$this->playlistService->updatePlaylist($data);
	}
	public function show(int $id)
	{
		echo json_encode($this->playlistService->getPlaylist($id));
	}
	public function delete()
	{
		$rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
		$this->playlistService->delete($data["PlaylistId"]);
	}
}