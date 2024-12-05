@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-primary-500 text-primary-500 bg-dark-lighter focus:outline-none transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-white hover:text-primary-500 hover:border-primary-400 hover:bg-dark-lighter focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
