"use client"

import type React from "react"
import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import type { Album, Artist } from "@/types/chinook"
import { Loader2 } from "lucide-react"
import { toast } from "sonner"

interface AlbumFormProps {
  album?: Album
  artists: Artist[]
  onCancel: () => void
  onSubmit: () => void
}

export function AlbumForm({ album, artists, onCancel, onSubmit }: AlbumFormProps) {
  const [formData, setFormData] = useState({
    Title: album?.Title || "",
    ArtistId: album?.ArtistId?.toString() || "",
  })
  const [loading, setLoading] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()

    const albumData = {
      ...(album && { AlbumId: album.AlbumId }),
      Title: formData.Title,
      ArtistId: Number.parseInt(formData.ArtistId),
    }

    try {
      setLoading(true)
      const res = await fetch("http://localhost:8989/album", {
        method: album ? "PUT" : "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(albumData)
      })

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
      onSubmit()
      toast.success(album ? "Album mis à jour avec succès !" : "Album ajouté avec succès !")
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
    <Card className="w-full max-w-lg mx-auto">
      <CardHeader>
        <CardTitle>{album ? "Edit Album" : "Add New Album"}</CardTitle>
        <CardDescription>
          {album ? "Update album information" : "Add a new album to your music catalog"}
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="title">Album Title *</Label>
            <Input
              id="title"
              value={formData.Title}
              onChange={(e) => setFormData({ ...formData, Title: e.target.value })}
              placeholder="Enter album title"
              required
            />
          </div>

          <div className="space-y-2">
            <Label htmlFor="artist">Artist *</Label>
            <Select
              value={formData.ArtistId}
              onValueChange={(value) => setFormData({ ...formData, ArtistId: value })}
            >
              <SelectTrigger>
                <SelectValue placeholder="Select artist" />
              </SelectTrigger>
              <SelectContent>
                {artists.map((artist) => (
                  <SelectItem key={artist.ArtistId} value={artist.ArtistId.toString()}>
                    {artist.Name}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>

          <div className="flex gap-2 pt-4">
            <Button type="submit" className="flex-1" disabled={loading}>
              {loading && <Loader2 className="animate-spin"></Loader2>}
              {album ? "Update Album" : "Add Album"}
            </Button>
            <Button
              type="button"
              variant="outline"
              onClick={onCancel}
              className="flex-1 bg-transparent"
            >
              Cancel
            </Button>
          </div>
        </form>
      </CardContent>
    </Card>
  )
}
