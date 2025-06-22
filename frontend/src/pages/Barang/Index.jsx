import React, { useEffect, useState } from 'react';
import AuthenticatedLayout from '../../components/AuthenticatedLayout';
import api from '../../services/api';
import PrimaryButton from '../../components/PrimaryButton';
import TextInput from '../../components/TextInput';

export default function BarangPage() {
    const [barang, setBarang] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [search, setSearch] = useState('');

    const fetchBarang = () => {
        setLoading(true);
        api.get(`/barangs?search=${search}`)
            .then(response => {
                setBarang(response.data.data); // Data is under 'data' property for pagination
            })
            .catch(error => {
                setError('Failed to fetch data.');
                console.error(error);
            })
            .finally(() => {
                setLoading(false);
            });
    };

    useEffect(() => {
        const timer = setTimeout(() => {
            fetchBarang();
        }, 500); // Debounce search
        return () => clearTimeout(timer);
    }, [search]);

    return (
        <AuthenticatedLayout
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Manajemen Barang</h2>}
        >
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex justify-between items-center mb-4">
                                <TextInput
                                    type="text"
                                    placeholder="Cari barang..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="w-1/3"
                                />
                                <PrimaryButton>Tambah Barang</PrimaryButton>
                            </div>

                            {loading && <p>Loading...</p>}
                            {error && <p className="text-red-500">{error}</p>}

                            {!loading && !error && (
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Merk</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {barang.map((item) => (
                                            <tr key={item.id}>
                                                <td className="px-6 py-4 whitespace-nowrap">{item.kode}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{item.nama}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{item.merk}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{item.sub_kategori?.kategori?.nama}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{item.jumlah}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button className="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    <button className="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
} 