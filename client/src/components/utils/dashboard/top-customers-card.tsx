import { Badge } from "@/components/ui/badge"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Skeleton } from "@/components/ui/skeleton"
import { useEffect, useState } from "react"
import ErrorComponent from "../error"

interface Data {
  CustomerId: number
  FirstName: string
  LastName: string
  TotalSpent: number
  Email: string
  Country: string
}

export default function TopCustomersCard () {
  const [data, setData] = useState<Data[] | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)


  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/top-customers", {
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
      <CardTitle>Top Customers</CardTitle>
      <CardDescription>Highest spending customers this period</CardDescription>
    </CardHeader>}
    <CardContent>
      {loading && <SkeletonCard className="px-2"></SkeletonCard>}
      {!loading && error && <ErrorComponent>{error}</ErrorComponent>}
      {!loading && !error && data && <div className="space-y-4">
        {data.map((customer, index) => (
          <div key={customer.Email} className="flex items-center justify-between p-3 rounded-lg bg-muted/50">
            <div className="flex items-center gap-3">
              <div className="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center text-sm font-medium">
                {index + 1}
              </div>
              <div>
                <p className="font-medium text-sm">{customer.FirstName + " " + customer.LastName}</p>
                <p className="text-xs text-muted-foreground">{customer.Email}</p>
              </div>
            </div>
            <div className="text-right">
              <p className="font-semibold text-sm">${customer.TotalSpent}</p>
              <Badge variant="secondary" className="text-xs">
                {customer.Country}
              </Badge>
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
        {Array.from({ length: 5 }, (_, i) => {
          return (
            <div key={i} className="flex flex-row gap-4 items-center">
              <Skeleton className="h-10 w-11 rounded-full bg-muted"/>
              <div className="flex flex-col gap-2 w-full">
                <Skeleton className="h-4 w-48 rounded-md bg-muted" />
                <Skeleton className="h-4 w-full rounded-md bg-muted" />
              </div>
            </div>
          )
        })}
      </div>
      
    </div>
  )
}