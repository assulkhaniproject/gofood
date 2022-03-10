@if (filled($brand = config('filament.brand')))
    <div @class([
        'text-xl font-bold tracking-tight filament-brand',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        {{-- {{ $brand }} --}}
        <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="h-8">
    </div>
@endif
