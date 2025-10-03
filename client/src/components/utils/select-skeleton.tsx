import { Skeleton } from "@/components/ui/skeleton"

export function SelectSkeleton() {
  return (
    <div className="flex flex-col my-3">
      <div className="space-y-2">
        <Skeleton className="bg-muted h-4 w-full" />
        <Skeleton className="bg-muted h-4 w-full" />
      </div>
    </div>
  )
}
