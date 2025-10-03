"use client";

import { useMemo } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import { Users, Edit, Trash2, Search, Disc3, Music } from "lucide-react";
import type { ArtistWithDetails } from "@/lib/mock-data";
import Loader from "../loader";

interface ArtistCatalogProps {
  artists: ArtistWithDetails[];
  searchTerm: string;
  loading: boolean;
  onSearchTermChange: (e: string) => void;
  onEdit: (artist: ArtistWithDetails) => void;
  onDelete: (artistId: number) => void;
  onViewAlbums: (artist: ArtistWithDetails) => void;
  currentPage: number;
  onPageChange: (page: number) => void;
}

const ARTISTS_PER_PAGE = 8;

export function ArtistCatalog({
  artists,
  searchTerm,
  loading,
  onSearchTermChange,
  onEdit,
  onDelete,
  onViewAlbums,
  currentPage,
  onPageChange,
}: ArtistCatalogProps) {
  
  // Pagination
  const totalPages = Math.ceil(artists.length / ARTISTS_PER_PAGE);
  const paginatedArtists = useMemo(() => {
    const startIndex = (currentPage - 1) * ARTISTS_PER_PAGE;
    return artists.slice(startIndex, startIndex + ARTISTS_PER_PAGE);
  }, [artists, currentPage]);

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
                  placeholder="Search artists..."
                  value={searchTerm}
                  onChange={(e) => onSearchTermChange(e.target.value)}
                  className="pl-10"
                />
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Artist Grid */}
      {loading ? (
        <Loader />
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          {paginatedArtists.map((artist) => (
            <Card
              key={artist.ArtistId}
              className="group hover:shadow-lg transition-all duration-200 hover:scale-[1.02]"
            >
              <CardContent className="p-0">
                {/* Artist Avatar */}
                <div className="aspect-square bg-gradient-to-br from-primary/20 to-accent/20 rounded-t-lg flex items-center justify-center relative overflow-hidden">
                  <Users className="h-20 w-20 text-muted-foreground/50" />
                  <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />

                  {/* Action buttons overlay */}
                  <div className="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <Button
                      size="sm"
                      variant="secondary"
                      onClick={() => onEdit(artist)}
                    >
                      <Edit className="h-3 w-3" />
                    </Button>
                    {artist.AlbumCount && artist.AlbumCount < 1 && <Button
                      size="sm"
                      variant="secondary"
                      onClick={() => onDelete(artist.ArtistId)}
                      className="text-destructive hover:text-destructive"
                    >
                      <Trash2 className="h-3 w-3" />
                    </Button>}
                  </div>
                </div>

                {/* Artist Info */}
                <div className="p-4 space-y-3">
                  <div>
                    <h3
                      className="font-semibold text-lg leading-tight line-clamp-2"
                      title={artist.Name}
                    >
                      {artist.Name}
                    </h3>
                    {artist.TopGenre && (
                      <p
                        className="text-muted-foreground text-sm"
                        title={artist.TopGenre}
                      >
                        {artist.TopGenre}
                      </p>
                    )}
                  </div>

                  {/* Artist Stats */}
                  <div className="grid grid-cols-2 gap-2 text-xs">
                    <div className="flex items-center gap-1">
                      <Disc3 className="h-4 w-4 text-muted-foreground" />
                      <span>{artist.AlbumCount || 0}</span>
                    </div>
                    <div className="flex items-center gap-1">
                      <Music className="h-4 w-4 text-muted-foreground" />
                      <span>{artist.TrackCount || 0}</span>
                    </div>
                  </div>

                  {/* Album Count Badge */}
                  {(artist.AlbumCount || 0) > 0 && (
                    <Badge variant="secondary" className="text-xs">
                      {artist.AlbumCount} album
                      {artist.AlbumCount !== 1 ? "s" : ""}
                    </Badge>
                  )}

                  {/* View Albums Button */}
                  <Button
                    variant="outline"
                    size="sm"
                    className="w-full bg-transparent"
                    onClick={() => onViewAlbums(artist)}
                  >
                    View Albums
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

      {!loading && paginatedArtists.length === 0 && (
        <div className="text-center py-12">
          <Users className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-semibold mb-2">No artists found</h3>
          <p className="text-muted-foreground">
            Try adjusting your search or filter criteria.
          </p>
        </div>
      )}
    </div>
  );
}
