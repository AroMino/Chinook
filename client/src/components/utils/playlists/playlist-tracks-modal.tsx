"use client"

import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Card, CardContent } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Music, Clock, DollarSign, Trash2 } from "lucide-react"
import { formatDuration } from "@/lib/mock-data"
import type { PlaylistWithDetails, TrackWithDetails } from "@/types/chinook"
import { useEffect, useState } from "react"
import Loader from "../loader"
import ErrorComponent from "../error"

interface PlaylistTracksModalProps {
  playlist: PlaylistWithDetails | null
  isOpen: boolean
  onClose: () => void
  onRemoveTrack?: (playlistId: number, trackId: number) => void
}

export function PlaylistTracksModal({ playlist, isOpen, onClose, onRemoveTrack }: PlaylistTracksModalProps) {
  const [tracks, setTracks] = useState<TrackWithDetails[] | null>(null)
    const [error, setError] = useState<string | null>(null)
    const [loading, setLoading] = useState<boolean>(false)
  
    useEffect(() => {
      const fetchAlbumWithDetails = async () => {
        try {
          setLoading(true)
          setError(null);
          const res = await fetch(`http://localhost:8989/playlist/${playlist?.PlaylistId}/tracks`, {
            method: "GET",
          });
  
          if (!res.ok) {
            let error = "Une erreur est survenue. Veuillez réessayer."
            switch (res.status) {
              case 400:
                error = "Requête invalide. Vérifiez vos champs."
                break
              case 404:
                error = "Ressource introuvable. Le playlist demandé n’existe pas."
                break
              case 500:
                error = "Erreur serveur. Veuillez réessayer plus tard."
                break
              default:
                error = `Erreur HTTP: ${res.status}`
            }
            throw new Error(error)
          }
          const data = await res.json();
          setTracks(data);
        } catch (err: unknown) {
          const errorMessage =
            err instanceof Error
              ? err.message
              : typeof err === "string"
              ? err
              : "Une erreur inconnue s'est produite."
          setError(errorMessage)
        }
         finally {
          setLoading(false);
        }
      };
    
      if(playlist && playlist.PlaylistId) fetchAlbumWithDetails();
    }, [playlist]);
  
    if (!playlist) return null

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="max-w-2xl max-h-[80vh] overflow-y-auto">
        <DialogHeader>
          {(!loading && !error && tracks) ? (<>
            <DialogTitle className="flex items-center gap-2">
            <Music className="h-5 w-5" />
            {playlist.Name}
          </DialogTitle>
            <DialogDescription>
            {tracks.length} track{tracks.length !== 1 ? "s" : ""} •{" "}
            {playlist.TotalDuration ? formatDuration(playlist.TotalDuration) : "0:00"}
          </DialogDescription>
          </>) : (<>
            <DialogTitle className="flex items-center gap-2">
            </DialogTitle>
            <DialogDescription>
            </DialogDescription>
          </>)}
        </DialogHeader>

        {loading && <Loader />}
        {error && <ErrorComponent>{error}</ErrorComponent>}

        {!loading && !error && tracks && <div className="space-y-3">
          {tracks.length > 0 ? (
            tracks.map((track, index) => (
              <Card key={track.TrackId}>
                <CardContent className="p-4">
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 bg-muted rounded-full flex items-center justify-center text-sm font-medium">
                      {index + 1}
                    </div>

                    <div className="flex-1 min-w-0">
                      <h4 className="font-medium truncate" title={track.Name}>
                        {track.Name}
                      </h4>
                      <p className="text-sm text-muted-foreground truncate">
                        {track.ArtistName || "Unknown Artist"} • {track.AlbumTitle || "Unknown Album"}
                      </p>

                      <div className="flex items-center gap-3 mt-2">
                        {track.GenreName && (
                          <Badge variant="secondary" className="text-xs">
                            {track.GenreName}
                          </Badge>
                        )}
                        <div className="flex items-center gap-1 text-xs text-muted-foreground">
                          <Clock className="h-3 w-3" />
                          {formatDuration(track.Milliseconds)}
                        </div>
                        <div className="flex items-center gap-1 text-xs text-muted-foreground">
                          <DollarSign className="h-3 w-3" />${track.UnitPrice}
                        </div>
                      </div>
                    </div>

                    {onRemoveTrack && (
                      <Button
                        size="sm"
                        variant="ghost"
                        onClick={() => onRemoveTrack(playlist.PlaylistId, track.TrackId)}
                        className="text-destructive hover:text-destructive"
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    )}
                  </div>
                </CardContent>
              </Card>
            ))
          ) : (
            <div className="text-center py-8">
              <Music className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-semibold mb-2">No tracks in this playlist</h3>
              <p className="text-muted-foreground">Add some tracks to get started.</p>
            </div>
          )}
        </div>}

        {tracks && tracks.length > 0 && (
          <div className="border-t pt-4 mt-4">
            <div className="grid grid-cols-3 gap-4 text-sm">
              <div className="text-center">
                <div className="font-semibold">{tracks.length}</div>
                <div className="text-muted-foreground">Tracks</div>
              </div>
              <div className="text-center">
                <div className="font-semibold">
                  {playlist.TotalDuration ? formatDuration(playlist.TotalDuration) : "0:00"}
                </div>
                <div className="text-muted-foreground">Duration</div>
              </div>
              <div className="text-center">
                <div className="font-semibold">${(playlist.TotalRevenue || 0).toFixed(2)}</div>
                <div className="text-muted-foreground">Total Value</div>
              </div>
            </div>
          </div>
        )}
      </DialogContent>
    </Dialog>
  )
}
