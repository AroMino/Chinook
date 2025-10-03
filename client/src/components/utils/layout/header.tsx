const pageNames: Record<string, string> = {
  "/": "Sales Dashboard",
  "/tracks": "Track Management",
  "/albums": "Album Management",
  "/playlists": "Playlist Management",
};

interface HeaderProps {
  currentPath: string;
}

export function Header( { currentPath } : HeaderProps) {
  const pathname = currentPath;
  const pageName = pageNames[pathname] || "Music Manager";

  return (
    <header className="bg-card border-b border-border px-6 py-4">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-semibold text-foreground">{pageName}</h1>
          <p className="text-sm text-muted-foreground mt-1">
            Manage your music catalog and analyze sales performance
          </p>
        </div>
        <div className="flex items-center gap-2">
          <div className="h-2 w-2 bg-accent rounded-full animate-pulse" />
          <span className="text-sm text-muted-foreground">Live</span>
        </div>
      </div>
    </header>
  );
}

