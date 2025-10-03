import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer
} from "recharts"
import { Star } from "lucide-react"
import { useEffect, useState } from "react"
import ErrorComponent from "../error"
import { Skeleton } from "@/components/ui/skeleton"

interface Data {
  AlbumId: number
  Title: string
  ArtistName: string
  Revenue: number
  Sales: number
}

export default function TopAlbumsCard () {
  const [data, setData] = useState<Data[] | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)


  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/top-albums", {
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
  return (
    <Card>
      {!loading && !error && <CardHeader>
        <CardTitle className="flex items-center gap-2">
          <Star className="h-5 w-5 text-blue-500" />
          Top 5 Albums by Revenue
        </CardTitle>
        <CardDescription>Highest earning albums this period</CardDescription>
      </CardHeader>}

      <CardContent>
        {loading && <SkeletonCard className="h-96 px-2"></SkeletonCard>}
        {!loading && error && <ErrorComponent>{error}</ErrorComponent>}
        {!loading && !error && data && <ResponsiveContainer width="100%" height={300}>
          <BarChart data={data.slice(0, 5)}>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis
              dataKey="Title"
              stroke="var(--muted-foreground)"
              fontSize={12}
              angle={-30}
              textAnchor="end"
              height={80}
            />
            <YAxis stroke="var(--muted-foreground)" fontSize={12} />
            <Tooltip
              contentStyle={{
                backgroundColor: "var(--card)",
                border: "1px solid var(--border)",
                borderRadius: "8px",
              }}
              formatter={(value) => [`$${value.toLocaleString()}`, "Revenue"]}
            />
            <Bar dataKey="Revenue" fill="var(--accent)" radius={[4, 4, 0, 0]} />
          </BarChart>
        </ResponsiveContainer>}
      </CardContent>
    </Card>
  )
}

export function SkeletonCard({ className }: { className?: string }) {
  return (
    <div className={`flex flex-col space-y-6 p-4 ${className}`}>
      <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div className="space-y-2">
          <Skeleton className="h-4 w-48 rounded-md bg-muted" /> 
          <Skeleton className="h-4 w-72 rounded-md bg-muted" />
        </div>
      </div>
    </div>
  )
}