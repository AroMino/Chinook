<?php
namespace Chinook\Controllers;

use Chinook\Services\DashboardService;

class DashboardController
{
  private DashboardService $dashboardService;
  public function __construct()
  {
    $this->dashboardService = new DashboardService();
  }

  public function metrics()
  {
    echo json_encode($this->dashboardService->getMetrics(), JSON_PRETTY_PRINT);
  }

  public function revenue_trend()
  {
    echo json_encode($this->dashboardService->getRevenueTrend(), JSON_PRETTY_PRINT);
  }

  public function genre_performance()
  {
    echo json_encode($this->dashboardService->getGenrePerformance(), JSON_PRETTY_PRINT);
  }
  public function top_customers()
  {
    echo json_encode($this->dashboardService->getTopCustomers(), JSON_PRETTY_PRINT);
  }
  public function top_albums()
  {
    echo json_encode($this->dashboardService->getTopAlbums(), JSON_PRETTY_PRINT);
  }
  public function top_tracks()
  {
    echo json_encode($this->dashboardService->getTopTracks(), JSON_PRETTY_PRINT);
  }
  public function tracks_performance()
  {
    echo json_encode($this->dashboardService->getTopTracks(), JSON_PRETTY_PRINT);
  }
}