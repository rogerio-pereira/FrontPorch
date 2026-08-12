<x-mail::message>
# New website lead

**Name:** {{ $lead['name'] }}

**Email:** {{ $lead['email'] }}

**Services:** {{ $lead['services'] }}

**Website:** {{ $websiteDisplay }}

**Phone:** {{ $phoneDisplay }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
