<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Detail Barang')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="<?php echo e(route('barang.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <?php echo e(__('Kembali')); ?>

                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4"><?php echo e($barang->nama_barang); ?></h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kode Barang</p>
                                        <p class="font-semibold"><?php echo e($barang->kode_barang); ?></p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kategori</p>
                                        <p class="font-semibold"><?php echo e($kategoriLabel); ?></p>
                                    </div>
                                    
                                    <?php if($barang->kategori == 'perpustakaan'): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Sub Kategori</p>
                                        <p class="font-semibold"><?php echo e($subKategoriLabel ?? 'N/A'); ?></p>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Kondisi</p>
                                        <div>
                                            <?php if($barang->kondisi == 'baik'): ?>
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Baik</span>
                                            <?php elseif($barang->kondisi == 'kurang_baik'): ?>
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Kurang Baik</span>
                                            <?php elseif($barang->kondisi == 'rusak'): ?>
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rusak</span>
                                            <?php else: ?>
                                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800"><?php echo e(ucfirst(str_replace('_', ' ', $barang->kondisi))); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Jumlah Total</p>
                                        <p class="font-semibold"><?php echo e($barang->jumlah); ?></p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Jumlah</p>
                                        <p class="font-semibold"><?php echo e($barang->stok); ?></p>
                                    </div>
                                    
                                    <?php if($barang->tahun_perolehan): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Tahun Perolehan</p>
                                        <p class="font-semibold"><?php echo e($barang->tahun_perolehan); ?></p>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if($barang->harga_perolehan): ?>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Harga Perolehan</p>
                                        <p class="font-semibold">Rp <?php echo e(number_format($barang->harga_perolehan, 0, ',', '.')); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if($barang->deskripsi): ?>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Deskripsi</p>
                                <p><?php echo e($barang->deskripsi); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div>
                            <?php if($barang->foto): ?>
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar</p>
                                <img src="<?php echo e(asset('storage/' . $barang->foto)); ?>" alt="<?php echo e($barang->nama_barang); ?>" class="w-full rounded-lg">
                            </div>
                            <?php endif; ?>
                            
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-md font-semibold text-gray-800 mb-2">Informasi Tambahan</h4>
                                
                                <?php if($barang->merek): ?>
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Merek</p>
                                    <p class="font-semibold"><?php echo e($barang->merek); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($barang->model): ?>
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Model</p>
                                    <p class="font-semibold"><?php echo e($barang->model); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($barang->nomor_seri): ?>
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600">Nomor Seri</p>
                                    <p class="font-semibold"><?php echo e($barang->nomor_seri); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($barang->lokasi): ?>
                                <div>
                                    <p class="text-sm text-gray-600">Lokasi</p>
                                    <p class="font-semibold"><?php echo e($barang->lokasi); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($barang->riwayatBarangs->count() > 0): ?>
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Barang</h3>
                        
                        <div class="overflow-x-auto">
                            <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                 <?php $__env->slot('header', null, []); ?> 
                                    <?php if (isset($component)) { $__componentOriginal701475f387ee41fe9c47cd33055131bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal701475f387ee41fe9c47cd33055131bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Aksi <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $attributes = $__attributesOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__attributesOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $component = $__componentOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__componentOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal701475f387ee41fe9c47cd33055131bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal701475f387ee41fe9c47cd33055131bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Jumlah <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $attributes = $__attributesOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__attributesOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $component = $__componentOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__componentOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal701475f387ee41fe9c47cd33055131bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal701475f387ee41fe9c47cd33055131bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Keterangan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $attributes = $__attributesOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__attributesOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $component = $__componentOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__componentOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal701475f387ee41fe9c47cd33055131bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal701475f387ee41fe9c47cd33055131bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>User <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $attributes = $__attributesOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__attributesOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $component = $__componentOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__componentOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal701475f387ee41fe9c47cd33055131bf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal701475f387ee41fe9c47cd33055131bf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.heading','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Tanggal <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $attributes = $__attributesOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__attributesOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal701475f387ee41fe9c47cd33055131bf)): ?>
<?php $component = $__componentOriginal701475f387ee41fe9c47cd33055131bf; ?>
<?php unset($__componentOriginal701475f387ee41fe9c47cd33055131bf); ?>
<?php endif; ?>
                                 <?php $__env->endSlot(); ?>
                                
                                <tbody>
                                    <?php $__currentLoopData = $barang->riwayatBarangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $riwayat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <?php if (isset($component)) { $__componentOriginalc607f3dbbf983abb970b49dd6ee66681 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                                <?php
                                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                                    
                                                    if ($riwayat->jenis_aktivitas === 'tambah') {
                                                        $badgeClass = 'bg-green-100 text-green-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'kurang' || $riwayat->jenis_aktivitas === 'penyesuaian') {
                                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'peminjaman') {
                                                        $badgeClass = 'bg-blue-100 text-blue-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'pengembalian') {
                                                        $badgeClass = 'bg-purple-100 text-purple-800';
                                                    } elseif ($riwayat->jenis_aktivitas === 'perbaikan') {
                                                        $badgeClass = 'bg-orange-100 text-orange-800';
                                                    }
                                                ?>
                                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($badgeClass); ?>">
                                                    <?php echo e(ucfirst($riwayat->jenis_aktivitas)); ?>

                                                </span>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $attributes = $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $component = $__componentOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc607f3dbbf983abb970b49dd6ee66681 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($riwayat->jumlah); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $attributes = $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $component = $__componentOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc607f3dbbf983abb970b49dd6ee66681 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($riwayat->keterangan); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $attributes = $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $component = $__componentOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc607f3dbbf983abb970b49dd6ee66681 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($riwayat->user->name ?? 'N/A'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $attributes = $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $component = $__componentOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalc607f3dbbf983abb970b49dd6ee66681 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($riwayat->created_at->format('d/m/Y H:i')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $attributes = $__attributesOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__attributesOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681)): ?>
<?php $component = $__componentOriginalc607f3dbbf983abb970b49dd6ee66681; ?>
<?php unset($__componentOriginalc607f3dbbf983abb970b49dd6ee66681); ?>
<?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex justify-end mt-6">
                        <a href="<?php echo e(route('barang.edit', $barang->id)); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                            Edit Barang
                        </a>
                        <form action="<?php echo e(route('barang.destroy', $barang->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Hapus Barang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?> <?php /**PATH C:\laragon\www\inventaris-smk-sasmita\resources\views/barang/show.blade.php ENDPATH**/ ?>