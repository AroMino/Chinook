"use client"

import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import { Card, CardContent } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Disc3, Clock, DollarSign } from "lucide-react"
import { formatDuration } from "@/lib/mock-data"
import type { ArtistWithDetails } from "@/lib/mock-data"
import { useEffect, useState } from "react"
import { AlbumWithDetails } from "@/types/chinook"
import Loader from "../loader"
import ErrorComponent from "../error"

interface ArtistAlbumsModalProps {
  artist: ArtistWithDetails | null
  isOpen: boolean
  onClose: () => void
}

export function ArtistAlbumsModal({ artist, isOpen, onClose }: ArtistAlbumsModalProps) {
  const [albums, setAlbums] = useState<AlbumWithDetails[] | null>(null)
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)
  
  useEffect(() => {
    const fetchAlbums = async () => {
      try {
        setLoading(true)
        setError(null);
        const res = await fetch(`http://localhost:8989/artist/${artist?.ArtistId}/albums`, {
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
        setAlbums(data);
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
  
    if(artist && artist.ArtistId) fetchAlbums();
  }, [artist]);
  
  if (!artist) return null

  return (
    <Dialog open={isOpen} onOpenChange={onClose}>
      <DialogContent className="max-w-2xl max-h-[80vh] overflow-y-auto">
        <DialogHeader>
          {(!loading && !error) ? (<>
          <DialogTitle className="flex items-center gap-2">
          <Disc3 className="h-5 w-5" />
          {artist.Name} Albums
          </DialogTitle>
          <DialogDescription>
            {artist.AlbumCount} album{artist.AlbumCount !== 1 ? "s" : ""} by {artist.Name}
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
        {!loading && !error && albums && <div className="space-y-3">
          {albums.length > 0 ? (
            albums.map((album) => {
              return (
                <Card key={album.AlbumId}>
                  <CardContent className="p-4">
                    <div className="flex items-center gap-3">
                      <div className="w-12 h-12 bg-gradient-to-br from-primary/20 to-accent/20 rounded-lg flex items-center justify-center">
                        <Disc3 className="h-6 w-6 text-muted-foreground" />
                      </div>

                      <div className="flex-1 min-w-0">
                        <h4 className="font-medium truncate" title={album.Title}>
                          {album.Title}
                        </h4>

                        <div className="flex items-center gap-3 mt-2">
                          <Badge variant="secondary" className="text-xs">
                            {album.TrackCount} track{album.TrackCount !== 1 ? "s" : ""}
                          </Badge>
                          <div className="flex items-center gap-1 text-xs text-muted-foreground">
                            <Clock className="h-3 w-3" />
                            {formatDuration(album.TotalDuration || 0)}
                          </div>
                          <div className="flex items-center gap-1 text-xs text-muted-foreground">
                            <DollarSign className="h-3 w-3" />${(album.TotalRevenue || 0).toFixed(2)}
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
              <Disc3 className="h-12 w-12 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-semibold mb-2">No albums found</h3>
              <p className="text-muted-foreground">This artist doesn't have any albums yet.</p>
            </div>
          )}
        </div>}

        {albums && albums.length > 0 && (
          <div className="border-t pt-4 mt-4">
            <div className="grid grid-cols-2 gap-4 text-sm">
              <div className="text-center">
                <div className="font-semibold">{artist.AlbumCount}</div>
                <div className="text-muted-foreground">Albums</div>
              </div>
              <div className="text-center">
                <div className="font-semibold">{artist.TrackCount || 0}</div>
                <div className="text-muted-foreground">Total Tracks</div>
              </div>
              {/* <div className="text-center">
                <div className="font-semibold">${(artist.TotalRevenue || 0).toFixed(2)}</div>
                <div className="text-muted-foreground">Total Revenue</div>
              </div> */}
            </div>
          </div>
        )}
      </DialogContent>
    </Dialog>
  )
}
