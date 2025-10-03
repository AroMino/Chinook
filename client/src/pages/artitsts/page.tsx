"use client"

import { useState, useEffect, useMemo } from "react"
import { Button } from "@/components/ui/button"
import { ArtistForm } from "@/components/utils/artists/artist-form"
import { ArtistCatalog } from "@/components/utils/artists/artist-catalog"
import { ArtistAlbumsModal } from "@/components/utils/artists/artist-albums-modal"
import { Plus } from "lucide-react"
import type { ArtistWithDetails } from "@/lib/mock-data"
import ErrorComponent from "@/components/utils/error"
import { ConfirmDialog } from "@/components/utils/confirm-dialog"
import { toast } from "sonner"



export default function ArtistsPage() {
  const [artists, setArtists] = useState<ArtistWithDetails[]>([])
  const [showForm, setShowForm] = useState(false)
  const [editingArtist, setEditingArtist] = useState<ArtistWithDetails | null>(null)
  const [selectedArtist, setSelectedArtist] = useState<ArtistWithDetails | null>(null)
  const [artistToDelete, setArtistToDelete] = useState<ArtistWithDetails | null>(null)
  const [currentPage, setCurrentPage] = useState(1)
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)
  const [searchTerm, setSearchTerm] = useState("")


  const fetchArtistsWithDetails = async () => {
    try {
      setLoading(true)
      setError(null);
      const res = await fetch("http://localhost:8989/artist/index/details", {
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
      setArtists(data);
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
    fetchArtistsWithDetails();
  }, []);

  // Filter artists
  const filteredArtists = useMemo(() => {
    setCurrentPage(1)
    return artists.filter((artist) => {
      const matchesSearch = artist.Name.toLowerCase().includes(searchTerm.toLowerCase())
      return matchesSearch
  })
  }, [artists, searchTerm])

  const handleFormSuccess = () => {
    setEditingArtist(null)
    setShowForm(false)
    fetchArtistsWithDetails()
  }

  const handleDeleteArtist = (artistId: number) => {
    setArtistToDelete(artists.find((a) => a.ArtistId === artistId) || null)
  }

  const handleEditClick = (artist: ArtistWithDetails) => {
    setEditingArtist(artist)
    setShowForm(true)
  }

  const handleViewAlbums = (artist: ArtistWithDetails) => {
    setSelectedArtist(artist)
  }

  const handleCancelForm = () => {
    setShowForm(false)
    setEditingArtist(null)
  }

  const confirmDelete = async () => {
    if (artistToDelete) {
      try {
        const res = await fetch("http://localhost:8989/artist", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ArtistId: artistToDelete.ArtistId})
        })

        if (!res.ok) {
          let error = "Une erreur est survenue. Veuillez réessayer."
          switch (res.status) {
            case 400:
              error = "Requête invalide. Vérifiez vos champs."
              break
            case 404:
              error = "Ressource introuvable. L’artiste demandé n’existe pas."
              break
            case 500:
              error = "Erreur serveur. Veuillez réessayer plus tard."
              break
            default:
              error = `Erreur HTTP: ${res.status}`
          }

          throw new Error(error)
        }
        fetchArtistsWithDetails()
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
        setArtistToDelete(null)
      }
    }
  }

  const cancelDelete = () => setArtistToDelete(null)

  if(error) return <ErrorComponent>{error}</ErrorComponent>

  return (
    <div>
      <main className="p-6">
        {showForm ? (
          <ArtistForm
            artist={editingArtist || undefined}
            onSubmit={handleFormSuccess}
            onCancel={handleCancelForm}
          />
        ) : (
          <div className="space-y-6">
            <div className="flex justify-between items-center">
              <div>
                <h2 className="text-2xl font-bold">Artist Directory</h2>
                <p className="text-muted-foreground">Manage your music artists and explore their discographies</p>
              </div>
              <Button onClick={() => setShowForm(true)} disabled={loading}>
                <Plus className="h-4 w-4 mr-2" />
                Add Artist
              </Button>
            </div>

            <ArtistCatalog
              artists={filteredArtists}
              searchTerm={searchTerm}
              loading={loading}
              onSearchTermChange={setSearchTerm}
              onEdit={handleEditClick}
              onDelete={handleDeleteArtist}
              onViewAlbums={handleViewAlbums}
              currentPage={currentPage}
              onPageChange={setCurrentPage}
            />
          </div>
        )}

        <ArtistAlbumsModal
          artist={selectedArtist}
          isOpen={!!selectedArtist}
          onClose={() => setSelectedArtist(null)}
        />
        <ConfirmDialog
          isOpen={!!artistToDelete}
          title="Delete Artist"
          description={`Are you sure you want to delete "${artistToDelete?.Name}"? This will also delete all associated tracks.`}
          onConfirm={confirmDelete}
          onCancel={cancelDelete}
        />
      </main>
    </div>
  )
}
