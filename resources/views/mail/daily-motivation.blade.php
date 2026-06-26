<x-mail::message>
    # Good morning{{ $subscriber->name && ', ' . $subscriber->name }}!

    > {{ $quote->body }}

    {{ $quote->author && '&mdash ' . $quote->author }}

    Have a wonderful day.

    Thanks,<br />
    {{ config('app.name') }}
</x-mail::message>
