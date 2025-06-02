<x-mail::message>
# 📈 Significant Price Change Alert

The following coins have experienced a price change of over **{{ $sensitivity * 100 }}%** in the last 24 hours:

@foreach($coins as $index => $coin)
{{ $index + 1 }}. **{{ $coin->name }}** ({{ $coin->symbol }}) — ID: {{ $coin->remote_id }}
@endforeach

<x-mail::button :url="{{ $url }}">
Check your portfolios
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
