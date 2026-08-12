<x-mail::message>
# New website lead

**Name:** {{ $lead['name'] }}

**Email:** {{ $lead['email'] }}

**Phone:** {{ $phoneDisplay }}

**Website:** {{ $websiteDisplay }}

**Services:** {{ $lead['services'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
