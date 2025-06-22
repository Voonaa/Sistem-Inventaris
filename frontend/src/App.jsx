import React from 'react';
import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import LoginPage from './pages/Auth/Login';
import DashboardPage from './pages/Dashboard';
import HomePage from './pages/Welcome';
import ProtectedRoute from './components/ProtectedRoute';
import BarangPage from './pages/Barang/Index';

function App() {
  return (
    <Router>
      <div>
        <nav className="p-4 bg-gray-800 text-white">
          <ul className="flex space-x-4">
            <li>
              <Link to="/">Home</Link>
            </li>
            <li>
              <Link to="/login">Login</Link>
            </li>
            <li>
              <Link to="/dashboard">Dashboard</Link>
            </li>
          </ul>
        </nav>

        <hr />

        <div className="p-4">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/login" element={<LoginPage />} />
            <Route 
              path="/dashboard" 
              element={
                <ProtectedRoute>
                  <DashboardPage />
                </ProtectedRoute>
              } 
            />
            <Route 
              path="/barang" 
              element={
                <ProtectedRoute>
                  <BarangPage />
                </ProtectedRoute>
              } 
            />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App; 