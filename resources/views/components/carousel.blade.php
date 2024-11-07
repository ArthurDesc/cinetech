<div class="overflow-hidden" x-data="carousel">
    <div class="embla">
        <div class="embla__viewport" x-ref="viewport">
            <div class="embla__container">
                {{ $slot }}
            </div>
        </div>

        {{-- Dots Navigation --}}
        <div class="absolute bottom-4 left-0 right-0">
            <div class="flex justify-center gap-2">
                <template x-for="(_, index) in slides" :key="index">
                    <button
                        @click="scrollTo(index)"
                        class="w-2 h-2 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-white scale-125' : 'bg-white/50'">
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

<style>
.embla {
    position: relative;
}
.embla__viewport {
    overflow: hidden;
}
.embla__container {
    display: flex;
}
.embla__slide {
    flex: 0 0 100%;
    min-width: 0;
}
</style>
