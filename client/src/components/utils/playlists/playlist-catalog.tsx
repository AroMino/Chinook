"use client"

import { useMemo } from "react"
import { Card, CardContent } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Input } from "@/components/ui/input"
import { ListMusic, Edit, Trash2, Search, Clock, DollarSign, Plus } from "lucide-react"
import { formatDuration } from "@/lib/mock-data"
import type { PlaylistWithDetails } from "@/types/chinook"

interface PlaylistCatalogProps {
  playlists: PlaylistWithDetails[]
  searchTerm: string
  onSearchTermChange: (e: string) => void,
  onEdit: (playlist: PlaylistWithDetails) => void
  onDelete: (playlistId: number) => void
  onViewTracks: (playlist: PlaylistWithDetails) => void
  onManageTracks: (playlist: PlaylistWithDetails) => void
  currentPage: number
  // totalPages: number
  onPageChange: (page: number) => void
}

const PLAYLISTS_PER_PAGE = 8

export function PlaylistCatalog({
  playlists,
  currentPage,
  searchTerm,
  onSearchTermChange,
  onEdit,
  onDelete,
  onViewTracks,
  onManageTracks,
  // totalPages,
  onPageChange,
}: PlaylistCatalogProps) {

  

  

  // Pagination
    const totalPages = Math.ceil(playlists.length / PLAYLISTS_PER_PAGE)
    const paginatedPlaylists = useMemo(() => {
      const startIndex = (currentPage - 1) * PLAYLISTS_PER_PAGE
      return playlists.slice(startIndex, startIndex + PLAYLISTS_PER_PAGE)
    }, [playlists, currentPage])

  return (
    <div className="space-y-6">
      {/* Search */}
      <Card>
        <CardContent className="p-4">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input
              placeholder="Search playlists..."
              value={searchTerm}
              onChange={(e) => onSearchTermChange(e.target.value)}
              className="pl-10"
            />
          </div>
        </CardContent>
      </Card>

      {/* Playlist Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        {paginatedPlaylists.map((playlist) => (
          <Card
            key={playlist.PlaylistId}
            className="group hover:shadow-lg transition-all duration-200 hover:scale-[1.02]"
          >
            <CardContent className="p-0">
              {/* Playlist Cover */}
              <div className="aspect-square bg-gradient-to-br from-accent/30 to-primary/20 rounded-t-lg flex items-center justify-center relative overflow-hidden">
                <ListMusic className="h-20 w-20 text-muted-foreground/50" />
                <div className="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors" />

                {/* Action buttons overlay */}
                <div className="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                  <Button size="sm" variant="secondary" onClick={() => onEdit(playlist)}>
                    <Edit className="h-3 w-3" />
                  </Button>
                  <Button
                    size="sm"
                    variant="secondary"
                    onClick={() => onDelete(playlist.PlaylistId)}
                    className="text-destructive hover:text-destructive"
                  >
                    <Trash2 className="h-3 w-3" />
                  </Button>
                </div>

                {/* Track count overlay */}
                {(playlist.TrackCount || 0) > 0 && (
                  <div className="absolute bottom-2 left-2">
                    <Badge variant="secondary" className="text-xs">
                      {playlist.TrackCount} track{playlist.TrackCount !== 1 ? "s" : ""}
                    </Badge>
                  </div>
                )}
              </div>

              {/* Playlist Info */}
              <div className="p-4 space-y-3">
                <div>
                  <h3 className="font-semibold text-lg leading-tight line-clamp-2" title={playlist.Name}>
                    {playlist.Name}
                  </h3>
                  <p className="text-muted-foreground text-sm">
                    {playlist.TrackCount || 0} track{playlist.TrackCount !== 1 ? "s" : ""}
                  </p>
                </div>

                {/* Playlist Stats */}
                {(playlist.TrackCount || 0) > 0 && (
                  <div className="grid grid-cols-2 gap-2 text-xs">
                    <div className="flex items-center gap-1">
                      <Clock className="h-3 w-3 text-muted-foreground" />
                      <span>{playlist.TotalDuration ? formatDuration(playlist.TotalDuration) : "0:00"}</span>
                    </div>
                    <div className="flex items-center gap-1">
                      <DollarSign className="h-3 w-3 text-muted-foreground" />
                      <span>${(playlist.TotalRevenue || 0).toFixed(2)}</span>
                    </div>
                  </div>
                )}

                {/* Action Buttons */}
                <div className="flex gap-2">
                  {(playlist.TrackCount || 0) > 0 ? (
                    <>
                      <Button
                        variant="outline"
                        size="sm"
                        className="flex-1 bg-transparent"
                        onClick={() => onViewTracks(playlist)}
                      >
                        View Tracks
                      </Button>
                      <Button variant="outline" size="sm" onClick={() => onManageTracks(playlist)}>
                        <Plus className="h-3 w-3" />
                      </Button>
                    </>
                  ) : (
                    <Button
                      variant="outline"
                      size="sm"
                      className="w-full bg-transparent"
                      onClick={() => onManageTracks(playlist)}
                    >
                      <Plus className="h-4 w-4 mr-2" />
                      Add Tracks
                    </Button>
                  )}
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      {/* Pagination */}
      {totalPages > 1 && (
        <div className="flex justify-center gap-2">
          <Button variant="outline" onClick={() => onPageChange(currentPage - 1)} disabled={currentPage === 1}>
            Previous
          </Button>

          {Array.from({ length: totalPages }, (_, i) => i + 1).map((page) => (
            <Button
              key={page}
              variant={page === currentPage ? "default" : "outline"}
              onClick={() => onPageChange(page)}
              className="w-10"
            >
              {page}
            </Button>
          ))}

          <Button variant="outline" onClick={() => onPageChange(currentPage + 1)} disabled={currentPage === totalPages}>
            Next
          </Button>
        </div>
      )}

      {playlists.length === 0 && (
        <div className="text-center py-12">
          <ListMusic className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
          <h3 className="text-lg font-semibold mb-2">No playlists found</h3>
          <p className="text-muted-foreground">Try adjusting your search criteria.</p>
        </div>
      )}
    </div>
  )
}
