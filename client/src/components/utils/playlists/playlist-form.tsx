"use client"

import type React from "react"

import { useState } from "react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import type { Playlist } from "@/types/chinook"

interface PlaylistFormProps {
  playlist?: Playlist
  onSubmit: (playlist: Playlist) => void
  onCancel: () => void
}

export function PlaylistForm({ playlist, onSubmit, onCancel }: PlaylistFormProps) {
  const [formData, setFormData] = useState({
    Name: playlist?.Name || "",
  })

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()

    const playlistData = {
      ...(playlist && { PlaylistId: playlist.PlaylistId }),
      Name: formData.Name,
    }

    // onSubmit(playlistData)
  }

  return (
    <Card className="w-full max-w-lg mx-auto">
      <CardHeader>
        <CardTitle>{playlist ? "Edit Playlist" : "Create New Playlist"}</CardTitle>
        <CardDescription>
          {playlist ? "Update playlist information" : "Create a new playlist to organize your music"}
        </CardDescription>
      </CardHeader>
      <CardContent>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="name">Playlist Name *</Label>
            <Input
              id="name"
              value={formData.Name}
              onChange={(e) => setFormData({ ...formData, Name: e.target.value })}
              placeholder="Enter playlist name"
              required
            />
          </div>

          <div className="flex gap-2 pt-4">
            <Button type="submit" className="flex-1">
              {playlist ? "Update Playlist" : "Create Playlist"}
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
