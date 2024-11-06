<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5
    text-gray-300
    hover:bg-dark-lighter
    hover:text-primary-500
    focus:outline-none focus:bg-dark-lighter
    transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
