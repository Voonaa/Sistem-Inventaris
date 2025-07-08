<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['title' => null, 'footer' => null, 'headerActions' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['title' => null, 'footer' => null, 'headerActions' => null]); ?>
<?php foreach (array_filter((['title' => null, 'footer' => null, 'headerActions' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg'])); ?>>
    <?php if($title || $headerActions): ?>
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
            <?php if($title): ?>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <?php echo e($title); ?>

                </h3>
            <?php endif; ?>
            
            <?php if($headerActions): ?>
                <div class="flex items-center">
                    <?php echo e($headerActions); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="px-4 py-5 sm:p-6">
        <?php echo e($slot); ?>

    </div>
    
    <?php if($footer): ?>
        <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div> <?php /**PATH C:\laragon\www\inventaris-smk-sasmita\resources\views/components/card.blade.php ENDPATH**/ ?>