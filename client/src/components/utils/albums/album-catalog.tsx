"use client";

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
import {
  Disc3,
  Edit,
  Trash2,
  Search,
  Filter,
  Music,
  Clock,
  DollarSign,
} from "lucide-react";
import { formatDuration } from "@/lib/mock-data";
import type { AlbumWithDetails, Artist } from "@/types/chinook";
import { SelectSkeleton } from "../select-skeleton";
import Loader from "../loader";

interface AlbumCatalogProps {
  loading: boolean;
  albums: AlbumWithDetails[];
  artists: Artist[];
  currentPage: number;
  totalPages: number;
  searchTerm: string;
  artistFilter: string;
  onEdit: (album: AlbumWithDetails) => void;
  onDelete: (albumId: number) => void;
  onViewTracks: (album: AlbumWithDetails) => void;
  onPageChange: (page: number) => void;
  onSearchTermChange: (e: string) => void;
  onArtistFilterChange: (e: string) => void;
}

export function AlbumCatalog({
  loading,
  albums,
  artists,
  currentPage,
  totalPages,
  searchTerm,
  artistFilter,
  onEdit,
  onDelete,
  onViewTracks,
  onPageChange,
  onSearchTermChange,
  onArtistFilterChange,
}: AlbumCatalogProps) {
  return (
    <div className="space-y-6">
      {/* Filters */}
      <Card>
        <CardContent className="p-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="flex-1">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                <Input // In real app, would fetch from artists
                  placeholder="Search albums or artists..."
                  value={searchTerm}
                  onChange={(e) => onSearchTermChange(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>

            <div className="flex gap-2">
              <Select value={artistFilter} onValueChange={onArtistFilterChange}>
                <SelectTrigger className="w-40">
                  <Filter className="h-4 w-4 mr-2" />
                  <SelectValue placeholder="Artist" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Artists</SelectItem>
                  {!loading &&
                    artists.map((artist) => (
                      <SelectItem
                        key={artist.ArtistId}
                        value={artist.ArtistId.toString()}
                      >
                        {artist.Name}
                      </SelectItem>
                    ))}
                  {loading && <SelectSkeleton />}
                </SelectContent>
              </Select>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Album Grid */}
      {loading ? (
        <Loader />
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {albums.map((album) => (
            <Card
              key={album.AlbumId}
              className="group hover:shadow-lg transition-all duration-200 hover:scale-[1.02]"
            >
              <CardContent className="p-0">
                {/* Album Cover */}
                <div className="aspect-square bg-gradient-to-br from-primary/20 to-accent/20 rounded-t-lg flex items-center justify-center relative overflow-hidden">
                  <Disc3 className="h-20 w-20 text-muted-foreground/50" />
                  <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />

                  {/* Action buttons overlay */}
                  <div className="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <Button
                      size="sm"
                      variant="secondary"
                      onClick={() => onEdit(album)}
                    >
                      <Edit className="h-3 w-3" />
                    </Button>
                    {album.TrackCount && album.TrackCount < 1 && <Button
                      size="sm"
                      variant="secondary"
                      onClick={() => onDelete(album.AlbumId)}
                      className="text-destructive hover:text-destructive"
                    >
                      <Trash2 className="h-3 w-3" />
                    </Button>}
                  </div>
                </div>

                {/* Album Info */}
                <div className="p-4 space-y-3">
                  <div>
                    <h3
                      className="font-semibold text-lg leading-tight line-clamp-2"
                      title={album.Title}
                    >
                      {album.Title}
                    </h3>
                    <p
                      className="text-muted-foreground text-sm"
                      title={album.ArtistName}
                    >
                      {album.ArtistName}
                    </p>
                  </div>

                  {/* Album Stats */}
                  <div className="grid grid-cols-3 gap-2 text-xs">
                    <div className="flex items-center gap-1">
                      <Music className="h-3 w-3 text-muted-foreground" />
                      <span>{album.TrackCount || 0}</span>
                    </div>
                    <div className="flex items-center gap-1">
                      <Clock className="h-3 w-3 text-muted-foreground" />
                      <span>
                        {album.TotalDuration
                          ? formatDuration(album.TotalDuration)
                          : "0:00"}
                      </span>
                    </div>
                    <div className="flex items-center gap-1">
                      <DollarSign className="h-3 w-3 text-muted-foreground" />
                      <span>${(album.TotalRevenue || 0).toFixed(2)}</span>
                    </div>
                  </div>

                  {/* Track Count Badge */}
                  {(album.TrackCount || 0) > 0 && (
                    <Badge variant="secondary" className="text-xs">
                      {album.TrackCount} track
                      {album.TrackCount !== 1 ? "s" : ""}
                    </Badge>
                  )}

                  {/* View Tracks Button */}
                  <Button
                    variant="outline"
                    size="sm"
                    className="w-full bg-transparent"
                    onClick={() => onViewTracks(album)}
                  >
                    View Tracks
                  </Button>
                </div>
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
            onClick={() => onPageChange(currentPage - 1)}
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
                    onClick={() => onPageChange(page)}
                    className="w-10"
                  >
                    {page}
                  </Button>
                </div>
              );
            })}

          <Button
            variant="outline"
            onClick={() => onPageChange(currentPage + 1)}
            disabled={currentPage === totalPages}
          >
            Next
          </Button>
        </div>
      )}

      {!loading && albums.length === 0 && (
        <div className="text-center py-12">
          <Disc3 className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-semibold mb-2">No albums found</h3>
          <p className="text-muted-foreground">
            Try adjusting your search or filter criteria.
          </p>
        </div>
      )}
    </div>
  );
}
