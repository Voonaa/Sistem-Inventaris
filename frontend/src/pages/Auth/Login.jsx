import React, { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../../contexts/AuthContext';
import PrimaryButton from '../../components/PrimaryButton';
import TextInput from '../../components/TextInput';
import InputLabel from '../../components/InputLabel';
import InputError from '../../components/InputError';

export default function Login() {
    const navigate = useNavigate();
    const { login } = useAuth();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState(null);
    const [processing, setProcessing] = useState(false);

    const submit = async (e) => {
        e.preventDefault();
        setProcessing(true);
        setError(null);

        try {
            await login(email, password);
            navigate('/dashboard');
        } catch (err) {
            setError('The provided credentials are not correct.');
            console.error(err);
        } finally {
            setProcessing(false);
        }
    };

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <h1 className="text-2xl font-bold text-center mb-4">Login</h1>
                {error && <div className="mb-4 text-red-500">{error}</div>}
                
                <form onSubmit={submit}>
                    <div>
                        <InputLabel htmlFor="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            isFocused={true}
                            onChange={(e) => setEmail(e.target.value)}
                            required
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
                            autoComplete="current-password"
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                    </div>
                    
                    <div className="flex items-center justify-end mt-4">
                        <PrimaryButton className="ms-4" disabled={processing}>
                            {processing ? 'Logging in...' : 'Log in'}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
}
