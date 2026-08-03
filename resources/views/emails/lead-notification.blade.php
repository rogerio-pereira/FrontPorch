<x-mail::message>
# New website lead

**Name:** {{ $lead['name'] }}

**Email:** {{ $lead['email'] }}

**Phone:** @if ($lead['phone']){{ $lead['phone'] }}@else (not provided) @endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
