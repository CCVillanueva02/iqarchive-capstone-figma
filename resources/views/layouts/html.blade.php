@props([
    'title' => null,
    'htmlClass' => null,
    'bodyClass' => null,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($htmlClass) class="{{ $htmlClass }}" @endif>
    <head>
        @include('partials.head', ['title' => $title])
    </head>
    <body @if($bodyClass) class="{{ $bodyClass }}" @endif>
        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
