import { AlertCircle } from "lucide-react";

export default function ErrorComponent({ children }: { children: string }) {
  return (
    <div className="text-center py-12">
      <AlertCircle className="h-12 w-12 text-red-500 mx-auto mb-4" />
      <h3 className="text-lg font-semibold mb-2 text-red-600">
        Une erreur est survenue
      </h3>
      <p className="text-muted-foreground">
        Impossible de charger les données :{" "}
        <span className="font-semibold text-red-500">{children}</span>
      </p>
    </div>
  );
}
