<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-white mb-8">{{ __('Inscription') }}</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div>
                    <x-input-label for="name" :value="__('Nom')" class="text-white" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Adresse e-mail -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-white" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-white" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="text-sm text-gray-300 hover:text-white hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ?') }}
                    </a>

                    <button type="submit" class="ms-4 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __("S'inscrire") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
