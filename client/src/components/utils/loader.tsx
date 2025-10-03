import { Loader2 } from "lucide-react";

export default function Loader(){
  return (
    <div className="flex justify-center items-center h-64">
      <Loader2 className="animate-spin text-[var(--primary)] w-10 h-10" />
      <span className="ml-3 text-lg font-medium text-gray-700">
        Chargement des données...
      </span>
    </div>
  );
}
