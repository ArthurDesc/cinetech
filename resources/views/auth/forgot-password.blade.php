<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-4 py-8 bg-black shadow-2xl border border-gray-700 rounded-2xl relative mx-2">
            <!-- Header illustré -->
            <div class="flex flex-col items-center mb-4">
                <div class="bg-orange-600 rounded-full p-2 mb-2 shadow-md flex items-center justify-center" style="width:44px;height:44px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-center text-white mb-1">{{ __('Mot de passe oublié ?') }}</h2>
                <p class="text-center text-gray-300 text-sm mt-1 max-w-xs">{{ __('Saisis ton adresse e-mail pour recevoir un lien de réinitialisation de mot de passe.') }}</p>
            </div>
            <div class="border-b border-gray-700 mb-6"></div>
            <!-- Statut de la session -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Adresse e-mail -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" aria-label="Adresse e-mail" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4">
                    <a class="text-sm text-gray-300 hover:text-white hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" href="{{ route('login') }}">
                        {{ __('Retour à la connexion') }}
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-base text-white tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        {{ __('Envoyer le lien de réinitialisation') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
