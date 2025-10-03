"use client"

import type React from "react"
import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import type { Artist } from "@/types/chinook"
import { toast } from "sonner"
import { Loader2 } from "lucide-react"

interface ArtistFormProps {
  artist?: Artist
  onSubmit: () => void
  onCancel: () => void
}

export function ArtistForm({ artist, onSubmit, onCancel }: ArtistFormProps) {
  const [formData, setFormData] = useState({
    Name: artist?.Name || "",
  })
  const [loading, setLoading] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()

    if (!formData.Name.trim()) {
      return
    }

    const artistData = {
      ArtistId: artist?.ArtistId  || 0,
      Name: formData.Name.trim(),
    }

    try {
      setLoading(true)
      const res = await fetch("http://localhost:8989/artist", {
        method: artist ? "PUT" : "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(artistData)
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
      onSubmit()
      toast.success(artist ? "Artiste mis à jour avec succès !" : "Artiste ajouté avec succès !")
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
        <CardTitle>{artist ? "Edit Artist" : "Add New Artist"}</CardTitle>
        <CardDescription>
          {artist ? "Update artist information" : "Add a new artist to your music catalog"}
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="name">Artist Name *</Label>
            <Input
              id="name"
              value={formData.Name}
              onChange={(e) => setFormData({ ...formData, Name: e.target.value })}
              placeholder="Enter artist name"
              required
            />
          </div>

          <div className="flex gap-2 pt-4">
            <Button type="submit" className="flex-1" disabled={loading}>
              {loading && <Loader2 className="animate-spin"></Loader2>}
              {artist ? "Update Artist" : "Add Artist"}
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
