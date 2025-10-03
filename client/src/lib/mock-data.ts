import type {
  Track,
  Album,
  Artist,
  Genre,
  MediaType,
  TrackWithDetails,
  AlbumWithDetails,
  Playlist,
  PlaylistTrack,
} from "@/types/chinook"

// Mock data following Chinook schema
export const mockArtists: Artist[] = [
  { ArtistId: 1, Name: "AC/DC" },
  { ArtistId: 2, Name: "Accept" },
  { ArtistId: 3, Name: "Aerosmith" },
  { ArtistId: 4, Name: "Alanis Morissette" },
  { ArtistId: 5, Name: "Alice In Chains" },
  { ArtistId: 6, Name: "Antônio Carlos Jobim" },
  { ArtistId: 7, Name: "Apocalyptica" },
  { ArtistId: 8, Name: "Audioslave" },
  { ArtistId: 9, Name: "BackBeat" },
  { ArtistId: 10, Name: "The Beatles" },
]

export const mockAlbums: Album[] = [
  { AlbumId: 1, Title: "For Those About To Rock We Salute You", ArtistId: 1 },
  { AlbumId: 2, Title: "Balls to the Wall", ArtistId: 2 },
  { AlbumId: 3, Title: "Restless and Wild", ArtistId: 2 },
  { AlbumId: 4, Title: "Let There Be Rock", ArtistId: 1 },
  { AlbumId: 5, Title: "Big Ones", ArtistId: 3 },
  { AlbumId: 6, Title: "Jagged Little Pill", ArtistId: 4 },
  { AlbumId: 7, Title: "Facelift", ArtistId: 5 },
  { AlbumId: 8, Title: "Warner 25 Anos", ArtistId: 6 },
  { AlbumId: 9, Title: "Plays Metallica By Four Cellos", ArtistId: 7 },
  { AlbumId: 10, Title: "Audioslave", ArtistId: 8 },
]

export const mockGenres: Genre[] = [
  { GenreId: 1, Name: "Rock" },
  { GenreId: 2, Name: "Jazz" },
  { GenreId: 3, Name: "Metal" },
  { GenreId: 4, Name: "Alternative & Punk" },
  { GenreId: 5, Name: "Rock And Roll" },
  { GenreId: 6, Name: "Blues" },
  { GenreId: 7, Name: "Latin" },
  { GenreId: 8, Name: "Reggae" },
  { GenreId: 9, Name: "Pop" },
  { GenreId: 10, Name: "Soundtrack" },
]

export const mockMediaTypes: MediaType[] = [
  { MediaTypeId: 1, Name: "MPEG audio file" },
  { MediaTypeId: 2, Name: "Protected AAC audio file" },
  { MediaTypeId: 3, Name: "Protected MPEG-4 video file" },
  { MediaTypeId: 4, Name: "Purchased AAC audio file" },
  { MediaTypeId: 5, Name: "AAC audio file" },
]

export const mockTracks: Track[] = [
  {
    TrackId: 1,
    Name: "For Those About To Rock (We Salute You)",
    AlbumId: 1,
    MediaTypeId: 1,
    GenreId: 1,
    Composer: "Angus Young, Malcolm Young, Brian Johnson",
    Milliseconds: 343719,
    Bytes: 11170334,
    UnitPrice: 0.99,
  },
  {
    TrackId: 2,
    Name: "Balls to the Wall",
    AlbumId: 2,
    MediaTypeId: 2,
    GenreId: 1,
    Composer: undefined,
    Milliseconds: 342562,
    Bytes: 5510424,
    UnitPrice: 0.99,
  },
  {
    TrackId: 3,
    Name: "Fast As a Shark",
    AlbumId: 3,
    MediaTypeId: 2,
    GenreId: 1,
    Composer: "F. Baltes, S. Kaufman, U. Dirkscneider & W. Hoffman",
    Milliseconds: 230619,
    Bytes: 3990994,
    UnitPrice: 0.99,
  },
  {
    TrackId: 4,
    Name: "Restless and Wild",
    AlbumId: 3,
    MediaTypeId: 2,
    GenreId: 1,
    Composer: "F. Baltes, R.A. Smith-Diesel, S. Kaufman, U. Dirkscneider & W. Hoffman",
    Milliseconds: 252051,
    Bytes: 4331779,
    UnitPrice: 0.99,
  },
  {
    TrackId: 5,
    Name: "Princess of the Dawn",
    AlbumId: 3,
    MediaTypeId: 2,
    GenreId: 1,
    Composer: "Deaffy & R.A. Smith-Diesel",
    Milliseconds: 375418,
    Bytes: 6290521,
    UnitPrice: 0.99,
  },
]

// Extended mock data
export const extendedMockAlbums: Album[] = [
  { AlbumId: 1, Title: "For Those About To Rock We Salute You", ArtistId: 1 },
  { AlbumId: 2, Title: "Balls to the Wall", ArtistId: 2 },
  { AlbumId: 3, Title: "Restless and Wild", ArtistId: 2 },
  { AlbumId: 4, Title: "Let There Be Rock", ArtistId: 1 },
  { AlbumId: 5, Title: "Big Ones", ArtistId: 3 },
  { AlbumId: 6, Title: "Jagged Little Pill", ArtistId: 4 },
  { AlbumId: 7, Title: "Facelift", ArtistId: 5 },
  { AlbumId: 8, Title: "Warner 25 Anos", ArtistId: 6 },
  { AlbumId: 9, Title: "Plays Metallica By Four Cellos", ArtistId: 7 },
  { AlbumId: 10, Title: "Audioslave", ArtistId: 8 },
  { AlbumId: 11, Title: "Abbey Road", ArtistId: 10 },
  { AlbumId: 12, Title: "The Dark Side of the Moon", ArtistId: 10 },
  { AlbumId: 13, Title: "Thriller", ArtistId: 10 },
  { AlbumId: 14, Title: "Back in Black", ArtistId: 1 },
  { AlbumId: 15, Title: "Rumours", ArtistId: 10 },
]

export const extendedMockTracks: Track[] = [
  ...mockTracks,
  {
    TrackId: 6,
    Name: "Highway to Hell",
    AlbumId: 14,
    MediaTypeId: 1,
    GenreId: 1,
    Composer: "Angus Young, Malcolm Young, Bon Scott",
    Milliseconds: 208000,
    UnitPrice: 0.99,
  },
  {
    TrackId: 7,
    Name: "Back in Black",
    AlbumId: 14,
    MediaTypeId: 1,
    GenreId: 1,
    Composer: "Angus Young, Malcolm Young, Brian Johnson",
    Milliseconds: 255000,
    UnitPrice: 0.99,
  },
  {
    TrackId: 8,
    Name: "Come As You Are",
    AlbumId: 11,
    MediaTypeId: 1,
    GenreId: 4,
    Composer: "Kurt Cobain",
    Milliseconds: 219000,
    UnitPrice: 0.99,
  },
]

// Extended mock data for playlists
export const mockPlaylists: Playlist[] = [
  { PlaylistId: 1, Name: "Music" },
  { PlaylistId: 2, Name: "Movies" },
  { PlaylistId: 3, Name: "TV Shows" },
  { PlaylistId: 4, Name: "Audiobooks" },
  { PlaylistId: 5, Name: "90's Music" },
  { PlaylistId: 6, Name: "Audiobooks" },
  { PlaylistId: 7, Name: "Movies" },
  { PlaylistId: 8, Name: "Music" },
  { PlaylistId: 9, Name: "Music Videos" },
  { PlaylistId: 10, Name: "TV Shows" },
  { PlaylistId: 11, Name: "Brazilian Music" },
  { PlaylistId: 12, Name: "Classical" },
  { PlaylistId: 13, Name: "Classical 101 - Deep Cuts" },
  { PlaylistId: 14, Name: "Classical 101 - Next Steps" },
  { PlaylistId: 15, Name: "Classical 101 - The Basics" },
  { PlaylistId: 16, Name: "Grunge" },
  { PlaylistId: 17, Name: "Heavy Metal Classic" },
  { PlaylistId: 18, Name: "On-The-Go 1" },
]

export const mockPlaylistTracks: PlaylistTrack[] = [
  { PlaylistId: 1, TrackId: 1 },
  { PlaylistId: 1, TrackId: 2 },
  { PlaylistId: 1, TrackId: 3 },
  { PlaylistId: 5, TrackId: 1 },
  { PlaylistId: 5, TrackId: 4 },
  { PlaylistId: 5, TrackId: 5 },
  { PlaylistId: 16, TrackId: 2 },
  { PlaylistId: 16, TrackId: 3 },
  { PlaylistId: 17, TrackId: 1 },
  { PlaylistId: 17, TrackId: 4 },
  { PlaylistId: 18, TrackId: 1 },
  { PlaylistId: 18, TrackId: 2 },
  { PlaylistId: 18, TrackId: 3 },
  { PlaylistId: 18, TrackId: 4 },
  { PlaylistId: 18, TrackId: 5 },
]

// Extended mock data for sales analytics
export const mockSalesData = {
  topTracks: [
    { name: "Bohemian Rhapsody", sales: 1250, revenue: 1237.5, artist: "Queen", genre: "Rock" },
    { name: "Hotel California", sales: 1100, revenue: 1089.0, artist: "Eagles", genre: "Rock" },
    { name: "Stairway to Heaven", sales: 980, revenue: 970.2, artist: "Led Zeppelin", genre: "Rock" },
    { name: "Sweet Child O Mine", sales: 875, revenue: 866.25, artist: "Guns N' Roses", genre: "Rock" },
    { name: "Imagine", sales: 820, revenue: 811.8, artist: "John Lennon", genre: "Rock" },
    { name: "Billie Jean", sales: 750, revenue: 742.5, artist: "Michael Jackson", genre: "Pop" },
    { name: "Like a Rolling Stone", sales: 690, revenue: 683.1, artist: "Bob Dylan", genre: "Folk Rock" },
    { name: "Smells Like Teen Spirit", sales: 650, revenue: 643.5, artist: "Nirvana", genre: "Grunge" },
  ],

  topAlbums: [
    { name: "The Dark Side of the Moon", revenue: 15420.5, artist: "Pink Floyd", year: 1973, sales: 15576 },
    { name: "Abbey Road", revenue: 12890.25, artist: "The Beatles", year: 1969, sales: 13020 },
    { name: "Thriller", revenue: 11567.8, artist: "Michael Jackson", year: 1982, sales: 11685 },
    { name: "Back in Black", revenue: 10234.6, artist: "AC/DC", year: 1980, sales: 10338 },
    { name: "Rumours", revenue: 9876.4, artist: "Fleetwood Mac", year: 1977, sales: 9975 },
    { name: "The Wall", revenue: 8543.2, artist: "Pink Floyd", year: 1979, sales: 8629 },
    { name: "Led Zeppelin IV", revenue: 7890.1, artist: "Led Zeppelin", year: 1971, sales: 7970 },
  ],

  topCustomers: [
    { name: "François Tremblay", email: "ftremblay@gmail.com", totalSpent: 234.56, country: "Canada" },
    { name: "Mark Philips", email: "mphilips12@yahoo.com", totalSpent: 198.34, country: "USA" },
    { name: "Jennifer Peterson", email: "jenniferp@rogers.ca", totalSpent: 187.23, country: "Canada" },
    { name: "Frank Harris", email: "fharris@google.com", totalSpent: 176.45, country: "USA" },
    { name: "Jack Smith", email: "jacksmith@microsoft.com", totalSpent: 165.78, country: "USA" },
  ],

  monthlyRevenue: [
    // 2023
    { month: "Jan", revenue: 10250, sales: 1025, year: 2023 },
    { month: "Feb", revenue: 11000, sales: 1100, year: 2023 },
    { month: "Mar", revenue: 9800, sales: 980, year: 2023 },
    { month: "Apr", revenue: 12500, sales: 1250, year: 2023 },
    { month: "May", revenue: 13200, sales: 1320, year: 2023 },
    { month: "Jun", revenue: 11800, sales: 1180, year: 2023 },
    { month: "Jul", revenue: 14100, sales: 1410, year: 2023 },
    { month: "Aug", revenue: 12900, sales: 1290, year: 2023 },
    { month: "Sep", revenue: 13600, sales: 1360, year: 2023 },
    { month: "Oct", revenue: 15200, sales: 1520, year: 2023 },
    { month: "Nov", revenue: 14800, sales: 1480, year: 2023 },
    { month: "Dec", revenue: 16900, sales: 1690, year: 2023 },

    // 2024
    { month: "Jan", revenue: 11450, sales: 1145, year: 2024 },
    { month: "Feb", revenue: 12200, sales: 1220, year: 2024 },
    { month: "Mar", revenue: 10800, sales: 1080, year: 2024 },
    { month: "Apr", revenue: 13500, sales: 1350, year: 2024 },
    { month: "May", revenue: 14200, sales: 1420, year: 2024 },
    { month: "Jun", revenue: 12800, sales: 1280, year: 2024 },
    { month: "Jul", revenue: 15100, sales: 1510, year: 2024 },
    { month: "Aug", revenue: 13900, sales: 1390, year: 2024 },
    { month: "Sep", revenue: 14600, sales: 1460, year: 2024 },
    { month: "Oct", revenue: 16200, sales: 1620, year: 2024 },
    { month: "Nov", revenue: 15800, sales: 1580, year: 2024 },
    { month: "Dec", revenue: 17900, sales: 1790, year: 2024 },

    // 2025
    { month: "Jan", revenue: 12450, sales: 1245, year: 2025 },
    { month: "Feb", revenue: 13200, sales: 1320, year: 2025 },
    { month: "Mar", revenue: 11800, sales: 1180, year: 2025 },
    { month: "Apr", revenue: 14500, sales: 1450, year: 2025 },
    { month: "May", revenue: 15200, sales: 1520, year: 2025 },
    { month: "Jun", revenue: 13800, sales: 1380, year: 2025 },
    { month: "Jul", revenue: 16100, sales: 1610, year: 2025 },
    { month: "Aug", revenue: 14900, sales: 1490, year: 2025 },
    { month: "Sep", revenue: 15600, sales: 1560, year: 2025 },
    { month: "Oct", revenue: 17200, sales: 1720, year: 2025 },
    { month: "Nov", revenue: 16800, sales: 1680, year: 2025 },
    { month: "Dec", revenue: 18900, sales: 1890, year: 2025 },
  ],

  genrePerformance: [
    { name: "Rock", revenue: 45230.5, sales: 4567, percentage: 35 },
    { name: "Pop", revenue: 32145.8, sales: 3245, percentage: 25 },
    { name: "Jazz", revenue: 19287.3, sales: 1945, percentage: 15 },
    { name: "Classical", revenue: 15429.6, sales: 1556, percentage: 12 },
    { name: "Alternative", revenue: 10876.2, sales: 1098, percentage: 8 },
    { name: "Other", revenue: 6430.8, sales: 649, percentage: 5 },
  ],
}

// Helper function to get tracks with details
export function getTracksWithDetails(): TrackWithDetails[] {
  return mockTracks.map((track) => {
    const album = mockAlbums.find((a) => a.AlbumId === track.AlbumId)
    const artist = album ? mockArtists.find((ar) => ar.ArtistId === album.ArtistId) : undefined
    const genre = mockGenres.find((g) => g.GenreId === track.GenreId)
    const mediaType = mockMediaTypes.find((mt) => mt.MediaTypeId === track.MediaTypeId)

    return {
      ...track,
      AlbumTitle: album?.Title,
      ArtistName: artist?.Name,
      GenreName: genre?.Name,
      MediaTypeName: mediaType?.Name,
    }
  })
}

// Helper function to get albums with details
export function getAlbumsWithDetails(): AlbumWithDetails[] {
  return extendedMockAlbums.map((album) => {
    const artist = mockArtists.find((a) => a.ArtistId === album.ArtistId)
    const albumTracks = extendedMockTracks.filter((t) => t.AlbumId === album.AlbumId)
    const totalDuration = albumTracks.reduce((sum, track) => sum + track.Milliseconds, 0)
    const totalRevenue = albumTracks.reduce((sum, track) => sum + track.UnitPrice, 0)

    return {
      ...album,
      ArtistName: artist?.Name || "Unknown Artist",
      TrackCount: albumTracks.length,
      TotalDuration: totalDuration,
      TotalRevenue: totalRevenue,
    }
  })
}

// Extended types for playlists with details
interface PlaylistWithDetailsExtended extends Playlist {
  TrackCount?: number
  TotalDuration?: number
  TotalRevenue?: number
  Tracks?: TrackWithDetails[]
}

// Helper function to get playlists with details
export function getPlaylistsWithDetails(): PlaylistWithDetailsExtended[] {
  return mockPlaylists.map((playlist) => {
    const playlistTrackIds = mockPlaylistTracks
      .filter((pt) => pt.PlaylistId === playlist.PlaylistId)
      .map((pt) => pt.TrackId)

    const playlistTracks = extendedMockTracks.filter((track) => playlistTrackIds.includes(track.TrackId))

    const tracksWithDetails = playlistTracks.map((track) => {
      const album = mockAlbums.find((a) => a.AlbumId === track.AlbumId)
      const artist = album ? mockArtists.find((ar) => ar.ArtistId === album.ArtistId) : undefined
      const genre = mockGenres.find((g) => g.GenreId === track.GenreId)
      const mediaType = mockMediaTypes.find((mt) => mt.MediaTypeId === track.MediaTypeId)

      return {
        ...track,
        AlbumTitle: album?.Title,
        ArtistName: artist?.Name,
        GenreName: genre?.Name,
        MediaTypeName: mediaType?.Name,
      }
    })

    const totalDuration = playlistTracks.reduce((sum, track) => sum + track.Milliseconds, 0)
    const totalRevenue = playlistTracks.reduce((sum, track) => sum + track.UnitPrice, 0)

    return {
      ...playlist,
      TrackCount: playlistTracks.length,
      TotalDuration: totalDuration,
      TotalRevenue: totalRevenue,
      Tracks: tracksWithDetails,
    }
  })
}

// Extended types for artists with details
export interface ArtistWithDetails extends Artist {
  AlbumCount?: number
  TrackCount?: number
  TotalRevenue?: number
  TopGenre?: string
}

// Helper function to get artists with details
export function getArtistsWithDetails(): ArtistWithDetails[] {
  return mockArtists.map((artist) => {
    const artistAlbums = extendedMockAlbums.filter((a) => a.ArtistId === artist.ArtistId)
    const artistTracks = extendedMockTracks.filter((t) => {
      const album = extendedMockAlbums.find((a) => a.AlbumId === t.AlbumId)
      return album && album.ArtistId === artist.ArtistId
    })

    const totalRevenue = artistTracks.reduce((sum, track) => sum + track.UnitPrice, 0)

    // Find most common genre for this artist
    const genreCounts = artistTracks.reduce(
      (acc, track) => {
        if (track.GenreId) {
          acc[track.GenreId] = (acc[track.GenreId] || 0) + 1
        }
        return acc
      },
      {} as Record<number, number>,
    )

    const genreEntries = Object.entries(genreCounts)
    const topGenreId =
      genreEntries.length > 0
        ? genreEntries.reduce((a, b) => (genreCounts[Number(a[0])] > genreCounts[Number(b[0])] ? a : b))?.[0]
        : undefined

    const topGenre = topGenreId ? mockGenres.find((g) => g.GenreId === Number(topGenreId))?.Name : undefined

    return {
      ...artist,
      AlbumCount: artistAlbums.length,
      TrackCount: artistTracks.length,
      TotalRevenue: totalRevenue,
      TopGenre: topGenre,
    }
  })
}

// Helper functions
export function formatDuration(milliseconds: number): string {
  const minutes = Math.floor(milliseconds / 60000)
  const seconds = Math.floor((milliseconds % 60000) / 1000)
  return `${minutes}:${seconds.toString().padStart(2, "0")}`
}

export function formatFileSize(bytes?: number): string {
  if (!bytes) return "N/A"
  const mb = bytes / (1024 * 1024)
  return `${mb.toFixed(1)} MB`
}
