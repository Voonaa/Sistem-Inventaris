<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(isset($isAdminEdit) && $isAdminEdit)
                {{ __('Edit Pengguna') }}
            @else
                {{ __('Profile') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(isset($isAdminEdit) && $isAdminEdit)
                <div class="mb-4">
                    <a href="{{ route('pengguna.index') }}" class="text-blue-600 hover:text-blue-900">
                        <span class="inline-flex items-center">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Daftar Pengguna
                        </span>
                    </a>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if(isset($isAdminEdit) && $isAdminEdit)
                        @include('profile.partials.admin-update-user-form')
                    @else
                        @include('profile.partials.update-profile-information-form')
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if(isset($isAdminEdit) && $isAdminEdit)
                        @include('profile.partials.admin-update-password-form')
                    @else
                        @include('profile.partials.update-password-form')
                    @endif
                </div>
            </div>

            @if(!isset($isAdminEdit) || !$isAdminEdit)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
