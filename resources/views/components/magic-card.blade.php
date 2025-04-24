<div
    {{ $attributes->merge([
        'class' => 'relative overflow-hidden rounded-2xl transition-all duration-300 group'
    ]) }}
    tabindex="0"
    x-data="{ x: -9999, y: -9999 }"
    @mousemove="
        const rect = $el.getBoundingClientRect();
        x = $event.clientX - rect.left;
        y = $event.clientY - rect.top;
    "
    @mouseleave="x = -9999; y = -9999"
>
    <!-- Spotlight effect only -->
    <div
        class="pointer-events-none absolute inset-0 z-0 transition-all duration-300"
        :style="`background: radial-gradient(300px circle at ${x}px ${y}px, rgba(255,140,0,0.18), transparent 80%)`"
    ></div>
    <!-- Slot content -->
    <div class="relative z-20">
        {{ $slot }}
    </div>
</div> 