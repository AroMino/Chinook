"use client"

import { useState, useEffect } from "react"
import { Button } from "@/components/ui/button"
import { TrackForm } from "@/components/utils/tracks/track-form"
import { TrackCatalog } from "@/components/utils/tracks/track-catalog"
import { getTracksWithDetails } from "@/lib/mock-data"
import { Plus } from "lucide-react"
import type { Album, Genre, MediaType, TrackWithDetails } from "@/types/chinook"
import ErrorComponent from "@/components/utils/error"
import { ConfirmDialog } from "@/components/utils/confirm-dialog"
import { toast } from "sonner"

export default function TracksPage() {
  const [tracks, setTracks] = useState<TrackWithDetails[]>(getTracksWithDetails())
  const [showForm, setShowForm] = useState(false)
  const [editingTrack, setEditingTrack] = useState<TrackWithDetails | null>(null)

    const [trackToDelete, setTrackToDelete] = useState<TrackWithDetails | null>(null)
  
  const [albums, setAlbums] = useState<Album[]>([])
  const [genres, setGenres] = useState<Genre[]>([])
  const [types, setTypes] = useState<MediaType[]>([])

  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)

  const fetchUtils = async () => {
    try {
      setLoading(true)
      setError(null);
      const res = await fetch("http://localhost:8989/track/form-utils", {
        method: "GET",
      });

      if (!res.ok) {
        throw new Error(`Erreur HTTP: ${res.status}`);
      }

      const data = await res.json();
      setAlbums(data.albums);
      setGenres(data.genres);
      setTypes(data.mediaTypes);
    } catch (err: unknown) {
      if (err instanceof Error) {
        setError(err.message);
      } else if (typeof err === "string") {
        setError(err);
      } else {
        setError("Une erreur inconnue s'est produite.");
      }
    } finally {
      setLoading(false);
    }
  };

  const fetchTracks = async () => {
    try {
      setLoading(true)
      setError(null);
      const res = await fetch("http://localhost:8989/track/index/details", {
        method: "GET",
      });

      if (!res.ok) {
        let error = "Une erreur est survenue. Veuillez réessayer."
        switch (res.status) {
          case 400:
            error = "Requête invalide. Vérifiez vos champs."
            break
          case 404:
            error = "Ressource introuvable. L’album ou l’artiste demandé n’existe pas."
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
    } finally {
      setLoading(false);
    }
  };

  // Fetch
  useEffect(() => {
    fetchUtils();
    fetchTracks();
  }, []);

  

  const handleFormSuccess = () => {
    setEditingTrack(null)
    setShowForm(false)
    fetchTracks()
  }

  const handleDeleteTrack = (trackId: number) => {
    setTrackToDelete(tracks.find((a) => a.TrackId === trackId) || null)
  }

  const handleEditClick = (track: TrackWithDetails) => {
    setEditingTrack(track)
    setShowForm(true)
  }

  const handleCancelForm = () => {
    setShowForm(false)
    setEditingTrack(null)
  }

  const confirmDelete = async () => {
    if (trackToDelete) {
      try {
        const res = await fetch("http://localhost:8989/track", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({TrackId: trackToDelete.TrackId})
        })

        if (!res.ok) {
          let error = "Une erreur est survenue. Veuillez réessayer."
          switch (res.status) {
            case 400:
              error = "Requête invalide. Vérifiez vos champs."
              break
            case 404:
              error = "Ressource introuvable. L’album demandé n’existe pas."
              break
            case 500:
              error = "Erreur serveur. Veuillez réessayer plus tard."
              break
            default:
              error = `Erreur HTTP: ${res.status}`
          }

          throw new Error(error)
        }
        fetchTracks()
        toast.success("Album supprimé avec succès !")
      } catch (err: unknown) {
        const errorMessage =
          err instanceof Error
            ? err.message
            : typeof err === "string"
            ? err
            : "Une erreur inconnue s'est produite."

        toast.error(errorMessage)
      } finally {
        setLoading(false)
        setTrackToDelete(null)
      }
      
    }
  }

  const cancelDelete = () => setTrackToDelete(null)

  if(error) return <ErrorComponent>{error}</ErrorComponent>

  return (
    <div>
      <main className="p-6">
        {showForm ? (
          <TrackForm
            track={editingTrack || undefined}
            albums={albums}
            genres={genres}
            types={types}
            onSuccess={handleFormSuccess}
            onCancel={handleCancelForm}
          />
        ) : (
          <div className="space-y-6">
            <div className="flex justify-between items-center">
              <div>
                <h2 className="text-2xl font-bold">Track Catalog</h2>
                <p className="text-muted-foreground">Manage your music tracks with full CRUD operations</p>
              </div>
              <Button onClick={() => setShowForm(true)} disabled={loading}>
                <Plus className="h-4 w-4 mr-2" />
                Add Track
              </Button>
            </div>

            <TrackCatalog
              tracks={tracks}
              onEdit={handleEditClick}
              onDelete={handleDeleteTrack}
              loading={loading}
            />
            <ConfirmDialog
              isOpen={!!trackToDelete}
              title="Delete Track"
              description={`Are you sure you want to delete "${trackToDelete?.Name}"?`}
              onConfirm={confirmDelete}
              onCancel={cancelDelete}
            />
          </div>
        )}
      </main>
    </div>
  )
}
