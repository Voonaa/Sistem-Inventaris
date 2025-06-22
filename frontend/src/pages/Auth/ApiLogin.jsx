import { useState } from 'react';
import { Head } from '@inertiajs/react';
import { useAuthContext } from '@/contexts/AuthContext';
import GuestLayout from '@/Layouts/GuestLayout';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';

export default function ApiLogin() {
    const { login, isLoading, error } = useAuthContext();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [formError, setFormError] = useState('');
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        setFormError('');
        
        try {
            await login(email, password);
            window.location.href = '/dashboard';
        } catch (error) {
            setFormError(error.response?.data?.message || 'Failed to log in. Please check your credentials.');
        }
    };
    
    return (
        <GuestLayout>
            <Head title="API Login" />
            
            <div className="mb-4 text-sm text-gray-600">
                Please log in to access the inventory management system.
            </div>
            
            {(formError || error) && (
                <div className="mb-4 text-sm text-red-600">
                    {formError || error}
                </div>
            )}
            
            <form onSubmit={handleSubmit}>
                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={email}
                        className="mt-1 block w-full"
                        onChange={(e) => setEmail(e.target.value)}
                        required
                        autoComplete="username"
                    />
                </div>
                
                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={password}
                        className="mt-1 block w-full"
                        onChange={(e) => setPassword(e.target.value)}
                        required
                        autoComplete="current-password"
                    />
                </div>
                
                <div className="flex items-center justify-end mt-4">
                    <PrimaryButton className="ml-4" disabled={isLoading}>
                        {isLoading ? 'Logging in...' : 'Log in'}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
} 