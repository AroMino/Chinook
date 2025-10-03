<?php

namespace Chinook\Controllers;

use Chinook\Services\TrackService;

class TrackController {
  private TrackService $trackService;
  public function __construct()
  {
    $this->trackService = new TrackService();
  }

  public function index() {
    echo json_encode($this->trackService->getAllTracks(), JSON_PRETTY_PRINT);
  }
  
  public function details() {
    echo json_encode($this->trackService->getAllTracksWithDetails(), JSON_PRETTY_PRINT);
  }

  public function store() {
    $rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
    $this->trackService->saveTrack($data);
  }

  public function update() {
    $rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
    $this->trackService->updateTrack($data);
  }

  public function delete() {
    $rawInput = file_get_contents("php://input");
    $data = json_decode($rawInput, true);

    if (!$data) {
      http_response_code(400);
      echo json_encode(["error" => "Invalid JSON"]);
      return;
    }
    $this->trackService->deleteTrack($data["TrackId"]);
  }

  public function form_utils() 
  {
    echo json_encode($this->trackService->getFormUtils(), JSON_PRETTY_PRINT);
  }
}