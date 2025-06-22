import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true,
});

// Interceptor untuk error handling global
api.interceptors.response.use(
  (response) => response,
  (error) => {
    // Bisa custom error handling di sini
    if (error.response) {
      // Server error
      console.error('API Error:', error.response.data);
    } else if (error.request) {
      // Network error
      console.error('Network Error:', error.message);
    } else {
      // Lainnya
      console.error('Error:', error.message);
    }
    return Promise.reject(error);
  }
);

export default api; 