<?php
namespace Chinook\Services;

use Chinook\Models\ArtistQuery;
use Chinook\Models\AlbumQuery;
use Chinook\Models\InvoiceQuery;
use Chinook\Models\CustomerQuery;
use Chinook\Models\TrackQuery;
use Chinook\Models\GenreQuery;
use Chinook\Models\InvoiceLineQuery;

class DashboardService
{
  public function getMetrics()
  {
    $tracksCount = TrackQuery::create()->count() ?? 0;
    $albumsCount = AlbumQuery::create()->count() ?? 0;
    $artistsCount = ArtistQuery::create()->count() ?? 0;
    $customersCount = CustomerQuery::create()->count() ?? 0;

    $lastYearTotalRevenue = InvoiceQuery::create()
    ->filterByInvoiceDate([
        // 'min' => date('Y-01-01 00:00:00', strtotime('-1 year')), // début de l'année dernière
        'max' => date('Y-12-31 23:59:59', strtotime('-1 year'))  // fin de l'année dernière
    ])
    ->withColumn('SUM(Total)', 'TotalRevenue')
    ->select('TotalRevenue')
    ->findOne();

    $lastYearTotalSales = InvoiceLineQuery::create()
    ->joinInvoice()
    ->useInvoiceQuery()
      ->filterByInvoiceDate([
        // 'min' => date('Y-01-01 00:00:00', strtotime('-1 year')), // début de l'année dernière
        'max' => date('Y-12-31 23:59:59', strtotime('-1 year'))  // fin de l'année dernière
    ])
    ->endUse()
    ->withColumn('SUM(InvoiceLine.Quantity)', 'TotalSales')
    ->select('TotalSales')
    ->findOne();

    $lastYearTotalRevenue = $lastYearTotalRevenue ?? 0;
    $lastYearTotalSales = $lastYearTotalSales ?? 0;

    $totalRevenue = InvoiceQuery::create()
    ->withColumn('SUM(Total)', 'TotalRevenue')
    ->select('TotalRevenue')
    ->findOne();

    $totalSales = InvoiceLineQuery::create()
    ->withColumn('SUM(InvoiceLine.Quantity)', 'TotalSales')
    ->select('TotalSales')
    ->findOne();

    $totalRevenue = $totalRevenue ?? 0;
    $totalSales = $totalSales ?? 0;

    return [
      'tracks' => $tracksCount,
      'albums' => $albumsCount,
      'artists' => $artistsCount,
      'customers' => $customersCount,
      'totalRevenue' => $totalRevenue,
      'totalSales' => $totalSales,
      'lastYearRevenue' => $lastYearTotalRevenue,
      'lastYearSales' => $lastYearTotalSales,
      'revenueGrowth' => $lastYearTotalRevenue > 0 ? ($totalRevenue - $lastYearTotalRevenue) / $lastYearTotalRevenue * 100 : 0,
      'salesGrowth' => $lastYearTotalSales > 0 ? ($totalSales - $lastYearTotalSales) / $lastYearTotalSales * 100 : 0
    ];
  }

  public function getRevenueTrend() {
    $query = InvoiceQuery::create()
    ->joinInvoiceLine()
    ->filterByInvoiceDate(['max' => date('Y-m-d', strtotime('now'))])
    ->withColumn('EXTRACT(YEAR FROM Invoice.InvoiceDate)', 'year')
    ->withColumn('EXTRACT(MONTH FROM Invoice.InvoiceDate)', 'month')
    ->withColumn('SUM(Total)', 'revenue')
    ->withColumn('COUNT(InvoiceLine.InvoiceLineId)', 'sales')
    ->groupBy('year')
    ->groupBy('month')
    ->orderBy('year')
    ->orderBy('month')
    ->select(['year','month','revenue','sales'])
    ->find()
    ->toArray();

    $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
        7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
    ];

    $result = [];
    foreach ($query as $row) {
        $result[] = [
            'month' => $months[(int)$row['month']],
            'revenue' => (float)$row['revenue'],
            'sales' => (int)$row['sales'],
            'year' => (int)$row['year'],
        ];
    }
    return $result;
  }

  public function getGenrePerformance() {
    $results = GenreQuery::create()
    ->joinTrack()
    ->useTrackQuery()
      ->joinInvoiceLine()
    ->endUse()
    ->withColumn('SUM(InvoiceLine.UnitPrice * InvoiceLine.Quantity)', 'Revenue')
    ->withColumn('SUM(InvoiceLine.Quantity)', 'Sales')
    ->withColumn('Genre.GenreId', 'GenreId')
    ->withColumn('Genre.Name', 'GenreName')
    ->groupBy('Genre.GenreId')
    ->select(['GenreId', 'GenreName'])
    ->orderBy('Revenue', 'DESC')
    ->limit(6)
    ->find()
    ->toArray();

    $total = InvoiceQuery::create()
    ->withColumn('SUM(Total)', 'TotalRevenue')
    ->select(['TotalRevenue'])
    ->findOne();

    $total = (float) $total;
    $otherRevenue = $total;

    foreach($results as &$row) {
      $row["Revenue"] = (float) $row["Revenue"];
      $row["Percentage"] = round(($row["Revenue"]*100) / $total, 2);
      $otherRevenue -= $row["Revenue"];
    }

    $row = [];
    $row["GenreId"] = 0;
    $row["GenreName"] = "Other";
    $row["Revenue"] = $otherRevenue;
    $row["Percentage"] = round(($row["Revenue"]*100) / $total, 2);

    return $results;
  }

  public function getTopCustomers() {
    $results = CustomerQuery::create()
    ->leftJoinInvoice()
    ->withColumn('COALESCE(SUM(Invoice.Total), 0)', 'TotalSpent')
    ->groupBy('Customer.CustomerId')
    ->select(['CustomerId', 'FirstName', 'LastName', 'TotalSpent', 'Email', 'Country'])
    ->orderBy('TotalSpent', 'DESC')
    ->limit(5)
    ->find()
    ->toArray();

    foreach ($results as &$row) {
      $row['TotalSpent'] = (float) $row['TotalSpent'];
    }

    return $results;
  }

  public function getTopAlbums() {
    $results = AlbumQuery::create()
    ->leftJoinArtist()
    ->leftJoinTrack()
    ->useTrackQuery()
      ->joinInvoiceLine()
    ->endUse()
    ->withColumn('SUM(InvoiceLine.UnitPrice * InvoiceLine.Quantity)', 'Revenue')
    ->withColumn('SUM(InvoiceLine.Quantity)', 'Sales')
    ->withColumn('Artist.Name', 'ArtistName')
    ->groupBy('Album.AlbumId')
    ->select(['AlbumId', 'Title', 'ArtistName'])
    ->orderBy('Revenue', 'DESC')
    ->limit(10)
    ->find()
    ->toArray();
    return $results;
  }

  public function getTopTracks() {
    $results = TrackQuery::create()
    ->leftJoinAlbum()
    ->useAlbumQuery()
      ->leftJoinArtist()
    ->endUse()
    ->leftJoinGenre()
    ->leftJoinInvoiceLine()
    ->withColumn('COALESCE(SUM(InvoiceLine.UnitPrice * InvoiceLine.Quantity), 0)', 'Revenue')
    ->withColumn('COALESCE(SUM(InvoiceLine.Quantity), 0)', 'Sales')
    ->withColumn('Artist.Name', 'ArtistName')
    ->withColumn('Genre.Name', 'GenreName')
    ->groupBy('Album.AlbumId')
    ->select(['Name', 'TrackId', 'ArtistName', 'GenreName'])
    ->orderBy('Revenue', 'DESC')
    ->limit(10) 
    ->find()
    ->toArray();

    return $results;
  }
}


