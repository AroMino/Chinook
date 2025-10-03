"use client"

import { useState, useEffect, useMemo } from "react"
import { Button } from "@/components/ui/button"
import { PlaylistForm } from "@/components/utils/playlists/playlist-form"
import { PlaylistCatalog } from "@/components/utils/playlists/playlist-catalog"
import { PlaylistTracksModal } from "@/components/utils/playlists/playlist-tracks-modal"
import { ManageTracksModal } from "@/components/utils/playlists/manage-tracks-modal"
import { getPlaylistsWithDetails, mockPlaylistTracks } from "@/lib/mock-data"
import { Plus } from "lucide-react"
import type { Playlist, PlaylistWithDetails, PlaylistTrack } from "@/types/chinook"
import ErrorComponent from "@/components/utils/error"
import Loader from "@/components/utils/loader"


export default function PlaylistsPage() {
  const [playlists, setPlaylists] = useState<PlaylistWithDetails[]>(getPlaylistsWithDetails())
  const [playlistTracks, setPlaylistTracks] = useState<PlaylistTrack[]>(mockPlaylistTracks)
  const [showForm, setShowForm] = useState(false)
  const [editingPlaylist, setEditingPlaylist] = useState<PlaylistWithDetails | null>(null)
  const [selectedPlaylist, setSelectedPlaylist] = useState<PlaylistWithDetails | null>(null)
  const [managingPlaylist, setManagingPlaylist] = useState<PlaylistWithDetails | null>(null)
  const [currentPage, setCurrentPage] = useState(1)
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState<boolean>(false)
  const [searchTerm, setSearchTerm] = useState("")

  const fetchPlaylistWithDetails = async () => {
    try {
      setLoading(true)
      setError(null);
      const res = await fetch("http://localhost:8989/playlist/index", {
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
      setPlaylists(data);
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
    fetchPlaylistWithDetails();
  }, []);

  // Filter playlists
  const filteredPlaylists = useMemo(() => {
    setCurrentPage(1)
    return playlists.filter((playlist) =>
      playlist.Name.toLowerCase().includes(searchTerm.toLowerCase()),
    )
  }, [searchTerm, playlists])


  const handleAddPlaylist = (playlistData: Playlist) => {
    const newPlaylist: PlaylistWithDetails = {
      ...playlistData,
      PlaylistId: Math.max(...playlists.map((p) => p.PlaylistId)) + 1,
      TrackCount: 0,
      TotalDuration: 0,
      TotalRevenue: 0,
      Tracks: [],
    }

    setPlaylists([newPlaylist, ...playlists])
    setShowForm(false)
  }

  const handleEditPlaylist = (playlistData: Playlist) => {
    const updatedPlaylists = playlists.map((playlist) =>
      playlist.PlaylistId === playlistData.PlaylistId ? { ...playlist, ...playlistData } : playlist,
    )
    setPlaylists(updatedPlaylists)
    setEditingPlaylist(null)
    setShowForm(false)
  }

  const handleDeletePlaylist = (playlistId: number) => {
    if (confirm("Are you sure you want to delete this playlist?")) {
      setPlaylists(playlists.filter((playlist) => playlist.PlaylistId !== playlistId))
      setPlaylistTracks(playlistTracks.filter((pt) => pt.PlaylistId !== playlistId))
    }
  }

  const handleAddTrackToPlaylist = (playlistId: number, trackId: number) => {
    const newPlaylistTrack: PlaylistTrack = { PlaylistId: playlistId, TrackId: trackId }
    setPlaylistTracks([...playlistTracks, newPlaylistTrack])

    // Refresh playlists with updated details
    setPlaylists(getPlaylistsWithDetails())
  }

  const handleRemoveTrackFromPlaylist = (playlistId: number, trackId: number) => {
    setPlaylistTracks(playlistTracks.filter((pt) => !(pt.PlaylistId === playlistId && pt.TrackId === trackId)))

    // Refresh playlists with updated details
    setPlaylists(getPlaylistsWithDetails())
  }

  const handleEditClick = (playlist: PlaylistWithDetails) => {
    setEditingPlaylist(playlist)
    setShowForm(true)
  }

  const handleViewTracks = (playlist: PlaylistWithDetails) => {
    setSelectedPlaylist(playlist)
  }

  const handleManageTracks = (playlist: PlaylistWithDetails) => {
    setManagingPlaylist(playlist)
  }

  const handleCancelForm = () => {
    setShowForm(false)
    setEditingPlaylist(null)
  }

  if(loading) return <Loader />
  if(error) return <ErrorComponent>{error}</ErrorComponent>

  return (
    <div>
      <main className="p-6">
        {showForm ? (
          <PlaylistForm
            playlist={editingPlaylist || undefined}
            onSubmit={editingPlaylist ? handleEditPlaylist : handleAddPlaylist}
            onCancel={handleCancelForm}
          />
        ) : (
          <div className="space-y-6">
            <div className="flex justify-between items-center">
              <div>
                <h2 className="text-2xl font-bold">Playlist Manager</h2>
                <p className="text-muted-foreground">Create and manage your music playlists</p>
              </div>
              <Button onClick={() => setShowForm(true)}>
                <Plus className="h-4 w-4 mr-2" />
                Create Playlist
              </Button>
            </div>

            <PlaylistCatalog
              playlists={filteredPlaylists}
              searchTerm={searchTerm}
              onSearchTermChange={setSearchTerm}
              currentPage={currentPage}
              onEdit={handleEditClick}
              onDelete={handleDeletePlaylist}
              onViewTracks={handleViewTracks}
              onManageTracks={handleManageTracks}
              // totalPages={totalPages}
              onPageChange={setCurrentPage}
            />
          </div>
        )}

        <PlaylistTracksModal
          playlist={selectedPlaylist}
          isOpen={!!selectedPlaylist}
          onClose={() => setSelectedPlaylist(null)}
          onRemoveTrack={handleRemoveTrackFromPlaylist}
        />

        <ManageTracksModal
          playlist={managingPlaylist}
          isOpen={!!managingPlaylist}
          onClose={() => setManagingPlaylist(null)}
          onAddTrack={handleAddTrackToPlaylist}
          onRemoveTrack={handleRemoveTrackFromPlaylist}
        />
      </main>
    </div>
  )
}
