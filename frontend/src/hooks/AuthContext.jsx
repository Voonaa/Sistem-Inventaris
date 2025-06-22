import { createContext, useContext, useEffect, useState } from 'react';
import { useAuth } from '@/hooks/useAuth';

// Create Authentication Context
const AuthContext = createContext();

export function AuthProvider({ children }) {
    const auth = useAuth();
    const [isInitialized, setIsInitialized] = useState(false);
    
    // Check authentication status on initial load
    useEffect(() => {
        const initAuth = async () => {
            try {
                if (localStorage.getItem('token')) {
                    await auth.checkAuth();
                }
            } catch (error) {
                console.error('Authentication initialization failed:', error);
            } finally {
                setIsInitialized(true);
            }
        };
        
        initAuth();
    }, []);
    
    // Values exposed by the context
    const contextValue = {
        ...auth,
        isInitialized
    };
    
    return (
        <AuthContext.Provider value={contextValue}>
            {children}
        </AuthContext.Provider>
    );
}

// Custom hook to use the auth context
export function useAuthContext() {
    const context = useContext(AuthContext);
    
    if (!context) {
        throw new Error('useAuthContext must be used within an AuthProvider');
    }
    
    return context;
} 