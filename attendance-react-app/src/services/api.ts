import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // L'URL de base du backend Laravel
   headers: {
    'Content-Type': 'application/json',
  },
});

export default api;
