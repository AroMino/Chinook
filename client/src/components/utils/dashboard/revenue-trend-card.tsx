"use client"

import { useState, useMemo, useEffect } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import {
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  Area,
  AreaChart,
} from "recharts"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import ErrorComponent from "../error"
import { Skeleton } from "@/components/ui/skeleton"


interface Data {
  month: number
  year: number
  revenue: number
  sales: number
}

export default function RevenueTrendCard() {
  const [data, setData] = useState<Data[] | undefined>(undefined)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)
  const [selectedYear, setSelectedYear] = useState(2025) 

  // Fetch
  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true)
        setError(null)
        const res = await fetch("http://localhost:8989/dashboard/revenue-trend", {
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
  // Extraire toutes les années dispo dans les données
  const years = useMemo(() => {
    if(data) return [...new Set(data.map((d) => d.year))].sort()
    return []
  }, [data])

  // Filtrer les données par année
  const filteredData = useMemo(
    () => data ? data.filter((d) => d.year === selectedYear) : [],
    [selectedYear, data]
  )

  // Calculer total de revenue
  const totalRevenue = useMemo(
    () => filteredData.reduce((sum, d) => sum + d.revenue, 0),
    [filteredData]
  )

  return (
    <Card>
      {!loading && !error && <CardHeader className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <CardTitle>Monthly Revenue Trend</CardTitle>
          <CardDescription>
            Revenue and sales performance for {selectedYear}
          </CardDescription>
          <p className="mt-2 font-semibold text-primary">
            Total Revenue: ${totalRevenue.toLocaleString()}
          </p>
        </div>

        {/* Selecteur d'année */}
        <Select value={selectedYear.toString()} onValueChange={(v) => setSelectedYear(Number(v))}>
          <SelectTrigger className="w-[120px]">
            <SelectValue placeholder="Select year" />
          </SelectTrigger>
          <SelectContent>
            {years.map((year) => (
              <SelectItem key={year} value={year.toString()}>
                {year}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </CardHeader>}

      <CardContent>
        {loading && <SkeletonCard className="h-96 px-2"></SkeletonCard>}
        {!loading && error && <ErrorComponent>{error}</ErrorComponent>}
        {!loading && !error && <ResponsiveContainer width="100%" height={300}>
          <AreaChart data={filteredData}>
            <defs>
              <linearGradient id="revenueGradient" x1="0" y1="0" x2="0" y2="1">
                <stop offset="5%" stopColor="var(--primary)" stopOpacity={0.3} />
                <stop offset="95%" stopColor="var(--primary)" stopOpacity={0} />
              </linearGradient>
            </defs>
            <CartesianGrid strokeDasharray="3 3" stroke="var(--border)" />
            <XAxis dataKey="month" stroke="var(--muted-foreground)" fontSize={12} />
            <YAxis stroke="var(--muted-foreground)" fontSize={12} />
            <Tooltip
              contentStyle={{
                backgroundColor: "var(--card)",
                border: "1px solid var(--border)",
                borderRadius: "8px",
              }}
              formatter={(value, name) => [
                name === "revenue" ? `$${value.toLocaleString()}` : value.toLocaleString(),
                name === "revenue" ? "Revenue" : "Sales",
              ]}
            />
            <Area
              type="monotone"
              dataKey="revenue"
              stroke="var(--primary)"
              fillOpacity={1}
              fill="url(#revenueGradient)"
            />
          </AreaChart>
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
          <Skeleton className="h-4 w-40 rounded-md bg-muted" />
        </div>
        <Skeleton className="h-10 w-28 rounded-lg bg-muted" />
      </div>
    </div>
  )
}