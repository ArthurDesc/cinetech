<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-4 py-8 bg-gray-800 shadow-2xl border border-gray-700 rounded-2xl relative mx-2">
            <!-- Header sécurisé -->
            <div class="flex flex-col items-center mb-4">
                <div class="bg-orange-600 rounded-full p-2 mb-2 shadow-md flex items-center justify-center" style="width:44px;height:44px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-center text-white mb-1">{{ __('Inscription') }}</h2>
                <p class="text-center text-gray-300 text-sm mt-1">Crée ton compte pour accéder à toutes les fonctionnalités.</p>
            </div>
            <div class="border-b border-gray-700 mb-6"></div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Nom')" class="text-white" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Adresse e-mail -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" class="text-white" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-white" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4">
                    <a class="text-sm text-gray-300 hover:text-white hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ?') }}
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-base text-white tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        {{ __("S'inscrire") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
