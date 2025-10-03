import { Badge } from "@/components/ui/badge"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"

import { Music } from "lucide-react"
import { useEffect, useState } from "react"
import ErrorComponent from "../error"
import { Skeleton } from "@/components/ui/skeleton"

interface Data {
  TrackId: number
  Name: string
  GenreName: string
  ArtistName: string
  Revenue: number
  Sales: number
}


export default function TrackPerformanceCard () {
  const [data, setData] = useState<Data[] | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)


  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/tracks-performance", {
          method: "GET",
        })

        if (!res.ok) {
          throw new Error(`Erreur HTTP: ${res.status}`)
        }

        const d = await res.json()
        setData(d)
        console.log(d)
      } catch (err: unknown) {
        if (err instanceof Error) {
          setError(err.message)
        } else if (typeof err === "string") {
          setError(err)
        } else {
          setError("Une erreur inconnue s'est produite.")
        }
      } finally {
        setLoading(false)
      }
    }

    fetchData()
  }, [])
  
  return (
  <Card>
    {!loading && !error && <CardHeader>
      <CardTitle>Track Performance Details</CardTitle>
      <CardDescription>Complete breakdown of top performing tracks</CardDescription>
    </CardHeader>}

    <CardContent>
      {loading && <SkeletonCard className="px-2"></SkeletonCard>}
      {!loading && error && <ErrorComponent>{error}</ErrorComponent>}
      {!loading && !error && data && <div className="space-y-3">
        {data.map((track, index) => (
          <div key={track.Name} className="flex items-center justify-between p-4 rounded-lg border">
            <div className="flex items-center gap-4">
              <div className="w-10 h-10 bg-gradient-to-br from-primary/20 to-accent/20 rounded-lg flex items-center justify-center">
                <Music className="h-5 w-5 text-muted-foreground" />
              </div>
              <div>
                <h4 className="font-medium">{track.Name}</h4>
                <p className="text-sm text-muted-foreground">
                  {track.ArtistName} • {track.GenreName}
                </p>
              </div>
            </div>
            <div className="flex items-center gap-6 text-sm">
              <div className="text-center">
                <p className="font-semibold">{track.Sales.toLocaleString()}</p>
                <p className="text-muted-foreground">Sales</p>
              </div>
              <div className="text-center">
                <p className="font-semibold">${track.Revenue.toLocaleString()}</p>
                <p className="text-muted-foreground">Revenue</p>
              </div>
              <Badge variant={index < 3 ? "default" : "secondary"}>#{index + 1}</Badge>
            </div>
          </div>
        ))}
      </div>}
    </CardContent>
  </Card>
  )
}

export function SkeletonCard({ className }: { className?: string }) {
  return (
    <div className={`space-y-6 p-4 ${className}`}>
      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div className="space-y-2">
          <Skeleton className="h-4 w-48 rounded-md bg-muted" />
          <Skeleton className="h-4 w-72 rounded-md bg-muted" />
        </div>
      </div>
      <div className="flex flex-col gap-6 mt-10">
        {Array.from({ length: 10 }, (_, i) => {
          return (
            <div key={i} className="flex flex-row gap-4 items-center">
              <Skeleton className="h-10 w-10 rounded-md bg-muted"/>
              <div className="flex flex-col gap-2 w-full">
                <Skeleton className="h-4 w-96 rounded-md bg-muted" />
                <Skeleton className="h-4 w-full rounded-md bg-muted" />
              </div>
            </div>
          )
        })}
      </div>
      
    </div>
  )
}