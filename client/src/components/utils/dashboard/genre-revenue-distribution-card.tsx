import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import {
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from "recharts"
import { useEffect, useState } from "react"
import ErrorComponent from "../error"
import { Skeleton } from "@/components/ui/skeleton"

interface Data {
  GenreId: number
  GenreName: string
  Revenue: number
  Sales: number
}

export default function GenreRevenueDistributionCard () {
  const [data, setData] = useState<Data[] | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)


  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/genre-performance", {
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
      <CardTitle>Genre Performance</CardTitle>
      <CardDescription>Revenue distribution by music genre</CardDescription>
    </CardHeader>}
    <CardContent>
      {loading && <SkeletonCard className="h-96 px-2"></SkeletonCard>}
      {!loading && error && <ErrorComponent>{error}</ErrorComponent>}
      {!loading && !error && data && <ResponsiveContainer width="100%" height={300}>
        <PieChart>
          <Pie
            data={data}
            cx="50%"
            cy="50%"
            outerRadius={100}
            dataKey="Revenue"
            label={({ GenreName, Percentage }) => `${GenreName}: ${Percentage}%`}
          >
            {data.map((entry, index) => (
              <Cell key={`cell-${entry}`} fill={`var(--chart-${(index % 5) + 1})`} />
            ))}
          </Pie>
          <Tooltip
            contentStyle={{
              backgroundColor: "var(--foreground)",
              border: "1px solid var(--border)",
              borderRadius: "8px",
            }}
            formatter={(value) => [`$${value.toLocaleString()}`, "Revenue"]}
          />
        </PieChart>
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