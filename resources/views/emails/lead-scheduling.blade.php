<x-mail::message>
# Thanks for reaching out, {{ $lead['name'] }}

We received your message and would love to talk.

Use the button below to pick a time for your discovery call.

<x-mail::button :url="$calendarUrl">
Book a discovery call
</x-mail::button>

If the button does not work, open this link in your browser:<br>
[{{ $calendarUrl }}]({{ $calendarUrl }})

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
