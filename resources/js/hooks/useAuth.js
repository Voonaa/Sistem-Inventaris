import { useState } from 'react';
import axios from 'axios';

export function useAuth() {
    const [user, setUser] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    
    // Configuration for API requests
    const api = axios.create({
        baseURL: '/api',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        withCredentials: true
    });
    
    // Add token to requests if it exists in localStorage
    api.interceptors.request.use(config => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    });

    // Login function
    const login = async (email, password) => {
        setIsLoading(true);
        setError(null);
        
        try {
            const response = await api.post('/login', { email, password });
            const { token, user } = response.data;
            
            // Store token in localStorage
            localStorage.setItem('token', token);
            setUser(user);
            return user;
        } catch (err) {
            setError(err.response?.data?.message || 'An error occurred during login.');
            throw err;
        } finally {
            setIsLoading(false);
        }
    };
    
    // Logout function
    const logout = async () => {
        setIsLoading(true);
        
        try {
            await api.post('/logout');
            localStorage.removeItem('token');
            setUser(null);
        } catch (err) {
            setError(err.response?.data?.message || 'An error occurred during logout.');
        } finally {
            setIsLoading(false);
        }
    };
    
    // Check if user is authenticated
    const checkAuth = async () => {
        setIsLoading(true);
        
        try {
            const response = await api.get('/user');
            setUser(response.data);
            return response.data;
        } catch (err) {
            localStorage.removeItem('token');
            setUser(null);
            setError(err.response?.data?.message || 'Authentication failed.');
        } finally {
            setIsLoading(false);
        }
    };
    
    return {
        user,
        isLoading,
        error,
        login,
        logout,
        checkAuth,
        api
    };
} 