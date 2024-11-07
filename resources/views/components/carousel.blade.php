@if (isset($carouselMovies) && count($carouselMovies) > 0)
    <div class="mb-8 relative">
        <div class="splide" id="main-carousel">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($carouselMovies as $movie)
                        <li class="splide__slide">
                            <div class="relative h-[600px]">
                                <img src="{{ $movie['image'] }}" alt="{{ $movie['title'] }}"
                                    class="w-full h-full object-cover rounded-lg">
                                <div
                                    class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent rounded-b-lg">
                                    <h2 class="text-3xl text-white font-bold">{{ $movie['title'] }}</h2>
                                    <p class="text-gray-200 mt-2">{{ \Str::limit($movie['overview'], 150) }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const splideElement = document.getElementById('main-carousel');
                if (splideElement) {
                    new Splide('#main-carousel', {
                        type: 'loop',
                        drag: 'free',
                        focus: 'center',
                        perPage: 1,
                        height: '600px',
                        cover: true,
                        autoScroll: {
                            speed: 1,
                            pauseOnHover: true,
                            pauseOnFocus: true,
                            rewind: false,
                            autoStart: true
                        }
                    }).mount({
                        AutoScroll
                    });
                }
            });
        </script>
    @endpush
@endif
