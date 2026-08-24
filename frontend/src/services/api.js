import axios from "axios";

// Adapte cette URL a l'emplacement de ton backend PHP
// (ex: http://localhost/projet-employes/backend/api si servi par Apache/XAMPP,
// ou http://localhost:8000/api si tu lances `php -S localhost:8000` dans backend/).
const api = axios.create({
  baseURL: "http://localhost:8000/api",
});

export default api;