"use client"
import GenreRevenueDistributionCard from "@/components/utils/dashboard/genre-revenue-distribution-card"
import MetricsCard from "@/components/utils/dashboard/metrics-card"
import RevenueTrendCard from "@/components/utils/dashboard/revenue-trend-card"
import TopAlbumsCard from "@/components/utils/dashboard/top-albums-card"
import TopCustomersCard from "@/components/utils/dashboard/top-customers-card"
import TopTracksCard from "@/components/utils/dashboard/top-tracks-card"
import TrackPerformanceCard from "@/components/utils/dashboard/track-performance-card"

export default function Dashboard() {

  // Calculate growth percentages
  
  return (
    <div>
      <main className="p-6 space-y-6">
        {/* Key Metrics Cards */}
        <MetricsCard />
        

        {/* Revenue Trend */}
        <RevenueTrendCard />

        {/* Top Performers */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Top Tracks */}
          <TopTracksCard />

          {/* Top Albums */}
          <TopAlbumsCard />

          
        </div>

        {/* Genre Performance & Top Customers */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Genre Distribution */}
          <GenreRevenueDistributionCard />
          

          {/* Top Customers */}
          <TopCustomersCard />
          
        </div>

        {/* Detailed Track Performance */}
        <TrackPerformanceCard />
        
      </main>
    </div>
  )
}
