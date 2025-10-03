<?php
namespace Chinook\Controllers;

use Chinook\Services\AlbumService;

class AlbumController
{
	private AlbumService $albumService;

	public function __construct()
	{
		$this->albumService = new AlbumService();
	}

	public function index()
	{
		echo json_encode($this->albumService->getAllAlbums(), JSON_PRETTY_PRINT);
	}

	public function details()
	{
		echo json_encode($this->albumService->getAllAlbumsWithDetails(), JSON_PRETTY_PRINT);
	}

	public function tracks(int $id)
	{
		echo json_encode($this->albumService->getAlbumTracks($id), JSON_PRETTY_PRINT);
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
    $this->albumService->saveAlbum($data);
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
		$this->albumService->updateAlbum($data);
	}

	public function show(int $id)
	{
		echo json_encode($this->albumService->getAlbum($id));
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
		$this->albumService->deleteAlbum($data["AlbumId"]);
	}

}