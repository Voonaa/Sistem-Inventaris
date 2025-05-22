@props(['title' => null, 'footer' => null, 'headerActions' => null])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @if ($title || $headerActions)
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center border-b border-gray-200">
            @if ($title)
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $title }}
                </h3>
            @endif
            
            @if ($headerActions)
                <div class="flex items-center">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>
    
    @if ($footer)
        <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div> 