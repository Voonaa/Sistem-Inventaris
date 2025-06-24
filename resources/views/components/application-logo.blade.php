@props(['size' => 'normal'])

@php
    $sizeClasses = [
        'small' => [
            'container' => 'h-16',
            'logo' => 'h-12 w-12',
            'text' => [
                'smk' => 'text-xl',
                'sasmita' => 'text-lg'
            ]
        ],
        'normal' => [
            'container' => 'h-20',
            'logo' => 'h-16 w-16',
            'text' => [
                'smk' => 'text-2xl',
                'sasmita' => 'text-xl'
            ]
        ],
        'large' => [
            'container' => 'h-24',
            'logo' => 'h-20 w-20',
            'text' => [
                'smk' => 'text-3xl',
                'sasmita' => 'text-2xl'
            ]
        ]
    ][$size];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center ' . $sizeClasses['container']]) }}>
    <div class="flex items-center space-x-3">
        <img src="{{ asset('assets/images/logosmk.png') }}" alt="SMK Sasmita Jaya 2 Logo" class="{{ $sizeClasses['logo'] }} object-contain">
        <div class="flex flex-col">
            <span class="{{ $sizeClasses['text']['smk'] }} font-bold text-blue-600">SMK</span>
            <span class="{{ $sizeClasses['text']['sasmita'] }} font-semibold text-gray-800">SASMITA JAYA 2</span>
        </div>
    </div>
</div>
