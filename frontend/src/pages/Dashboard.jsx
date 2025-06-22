import React, { useEffect, useState } from 'react';
import { Head } from '@inertiajs/react';
import { useAuthContext } from '@/contexts/AuthContext';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import api from '../services/api';

const StatCard = ({ title, value, children }) => (
    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h3 className="text-lg font-semibold text-gray-700">{title}</h3>
        <p className="text-3xl font-bold text-gray-900 mt-2">{value}</p>
        {children}
    </div>
);

export default function Dashboard() {
    const { user, api } = useAuthContext();
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        api.get('/dashboard')
            .then(response => {
                setStats(response.data);
            })
            .catch(error => {
                setError('Failed to fetch dashboard data.');
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    if (loading) {
        return (
            <AuthenticatedLayout>
                <div className="p-6 text-center">Loading dashboard...</div>
            </AuthenticatedLayout>
        );
    }

    if (error) {
        return (
            <AuthenticatedLayout>
                <div className="p-6 text-red-500 text-center">{error}</div>
            </AuthenticatedLayout>
        );
    }

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="mb-6">
                        <h1 className="text-2xl font-bold text-gray-800 dark:text-white">
                            Welcome, {user?.name || 'User'}
                        </h1>
                        <p className="text-gray-600 dark:text-gray-300">
                            Inventory Management System for SMK Sasmita
                        </p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <StatCard title="Total Barang" value={stats.total_barang} />
                        <StatCard title="Total Buku" value={stats.buku.total} />
                        <StatCard title="Peminjaman Aktif" value={stats.peminjaman_aktif} />
                        <StatCard title="Total Kategori" value={stats.total_kategori} />
                    </div>

                    {/* Tambahkan chart atau tabel lain di sini jika perlu */}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
