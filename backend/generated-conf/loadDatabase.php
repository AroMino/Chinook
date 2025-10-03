<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMapFromDumps(array (
  'default' => 
  array (
    'tablesByName' => 
    array (
      'album' => '\\Chinook\\Models\\Map\\AlbumTableMap',
      'artist' => '\\Chinook\\Models\\Map\\ArtistTableMap',
      'customer' => '\\Chinook\\Models\\Map\\CustomerTableMap',
      'employee' => '\\Chinook\\Models\\Map\\EmployeeTableMap',
      'genre' => '\\Chinook\\Models\\Map\\GenreTableMap',
      'invoice' => '\\Chinook\\Models\\Map\\InvoiceTableMap',
      'invoice_line' => '\\Chinook\\Models\\Map\\InvoiceLineTableMap',
      'media_type' => '\\Chinook\\Models\\Map\\MediaTypeTableMap',
      'playlist' => '\\Chinook\\Models\\Map\\PlaylistTableMap',
      'playlist_track' => '\\Chinook\\Models\\Map\\PlaylistTrackTableMap',
      'track' => '\\Chinook\\Models\\Map\\TrackTableMap',
    ),
    'tablesByPhpName' => 
    array (
      '\\Album' => '\\Chinook\\Models\\Map\\AlbumTableMap',
      '\\Artist' => '\\Chinook\\Models\\Map\\ArtistTableMap',
      '\\Customer' => '\\Chinook\\Models\\Map\\CustomerTableMap',
      '\\Employee' => '\\Chinook\\Models\\Map\\EmployeeTableMap',
      '\\Genre' => '\\Chinook\\Models\\Map\\GenreTableMap',
      '\\Invoice' => '\\Chinook\\Models\\Map\\InvoiceTableMap',
      '\\InvoiceLine' => '\\Chinook\\Models\\Map\\InvoiceLineTableMap',
      '\\MediaType' => '\\Chinook\\Models\\Map\\MediaTypeTableMap',
      '\\Playlist' => '\\Chinook\\Models\\Map\\PlaylistTableMap',
      '\\PlaylistTrack' => '\\Chinook\\Models\\Map\\PlaylistTrackTableMap',
      '\\Track' => '\\Chinook\\Models\\Map\\TrackTableMap',
    ),
  ),
));
