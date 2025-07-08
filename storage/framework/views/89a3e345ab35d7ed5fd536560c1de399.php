<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['headers' => [], 'striped' => true, 'hover' => true]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['headers' => [], 'striped' => true, 'hover' => true]); ?>
<?php foreach (array_filter((['headers' => [], 'striped' => true, 'hover' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <?php if(count($headers) > 0): ?>
                        <thead class="bg-gray-50">
                            <tr>
                                <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <?php echo e($header); ?>

                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                    <?php endif; ?>
                    
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php echo e($slot); ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('70fee326-97f8-4bb2-a6c7-5398459ba58d')): $__env->markAsRenderedOnce('70fee326-97f8-4bb2-a6c7-5398459ba58d'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Add any JavaScript for table sorting, filtering, etc. here
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\inventaris-smk-sasmita\resources\views/components/table.blade.php ENDPATH**/ ?>