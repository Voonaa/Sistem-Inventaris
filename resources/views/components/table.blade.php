@props(['headers' => [], 'striped' => true, 'hover' => true])

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    @if (count($headers) > 0)
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach ($headers as $header)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                    @endif
                    
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        // Add any JavaScript for table sorting, filtering, etc. here
    </script>
    @endpush
@endonce 