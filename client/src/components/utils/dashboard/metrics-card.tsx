import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { TrendingUp, Users, Music, Disc3, DollarSign, ShoppingCart } from "lucide-react"

import { useEffect, useState } from "react"
import ErrorComponent from "../error"

interface Data {
  tracks: number
  albums: number
  customers: number
  artists: number
  totalRevenue: number
  totalSales: number
  revenueGrowth: number
  salesGrowth: number
}

export default function MetricsCard() {
  const [data, setData] = useState<Data | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)

  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/metrics", {
          method: "GET",
        })

        if (!res.ok) {
          throw new Error(`Erreur HTTP: ${res.status}`)
        }

        const d = await res.json()
        setData(d)
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

  if(error) return <ErrorComponent>{error}</ErrorComponent>

  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
      {loading && <>
          <SkeletonCard></SkeletonCard>
          <SkeletonCard></SkeletonCard>
          <SkeletonCard></SkeletonCard>
          <SkeletonCard></SkeletonCard>
          <SkeletonCard></SkeletonCard>
        </>
      }

      {!loading && data && <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-medium">Total Revenue</CardTitle>
          <DollarSign className="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold">${data.totalRevenue.toLocaleString()}</div>
          <div className="flex flex-wrap gap-1 text-xs">
              <TrendingUp className="h-3 w-3 text-green-500 inline" />
            <span className="text-green-500">
              {Math.abs(data.revenueGrowth).toFixed(1)}%
            </span>
            {/* <span className="text-muted-foreground">from last month</span> */}
          </div>
        </CardContent>
      </Card>}

      {!loading && data && <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-medium">Total Sales</CardTitle>
          <ShoppingCart className="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold">{data.totalSales.toLocaleString()}</div>
          <p className="text-xs text-green-500">+{data.salesGrowth.toFixed(2)}%</p>
        </CardContent>
      </Card>}

      {!loading && data && <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-medium">Customers</CardTitle>
          <Users className="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold">{data.customers}</div>
          {/* <p className="text-xs text-muted-foreground">+5 new this month</p> */}
        </CardContent>
      </Card>}

      {!loading && data && <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-medium">Catalog Tracks</CardTitle>
          <Disc3 className="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold">{data.tracks.toLocaleString()}</div>
          <p className="text-xs text-muted-foreground">{data.albums} albums</p>
        </CardContent>
      </Card>}

      {/* Nouvelle carte artistes */}
      {!loading && data && <Card>
        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle className="text-sm font-medium">Artists</CardTitle>
          <Music className="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
          <div className="text-2xl font-bold">{data.artists.toLocaleString()}</div>
          {/* <p className="text-xs text-muted-foreground">unique artists</p> */}
        </CardContent>
      </Card>}
    </div>
  )
}

import { Skeleton } from "@/components/ui/skeleton"

export function SkeletonCard() {
  return (
    <div className="flex flex-col space-y-3">
      <Skeleton className="bg-muted h-[125px] w-full rounded-xl" />
      <div className="space-y-2">
        <Skeleton className="bg-muted h-4 w-full" />
        <Skeleton className="bg-muted h-4 w-full" />
      </div>
    </div>
  )
}
