# Code Architecture

This document provides an overview of the application's architecture and code organization.

## Backend (Laravel 12)

### Directory Structure

- `app/Http/Controllers/` - API controllers that handle HTTP requests
- `app/Models/` - Eloquent models representing database tables
- `app/Services/` - Business logic services
- `database/migrations/` - Database structure definitions
- `database/seeders/` - Seed data for development and testing
- `routes/api.php` - API route definitions
- `tests/Feature/` - API and feature tests

### Key Components

#### Models

- `User` - User accounts with roles (admin, operator, viewer)
- `Barang` - Equipment inventory items
- `Buku` - Book inventory
- `Kategori` and `SubKategori` - Categories for organizing items
- `Peminjaman` - Borrowing records
- `RiwayatBarang` - History logs for item transactions

#### Controllers

- `AuthController` - Handles login, logout, and user profile
- `BarangController` - CRUD operations for equipment items
- `BukuController` - CRUD operations for book inventory
- `PeminjamanController` - Manages borrowing and returns
- `KategoriController` - Manages categories and subcategories
- `DashboardController` - Provides statistics and summaries
- `ExportController` - Generates reports in various formats

### Authentication

The application uses Laravel Sanctum for API token authentication, with CORS configured for the frontend SPA.

## Frontend (React with Vite)

### Directory Structure

- `src/components/` - Reusable UI components
- `src/context/` - React context providers (Auth, etc.)
- `src/pages/` - Page components for each route
- `src/services/` - API service clients
- `src/App.jsx` - Main application component with routing
- `cypress/` - End-to-end tests

### Key Components

#### Context Providers

- `AuthContext` - Manages authentication state and user information

#### Services

- `api.js` - Axios instance configured for the Laravel backend
- Authentication interceptors for handling tokens and session expiry

#### Pages

- `Login.jsx` - Authentication page
- `Dashboard.jsx` - Main dashboard with statistics and charts
- `Barang.jsx` - Equipment inventory management
- `BarangCreate.jsx` - Form for adding/editing equipment
- `Peminjaman.jsx` - Borrowing management
- `Laporan.jsx` - Reporting and exports

### State Management

The application uses React Context API for global state management, with local component state for UI-specific concerns.

## API Integration

The frontend communicates with the backend through RESTful API endpoints.

1. Requests are made using the Axios instance in `services/api.js`
2. Laravel Sanctum CSRF protection is handled with the `withCredentials: true` setting
3. Authentication tokens are stored in localStorage and attached to requests
4. API responses follow a consistent format with appropriate HTTP status codes

## Data Flow

1. User interactions trigger React component events
2. Components call API services to fetch or modify data
3. API responses update component state or context
4. UI renders based on the updated state

## Security Features

- CSRF protection via Laravel Sanctum
- Role-based access control
- Token-based API authentication
- Proper input validation on both frontend and backend
- Secure password handling with bcrypt hashing

## Deployment Architecture

The application is designed to be deployed in various environments:

- **Development**: Local servers with hot reloading
- **Production**: Can be deployed as:
  - Traditional hosting with web server (Apache/Nginx)
  - Using Laravel Forge for simplified server management
  - Serverless deployment with Laravel Vapor

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions. 