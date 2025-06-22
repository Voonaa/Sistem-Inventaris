import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';

const ProtectedRoute = ({ children }) => {
  const { user, token } = useAuth();
  const location = useLocation();

  // If the user is not authenticated, redirect to the login page
  if (!user && !token) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // If the user is authenticated, render the requested component
  return children;
};

export default ProtectedRoute; 