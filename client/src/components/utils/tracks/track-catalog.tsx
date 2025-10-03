"use client";

import { useMemo, useState } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Music, Edit, Trash2, Search, Filter } from "lucide-react";
import { formatDuration } from "@/lib/mock-data";
import type { TrackWithDetails } from "@/types/chinook";
import Loader from "../loader";
import { SelectSkeleton } from "../select-skeleton";

interface TrackCatalogProps {
  tracks: TrackWithDetails[];
  loading: boolean;
  onEdit: (track: TrackWithDetails) => void;
  onDelete: (trackId: number) => void;
}

const TRACKS_PER_PAGE = 8;

export function TrackCatalog({
  tracks,
  loading,
  onEdit,
  onDelete,
}: TrackCatalogProps) {
  const [searchTerm, setSearchTerm] = useState("");
  const [genreFilter, setGenreFilter] = useState("all");
  const [albumFilter, setAlbumFilter] = useState("all");
  const [currentPage, setCurrentPage] = useState(1);

  // Get unique values for filters
  const genres = Array.from(
    new Set(tracks.map((t) => t.GenreName).filter(Boolean))
  );
  const albums = Array.from(
    new Set(tracks.map((t) => t.AlbumTitle).filter(Boolean))
  );

  // Filter tracks
  const filteredTracks = tracks.filter((track) => {
    const matchesSearch =
      track.Name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      track.ArtistName?.toLowerCase().includes(searchTerm.toLowerCase()) ||
      track.AlbumTitle?.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesGenre =
      genreFilter === "all" || track.GenreName === genreFilter;
    const matchesAlbum =
      albumFilter === "all" || track.AlbumTitle === albumFilter;

    return matchesSearch && matchesGenre && matchesAlbum;
  });

  // Pagination
  const totalPages = Math.ceil(filteredTracks.length / TRACKS_PER_PAGE);
  const paginatedTracks = useMemo(() => {
    const startIndex = (currentPage - 1) * TRACKS_PER_PAGE;
    return filteredTracks.slice(startIndex, startIndex + TRACKS_PER_PAGE);
  }, [filteredTracks, currentPage]);

  return (
    <div className="space-y-6">
      {/* Filters */}
      <Card>
        <CardContent className="p-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="flex-1">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <Input
                  placeholder="Search tracks, artists, or albums..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>

            <div className="flex gap-2">
              <Select value={genreFilter} onValueChange={setGenreFilter}>
                <SelectTrigger className="w-40">
                  <Filter className="h-4 w-4 mr-2" />
                  <SelectValue placeholder="Genre" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Genres</SelectItem>
                  {!loading &&
                    genres.map((genre) => (
                      <SelectItem key={genre} value={genre || ""}>
                        {genre}
                      </SelectItem>
                    ))}
                  {loading && <SelectSkeleton/>}
                </SelectContent>
              </Select>

              <Select value={albumFilter} onValueChange={setAlbumFilter}>
                <SelectTrigger className="w-40">
                  <Filter className="h-4 w-4 mr-2" />
                  <SelectValue placeholder="Album" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Albums</SelectItem>
                  {!loading &&
                    albums.map((album) => (
                      <SelectItem key={album} value={album || ""}>
                        {album}
                      </SelectItem>
                    ))}
                  {loading && <SelectSkeleton />}
                </SelectContent>
              </Select>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Track Grid */}
      {loading ? (
        <Loader />
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          {paginatedTracks.map((track) => (
            <Card
              key={track.TrackId}
              className="group hover:shadow-lg transition-shadow"
            >
              <CardContent className="p-4">
                <div className="flex items-start gap-3">
                  {/* Album Art Placeholder */}
                  <div className="w-16 h-16 bg-muted rounded-lg flex items-center justify-center flex-shrink-0">
                    <Music className="h-8 w-8 text-muted-foreground" />
                  </div>

                  <div className="flex-1 min-w-0">
                    <h3
                      className="font-semibold text-sm truncate"
                      title={track.Name}
                    >
                      {track.Name}
                    </h3>
                    <p
                      className="text-sm text-muted-foreground truncate"
                      title={track.ArtistName}
                    >
                      {track.ArtistName || "Unknown Artist"}
                    </p>
                    <p
                      className="text-xs text-muted-foreground truncate"
                      title={track.AlbumTitle}
                    >
                      {track.AlbumTitle || "Unknown Album"}
                    </p>

                    <div className="flex items-center gap-2 mt-2">
                      {track.GenreName && (
                        <Badge variant="secondary" className="text-xs">
                          {track.GenreName}
                        </Badge>
                      )}
                      <span className="text-xs text-muted-foreground">
                        {formatDuration(track.Milliseconds)}
                      </span>
                    </div>

                    <div className="flex items-center justify-between mt-3">
                      <span className="font-semibold text-sm">
                        ${track.UnitPrice}
                      </span>
                      <div className="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <Button
                          size="sm"
                          variant="ghost"
                          onClick={() => onEdit(track)}
                        >
                          <Edit className="h-3 w-3" />
                        </Button>
                        <Button
                          size="sm"
                          variant="ghost"
                          onClick={() => onDelete(track.TrackId)}
                          className="text-destructive hover:text-destructive"
                        >
                          <Trash2 className="h-3 w-3" />
                        </Button>
                      </div>
                    </div>
                  </div>
                </div>

                {track.Composer && (
                  <div className="mt-3 pt-3 border-t border-border">
                    <p className="text-xs text-muted-foreground">
                      <span className="font-medium">Composer:</span>{" "}
                      {track.Composer}
                    </p>
                  </div>
                )}
              </CardContent>
            </Card>
          ))}
        </div>
      )}

      {/* Pagination */}
      {totalPages > 1 && (
        <div className="flex justify-center gap-2">
          <Button
            variant="outline"
            onClick={() => setCurrentPage(currentPage - 1)}
            disabled={currentPage === 1}
          >
            Previous
          </Button>

          {Array.from({ length: totalPages }, (_, i) => i + 1)
            .filter((page) => {
              // Affiche toujours la première et dernière page
              if (page === 1 || page === totalPages) return true;
              // Affiche quelques pages autour de la page courante
              return Math.abs(page - currentPage) <= 2;
            })
            .map((page, index, arr) => {
              // Ajouter des "..." si saut de pages
              const prev = arr[index - 1];
              const showDots = prev && page - prev > 1;
              return (
                <div key={page}>
                  {showDots && <span className="px-2">...</span>}
                  <Button
                    variant={page === currentPage ? "default" : "outline"}
                    onClick={() => setCurrentPage(page)}
                    className="w-10"
                  >
                    {page}
                  </Button>
                </div>
              );
            })}

          <Button
            variant="outline"
            onClick={() => setCurrentPage(currentPage + 1)}
            disabled={currentPage === totalPages}
          >
            Next
          </Button>
        </div>
      )}

      {!loading && filteredTracks.length === 0 && (
        <div className="text-center py-12">
          <Music className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-semibold mb-2">No tracks found</h3>
          <p className="text-muted-foreground">
            Try adjusting your search or filter criteria.
          </p>
        </div>
      )}
    </div>
  );
}
