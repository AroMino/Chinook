import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Dashboard from "./pages/dashboard/page";
import TracksPage from "./pages/tracks/page";
// import PlaylistsPage from "./pages/playlists/page";
import AlbumsPage from "./pages/albums/page";
import ArtistsPage from "./pages/artitsts/page";
import Layout from "./layout";



export default function App() {
  return (
    <Router>
      <Routes>
         <Route element={<Layout />}>
          <Route path="/" element={<Dashboard />}></Route>
          <Route path="/tracks" element={<TracksPage />}></Route>
          {/* <Route path="/playlists" element={<PlaylistsPage />}></Route> */}
          <Route path="/albums" element={<AlbumsPage />}></Route>
          <Route path="/artists" element={<ArtistsPage />}></Route>
         </Route>
      </Routes>
    </Router>
  );
}
