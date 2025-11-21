@props(['headers' => []])

<div class="overflow-x-auto bg-cream-50 rounded-lg shadow-lg border border-cream-200">
    <table class="min-w-full divide-y divide-cream-300">
        @if(!empty($headers))
        <thead class="bg-dark-red">
            <tr>
                @foreach($headers as $header)
                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                    {{ $header }}
                </th>
                @endforeach
            </tr>
        </thead>
        @endif
        
        <tbody class="bg-cream-50 divide-y divide-cream-200">
            {{ $slot }}
        </tbody>
    </table>
</div>

<style>
.bg-cream-50 { background-color: #fefdf8; }
.bg-cream-200 { background-color: #f5f2e8; }
.border-cream-200 { border-color: #f5f2e8; }
.divide-cream-200 > :not([hidden]) ~ :not([hidden]) { border-color: #f5f2e8; }
.divide-cream-300 > :not([hidden]) ~ :not([hidden]) { border-color: #e8e2d4; }
.bg-dark-red { background-color: #7f1d1d; }
</style>