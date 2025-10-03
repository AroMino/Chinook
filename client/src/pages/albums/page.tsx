"use client"

import { useState, useMemo, useEffect } from "react"
import { Button } from "@/components/ui/button"
import { AlbumForm } from "@/components/utils/albums/album-form"
import { AlbumCatalog } from "@/components/utils/albums/album-catalog"
import { AlbumTracksModal } from "@/components/utils/albums/album-tracks-modal"
import { Plus } from "lucide-react"
import type { AlbumWithDetails, Artist } from "@/types/chinook"
import ErrorComponent from "@/components/utils/error"
import { ConfirmDialog } from "@/components/utils/confirm-dialog"
import { toast } from "sonner"

const ALBUMS_PER_PAGE = 8

export default function AlbumsPage() {
  const [albums, setAlbums] = useState<AlbumWithDetails[]>([])
  const [artists, setArtists] = useState<Artist[]>([])
  const [showForm, setShowForm] = useState(false)
  const [editingAlbum, setEditingAlbum] = useState<AlbumWithDetails | null>(null)
  const [albumToDelete, setAlbumToDelete] = useState<AlbumWithDetails | null>(null)

  const [selectedAlbum, setSelectedAlbum] = useState<AlbumWithDetails | null>(null)
  const [currentPage, setCurrentPage] = useState(1)
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)

  const [searchTerm, setSearchTerm] = useState("")
  const [artistFilter, setArtistFilter] = useState("all")

  const fetchAlbumWithDetails = async () => {
    try {
      setLoading(true)
      setError(null);
      const res = await fetch("http://localhost:8989/album/index/details", {
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
      setAlbums(data);
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
    const fetchArtists = async () => {
      try {
        setLoading(true)
        setError(null);
        const res = await fetch("http://localhost:8989/artist/index", {
          method: "GET",
        });

        if (!res.ok) {
          throw new Error(`Erreur HTTP: ${res.status}`);
        }

        const data = await res.json();
        setArtists(data);
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

    fetchArtists();
    fetchAlbumWithDetails();
  }, []);

  // Filter
  const filteredAlbums = useMemo(() => {
    setCurrentPage(1)
    return albums.filter((album) => {
      const matchesSearch =
        album.Title.toLowerCase().includes(searchTerm.toLowerCase())
        // || album.ArtistName?.toLowerCase().includes(searchTerm.toLowerCase())
      const matchesArtist = artistFilter === "all" || album.ArtistId.toString() === artistFilter

      return matchesSearch && matchesArtist
    })
  }, [albums, artistFilter, searchTerm])

  // Pagination
  const totalPages = Math.ceil(filteredAlbums.length / ALBUMS_PER_PAGE)
  const paginatedAlbums = useMemo(() => {
    const startIndex = (currentPage - 1) * ALBUMS_PER_PAGE
    return filteredAlbums.slice(startIndex, startIndex + ALBUMS_PER_PAGE)
  }, [filteredAlbums, currentPage])

  const handleFormSuccess = () => {
    setEditingAlbum(null)
    setShowForm(false)
    fetchAlbumWithDetails()
  }
  
  const handleEditClick = (album: AlbumWithDetails) => {
    setEditingAlbum(album)
    setShowForm(true)
  }

  const handleViewTracks = (album: AlbumWithDetails) => {
    setSelectedAlbum(album)
  }

  const handleCancelForm = () => {
    setShowForm(false)
    setEditingAlbum(null)
  }

  const handleDeleteAlbum = (albumId: number) => {
    setAlbumToDelete(albums.find((a) => a.AlbumId === albumId) || null)
  }

  const confirmDelete = async () => {
    if (albumToDelete) {
      try {
        const res = await fetch("http://localhost:8989/album", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({AlbumId: albumToDelete.AlbumId})
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
        fetchAlbumWithDetails()
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
        setAlbumToDelete(null)
      }
      
    }
  }

  const cancelDelete = () => setAlbumToDelete(null)

  if(error) return <ErrorComponent>{error}</ErrorComponent>

  return (
    <div>
      <main className="p-6">
        {showForm ? (
          <AlbumForm
            album={editingAlbum || undefined}
            artists={artists}
            onCancel={handleCancelForm}
            onSubmit={handleFormSuccess}
          />
        ) : (
          <div className="space-y-6">
            <div className="flex justify-between items-center">
              <div>
                <h2 className="text-2xl font-bold">Album Collection</h2>
                <p className="text-muted-foreground">Manage your music albums with cover art and track listings</p>
              </div>
              <Button onClick={() => setShowForm(true)} disabled={loading}>
                <Plus className="h-4 w-4 mr-2" />
                Add Album
              </Button>
            </div>

            <AlbumCatalog
              loading={loading}
              albums={paginatedAlbums}
              artists={artists}
              currentPage={currentPage}
              totalPages={totalPages}
              searchTerm={searchTerm}
              artistFilter={artistFilter}
              onEdit={handleEditClick}
              onDelete={handleDeleteAlbum}
              onViewTracks={handleViewTracks}
              onPageChange={setCurrentPage}
              onArtistFilterChange={setArtistFilter}
              onSearchTermChange={setSearchTerm}
            />
          </div>
        )}

        <AlbumTracksModal album={selectedAlbum} isOpen={!!selectedAlbum} onClose={() => setSelectedAlbum(null)} />
        <ConfirmDialog
          isOpen={!!albumToDelete}
          title="Delete Album"
          description={`Are you sure you want to delete "${albumToDelete?.Title}"? This will also delete all associated tracks.`}
          onConfirm={confirmDelete}
          onCancel={cancelDelete}
        />
      </main>
    </div>
  )
}
