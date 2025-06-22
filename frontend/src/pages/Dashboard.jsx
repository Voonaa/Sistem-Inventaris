import { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import { useAuthContext } from '@/contexts/AuthContext';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Dashboard() {
    const { user, api } = useAuthContext();
    const [stats, setStats] = useState({
        totalItems: 0,
        totalCategories: 0,
        recentTransactions: [],
        loading: true,
        error: null
    });

    // Fetch dashboard data
    useEffect(() => {
        const fetchDashboardData = async () => {
            try {
                // Get counts separately to avoid errors if one endpoint fails
                const [itemsResponse, categoriesResponse, transactionsResponse] = await Promise.all([
                    api.get('/items').catch(() => ({ data: [] })),
                    api.get('/categories').catch(() => ({ data: [] })),
                    api.get('/transactions').catch(() => ({ data: [] }))
                ]);
                
                setStats({
                    totalItems: itemsResponse.data.length || 0,
                    totalCategories: categoriesResponse.data.length || 0,
                    recentTransactions: transactionsResponse.data.slice(0, 5) || [],
                    loading: false,
                    error: null
                });
            } catch (err) {
                setStats({
                    ...stats,
                    loading: false,
                    error: 'Failed to load dashboard data'
                });
                console.error('Error fetching dashboard data:', err);
            }
        };

        if (user) {
            fetchDashboardData();
        }
    }, [user, api]);

    // Format date
    const formatDate = (dateString) => {
        if (!dateString) return 'N/A';
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    };

    return (
        <AuthenticatedLayout>
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

                    {stats.loading ? (
                        <div className="text-center py-4">
                            <p>Loading dashboard data...</p>
                        </div>
                    ) : stats.error ? (
                        <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            <p>{stats.error}</p>
                        </div>
                    ) : (
                        <>
                            {/* Stats Cards */}
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                    <div className="text-gray-400 dark:text-gray-300 text-sm font-medium">
                                        Total Items
                                    </div>
                                    <div className="text-2xl font-bold text-gray-800 dark:text-white">
                                        {stats.totalItems}
                                    </div>
                                </div>
                                
                                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                    <div className="text-gray-400 dark:text-gray-300 text-sm font-medium">
                                        Categories
                                    </div>
                                    <div className="text-2xl font-bold text-gray-800 dark:text-white">
                                        {stats.totalCategories}
                                    </div>
                                </div>
                                
                                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                    <div className="text-gray-400 dark:text-gray-300 text-sm font-medium">
                                        Available Items
                                    </div>
                                    <div className="text-2xl font-bold text-gray-800 dark:text-white">
                                        {stats.totalItems} {/* This should be refined in a real implementation */}
                                    </div>
                                </div>
                                
                                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                                    <div className="text-gray-400 dark:text-gray-300 text-sm font-medium">
                                        Recent Transactions
                                    </div>
                                    <div className="text-2xl font-bold text-gray-800 dark:text-white">
                                        {stats.recentTransactions.length}
                                    </div>
                                </div>
                            </div>
                            
                            {/* Recent Transactions */}
                            <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                    <h3 className="text-lg font-medium text-gray-800 dark:text-white">Recent Transactions</h3>
                                </div>
                                <div className="p-6">
                                    {stats.recentTransactions.length === 0 ? (
                                        <p className="text-gray-500 dark:text-gray-400">No recent transactions found.</p>
                                    ) : (
                                        <div className="overflow-x-auto">
                                            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead className="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Type
                                                        </th>
                                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Item
                                                        </th>
                                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            Date
                                                        </th>
                                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                            User
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    {stats.recentTransactions.map((transaction) => (
                                                        <tr key={transaction.id}>
                                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                                <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                                    transaction.transaction_type === 'check_out' 
                                                                        ? 'bg-red-100 text-red-800'
                                                                        : transaction.transaction_type === 'check_in'
                                                                        ? 'bg-green-100 text-green-800'
                                                                        : transaction.transaction_type === 'maintenance'
                                                                        ? 'bg-yellow-100 text-yellow-800'
                                                                        : 'bg-blue-100 text-blue-800'
                                                                }`}>
                                                                    {transaction.transaction_type?.replace('_', ' ') || 'Unknown'}
                                                                </span>
                                                            </td>
                                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                                {transaction.item?.name || 'Unknown item'}
                                                            </td>
                                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                                {formatDate(transaction.transaction_date)}
                                                            </td>
                                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                                {transaction.user?.name || 'Unknown user'}
                                                            </td>
                                                        </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
