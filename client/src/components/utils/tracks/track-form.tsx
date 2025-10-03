"use client"

import type React from "react"

import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import type { Album, Genre, MediaType, Track } from "@/types/chinook"
import { toast } from "sonner"
import { Loader2 } from "lucide-react"

interface TrackFormProps {
  track?: Track
  albums: Album[]
  genres: Genre[]
  types: MediaType[]
  onSuccess: () => void
  onCancel: () => void
}

export function TrackForm({ track, albums, genres, types, onSuccess, onCancel }: TrackFormProps) {
  const [formData, setFormData] = useState({
    Name: track?.Name || "",
    AlbumId: track?.AlbumId?.toString() || "",
    MediaTypeId: track?.MediaTypeId?.toString() || "1",
    GenreId: track?.GenreId?.toString() || "",
    Composer: track?.Composer || "",
    Milliseconds: track?.Milliseconds?.toString() || "",
    UnitPrice: track?.UnitPrice?.toString() || "0.99",
  })

  const [loading, setLoading] = useState<boolean>(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()

    const trackData = {
      ...(track && { TrackId: track.TrackId }),
      Name: formData.Name,
      AlbumId: formData.AlbumId ? Number.parseInt(formData.AlbumId) : undefined,
      MediaTypeId: Number.parseInt(formData.MediaTypeId),
      GenreId: formData.GenreId ? Number.parseInt(formData.GenreId) : undefined,
      Composer: formData.Composer || undefined,
      Milliseconds: Number.parseInt(formData.Milliseconds),
      UnitPrice: Number.parseFloat(formData.UnitPrice),
    }

    try {
      setLoading(true)
      const res = await fetch("http://localhost:8989/track", {
        method: track ? "PUT" : "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(trackData)
      })

      if (!res.ok) {
        let error = "Une erreur est survenue. Veuillez réessayer."
        switch (res.status) {
          case 400:
            error = "Requête invalide. Vérifiez vos champs."
            break
          case 404:
            error = "Ressource introuvable. L’album ou le genre demandé n’existe pas."
            break
          case 500:
            error = "Erreur serveur. Veuillez réessayer plus tard."
            break
          default:
            error = `Erreur HTTP: ${res.status}`
        }

        throw new Error(error)
      }
      toast.success(track ? "Track mis à jour avec succès !" : "Track ajouté avec succès !")
      onSuccess()
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
    }
  }

  return (
    <Card className="w-full max-w-2xl mx-auto">
      <CardHeader>
        <CardTitle>{track ? "Edit Track" : "Add New Track"}</CardTitle>
        <CardDescription>
          {track ? "Update track information" : "Add a new track to your music catalog"}
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="name">Track Name *</Label>
              <Input
                id="name"
                value={formData.Name}
                onChange={(e) => setFormData({ ...formData, Name: e.target.value })}
                placeholder="Enter track name"
                required
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="album">Album</Label>
              <Select value={formData.AlbumId} onValueChange={(value) => setFormData({ ...formData, AlbumId: value })}>
                <SelectTrigger>
                  <SelectValue placeholder="Select album" />
                </SelectTrigger>
                <SelectContent>
                  {albums.map((album) => (
                    <SelectItem key={album.AlbumId} value={album.AlbumId.toString()}>
                      {album.Title} - {album.ArtistName}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            <div className="space-y-2">
              <Label htmlFor="genre">Genre</Label>
              <Select value={formData.GenreId} onValueChange={(value) => setFormData({ ...formData, GenreId: value })}>
                <SelectTrigger>
                  <SelectValue placeholder="Select genre" />
                </SelectTrigger>
                <SelectContent>
                  {genres.map((genre) => (
                    <SelectItem key={genre.GenreId} value={genre.GenreId.toString()}>
                      {genre.Name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            <div className="space-y-2">
              <Label htmlFor="mediaType">Media Type *</Label>
              <Select
                value={formData.MediaTypeId}
                onValueChange={(value) => setFormData({ ...formData, MediaTypeId: value })}
              >
                <SelectTrigger>
                  <SelectValue placeholder="Select media type" />
                </SelectTrigger>
                <SelectContent>
                  {types.map((mediaType) => (
                    <SelectItem key={mediaType.MediaTypeId} value={mediaType.MediaTypeId.toString()}>
                      {mediaType.Name}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            <div className="space-y-2">
              <Label htmlFor="composer">Composer</Label>
              <Input
                id="composer"
                value={formData.Composer}
                onChange={(e) => setFormData({ ...formData, Composer: e.target.value })}
                placeholder="Enter composer name"
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="duration">Duration (ms) *</Label>
              <Input
                id="duration"
                type="number"
                value={formData.Milliseconds}
                onChange={(e) => setFormData({ ...formData, Milliseconds: e.target.value })}
                placeholder="Duration in milliseconds"
                required
              />
            </div>

            <div className="space-y-2 md:col-span-2">
              <Label htmlFor="price">Unit Price *</Label>
              <Input
                id="price"
                type="number"
                step="0.01"
                value={formData.UnitPrice}
                onChange={(e) => setFormData({ ...formData, UnitPrice: e.target.value })}
                placeholder="0.99"
                required
              />
            </div>
          </div>

          <div className="flex gap-2 pt-4">
            <Button type="submit" className="flex-1"disabled={loading}>
              {loading && <Loader2 className="animate-spin"></Loader2>}
              {track ? "Update Track" : "Add Track"}
            </Button>
            <Button type="button" variant="outline" onClick={onCancel} className="flex-1 bg-transparent">
              Cancel
            </Button>
          </div>
        </form>
      </CardContent>
    </Card>
  )
}
