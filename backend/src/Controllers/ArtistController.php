<?php
namespace Chinook\Controllers;
use Chinook\Services\ArtistService;

class ArtistController
{
	private ArtistService $artistService;

	public function __construct()
	{
		$this->artistService = new ArtistService();
	}
	public function index()
	{
		echo json_encode($this->artistService->getAllArtists(), JSON_PRETTY_PRINT);
	}
	public function details()
	{
		echo json_encode($this->artistService->getAllArtistsWithDetails(), JSON_PRETTY_PRINT);
	}
	public function albums($id)
	{
		echo json_encode($this->artistService->getArtistAlbums($id), JSON_PRETTY_PRINT);
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
    $this->artistService->saveArtist($data);
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
		$this->artistService->updateArtist($data);
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
		$this->artistService->deleteArtist($data["ArtistId"]);
	}
}