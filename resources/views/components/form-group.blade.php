@props(['label', 'for', 'error' => false, 'helpText' => null, 'required' => false])

<div class="mb-4">
    <label for="{{ $for }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="mt-1">
        {{ $slot }}
    </div>
    
    @if($helpText)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
    
    @error($for)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @if($error && is_string($error))
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif
</div> 