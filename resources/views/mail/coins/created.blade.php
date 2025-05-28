<x-mail::message>
# 🚀 New Coin Added!

We're excited to let you know that a new coin has just been added to the platform:

## {{ $name }}

<x-mail::button :url="$url">
View Coin Details
</x-mail::button>

If you have any questions or feedback, feel free to reach out.

Thanks for staying with us!
— {{ config('app.name') }}
</x-mail::message>
