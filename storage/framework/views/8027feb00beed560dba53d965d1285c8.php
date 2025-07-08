<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>SISVEN | Inventaris SMK Sasmita</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/logosmk.png')); ?>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Sidebar Navigation (Mobile) -->
            <div x-data="{ open: false }" class="md:hidden">
                <button @click="open = !open" class="fixed top-4 left-4 z-20 p-2 text-gray-500 bg-white rounded-md shadow-lg focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <!-- Mobile Sidebar -->
                <div x-show="open" class="fixed inset-0 z-10 bg-gray-900 bg-opacity-50">
                    <div class="fixed inset-y-0 left-0 w-64 bg-white">
                        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>

            <!-- Desktop Sidebar -->
            <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
                <div class="flex flex-grow flex-col overflow-y-auto border-r border-gray-200 bg-white pt-5">
                    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <!-- Main Content -->
            <div class="md:pl-64 flex flex-col flex-1">
                <!-- Top Navigation -->
                <div class="sticky top-0 z-10 bg-white shadow-sm">
                    <div class="flex justify-between items-center px-4 py-3 sm:px-6 lg:px-8">
                        <div class="flex items-center">
                            <!-- Empty div to maintain spacing -->
                            <div class="w-8"></div>
                        </div>
                        
                        <div class="flex items-center">
                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" class="ml-3 relative">
                                <div>
                                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                        <span><?php echo e(Auth::user()->name); ?></span>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                    <div class="py-1 rounded-md bg-white shadow-xs">
                                        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="flex-1">
                    <div class="py-6">
                        <?php if(isset($header)): ?>
                            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                                <h1 class="text-2xl font-semibold text-gray-900">
                                    <?php echo e($header); ?>

                                </h1>
                            </div>
                        <?php endif; ?>

                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <?php echo e($slot); ?>

                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\laragon\www\inventaris-smk-sasmita\resources\views/layouts/app.blade.php ENDPATH**/ ?>