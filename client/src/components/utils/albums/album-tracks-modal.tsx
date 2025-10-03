"use client"

import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Card, CardContent } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Music, Clock, DollarSign } from "lucide-react"
import { formatDuration, mockGenres } from "@/lib/mock-data"
import type { AlbumWithDetails, Track } from "@/types/chinook"
import { useEffect, useState } from "react"
import Loader from "../loader"
import ErrorComponent from "../error"

interface tracksModalProps {
  album: AlbumWithDetails | null
  isOpen: boolean
  onClose: () => void
}

export function AlbumTracksModal({ album, isOpen, onClose }: tracksModalProps) {
  
  const [tracks, setTracks] = useState<Track[] | null>(null)
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)

  useEffect(() => {
    const fetchTracks = async () => {
      try {
        setLoading(true)
        setError(null);
        const res = await fetch(`http://localhost:8989/album/${album?.AlbumId}/tracks`, {
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
  
    if(album && album.AlbumId) fetchTracks();
  }, [album]);

  if (!album) return null

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="max-w-2xl max-h-[80vh] overflow-y-auto">
        
        <DialogHeader>
          {(!loading && !error) ? (<>
            <DialogTitle className="flex items-center gap-2">
              <Music className="w-5 h-5 flex-shrink-0" />
              {album.Title}
            </DialogTitle>
            <DialogDescription>
              by {album.ArtistName} • {tracks?.length} track{tracks?.length !== 1 ? "s" : ""}
            </DialogDescription>
          </>) : (<>
            <DialogTitle className="flex items-center gap-2">
            </DialogTitle>
            <DialogDescription>
            </DialogDescription>
          </>)}
        </DialogHeader>

        {loading && <Loader/>}
        {error && <ErrorComponent>{error}</ErrorComponent>}
        {!loading && !error && tracks && <div className="space-y-3">
          {tracks.length > 0 ? (
            tracks.map((track, index) => {
              const genre = mockGenres.find((g) => g.GenreId === track.GenreId)

              return (
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
                        {track.Composer && (
                          <p className="text-sm text-muted-foreground truncate" title={track.Composer}>
                            {track.Composer}
                          </p>
                        )}

                        <div className="flex items-center gap-3 mt-2">
                          {genre && (
                            <Badge variant="secondary" className="text-xs">
                              {genre.Name}
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
                    </div>
                  </CardContent>
                </Card>
              )
            })
          ) : (
            <div className="text-center py-8">
              <Music className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-semibold mb-2">No tracks found</h3>
              <p className="text-muted-foreground">This album doesn't have any tracks yet.</p>
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
                  {formatDuration(tracks.reduce((sum, track) => sum + track.Milliseconds, 0))}
                </div>
                <div className="text-muted-foreground">Duration</div>
              </div>
              <div className="text-center">
                <div className="font-semibold">
                  ${tracks.reduce((sum, track) => sum + track.UnitPrice, 0).toFixed(2)}
                </div>
                <div className="text-muted-foreground">Total Value</div>
              </div>
            </div>
          </div>
        )}
      </DialogContent>
    </Dialog>
  )
}
