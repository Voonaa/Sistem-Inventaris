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
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col justify-center items-center">
            <div class="w-full max-w-[480px] bg-white rounded-lg shadow-md p-8 mx-4">
                <?php echo e($slot); ?>

            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\laragon\www\inventaris-smk-sasmita\resources\views/layouts/guest.blade.php ENDPATH**/ ?>