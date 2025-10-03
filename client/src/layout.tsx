"use client"

import { Sidebar } from "@/components/utils/layout/sidebar"
import { Header } from "@/components/utils/layout/header"
import { useLocation, Outlet } from "react-router-dom"

export default function Layout() {
  const location = useLocation()

  return (
    <div className="flex h-screen bg-background">
      <Sidebar currentPath={location.pathname} />
      <div className="flex-1 md:ml-64">
        <Header currentPath={location.pathname} />
        <main className="p-6">
          <Outlet />
        </main>
      </div>
    </div>
  )
}
