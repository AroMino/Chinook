export interface Track {
  TrackId: number
  Name: string
  AlbumId?: number
  MediaTypeId: number
  GenreId?: number
  Composer?: string
  Milliseconds: number
  Bytes?: number
  UnitPrice: number
}

export interface Album {
  AlbumId: number
  Title: string
  ArtistId: number
  ArtistName?: string
}

export interface Artist {
  ArtistId: number
  Name: string
}

export interface Genre {
  GenreId: number
  Name: string
}

export interface MediaType {
  MediaTypeId: number
  Name: string
}

export interface Playlist {
  PlaylistId: number
  Name: string
}

export interface PlaylistTrack {
  PlaylistId: number
  TrackId: number
}

export interface TrackWithDetails extends Track {
  AlbumTitle?: string
  ArtistName?: string
  GenreName?: string
  MediaTypeName?: string
}

export interface AlbumWithDetails extends Album {
  ArtistName?: string
  TrackCount?: number
  TotalDuration?: number
  TotalRevenue?: number
}

export interface PlaylistWithDetails extends Playlist {
  TrackCount?: number
  TotalDuration?: number
  TotalRevenue?: number
  Tracks?: TrackWithDetails[]
}
