<x-filament-panels::page>
@foreach($this->getHistory() as $history)
    <p>Changed at: {{ $history->created_at }}</p>

    @foreach($history->changes as $field => [$old, $new])
        <li>{{ $field }}: {{ $old }} →  {{ $new }}</li>
    @endforeach
    <br>
@endforeach
</x-filament-panels::page>
