<x-mail::message>
# New website lead

**Name:** {{ $lead['name'] }}

**Email:** {{ $lead['email'] }}

**Phone:** {{ $phoneDisplay }}

**Website:** {{ $lead['website'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
