"use client"

import { useState } from "react"
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Card, CardContent } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Checkbox } from "@/components/ui/checkbox"
import { Music, Search, Plus, Minus } from "lucide-react"
import { getTracksWithDetails, formatDuration } from "@/lib/mock-data"
import type { PlaylistWithDetails, TrackWithDetails } from "@/types/chinook"

interface ManageTracksModalProps {
  playlist: PlaylistWithDetails | null
  isOpen: boolean
  onClose: () => void
  onAddTrack: (playlistId: number, trackId: number) => void
  onRemoveTrack: (playlistId: number, trackId: number) => void
}

export function ManageTracksModal({ playlist, isOpen, onClose, onAddTrack, onRemoveTrack }: ManageTracksModalProps) {
  const [searchTerm, setSearchTerm] = useState("")
  const allTracks = getTracksWithDetails()

  if (!playlist) return null

  const playlistTrackIds = (playlist.Tracks || []).map((t) => t.TrackId)

  // Filter tracks based on search
  const filteredTracks = allTracks.filter(
    (track) =>
      track.Name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      track.ArtistName?.toLowerCase().includes(searchTerm.toLowerCase()) ||
      track.AlbumTitle?.toLowerCase().includes(searchTerm.toLowerCase()),
  )

  const handleTrackToggle = (track: TrackWithDetails, isInPlaylist: boolean) => {
    if (isInPlaylist) {
      onRemoveTrack(playlist.PlaylistId, track.TrackId)
    } else {
      onAddTrack(playlist.PlaylistId, track.TrackId)
    }
  }

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="max-w-3xl max-h-[80vh] overflow-y-auto">
        <DialogHeader>
          <DialogTitle className="flex items-center gap-2">
            <Music className="h-5 w-5" />
            Manage Tracks - {playlist.Name}
          </DialogTitle>
          <DialogDescription>Add or remove tracks from this playlist</DialogDescription>
        </DialogHeader>

        {/* Search */}
        <div className="relative">
          <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
          <Input
            placeholder="Search tracks..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
            className="pl-10"
          />
        </div>

        {/* Track List */}
        <div className="space-y-2 max-h-96 overflow-y-auto">
          {filteredTracks.map((track) => {
            const isInPlaylist = playlistTrackIds.includes(track.TrackId)

            return (
              <Card key={track.TrackId} className={isInPlaylist ? "ring-2 ring-primary/20" : ""}>
                <CardContent className="p-3">
                  <div className="flex items-center gap-3">
                    <Checkbox checked={isInPlaylist} onCheckedChange={() => handleTrackToggle(track, isInPlaylist)} />

                    <div className="w-10 h-10 bg-muted rounded-lg flex items-center justify-center flex-shrink-0">
                      <Music className="h-5 w-5 text-muted-foreground" />
                    </div>

                    <div className="flex-1 min-w-0">
                      <h4 className="font-medium text-sm truncate" title={track.Name}>
                        {track.Name}
                      </h4>
                      <p className="text-xs text-muted-foreground truncate">
                        {track.ArtistName || "Unknown Artist"} • {track.AlbumTitle || "Unknown Album"}
                      </p>

                      <div className="flex items-center gap-2 mt-1">
                        {track.GenreName && (
                          <Badge variant="secondary" className="text-xs">
                            {track.GenreName}
                          </Badge>
                        )}
                        <span className="text-xs text-muted-foreground">{formatDuration(track.Milliseconds)}</span>
                        <span className="text-xs text-muted-foreground">${track.UnitPrice}</span>
                      </div>
                    </div>

                    <Button
                      size="sm"
                      variant={isInPlaylist ? "destructive" : "default"}
                      onClick={() => handleTrackToggle(track, isInPlaylist)}
                    >
                      {isInPlaylist ? <Minus className="h-3 w-3" /> : <Plus className="h-3 w-3" />}
                    </Button>
                  </div>
                </CardContent>
              </Card>
            )
          })}
        </div>

        {filteredTracks.length === 0 && (
          <div className="text-center py-8">
            <Music className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
            <h3 className="text-lg font-semibold mb-2">No tracks found</h3>
            <p className="text-muted-foreground">Try adjusting your search criteria.</p>
          </div>
        )}

        {/* Summary */}
        <div className="border-t pt-4">
          <div className="flex justify-between items-center text-sm">
            <span className="text-muted-foreground">
              {playlistTrackIds.length} track{playlistTrackIds.length !== 1 ? "s" : ""} in playlist
            </span>
            <Button onClick={onClose}>Done</Button>
          </div>
        </div>
      </DialogContent>
    </Dialog>
  )
}
