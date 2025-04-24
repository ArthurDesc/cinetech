<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <x-magic-card class="relative overflow-hidden rounded-2xl transition-all duration-300 group w-full sm:max-w-md mt-6 px-4 py-8 bg-black shadow-2xl ring-2 ring-orange-700/30 rounded-2xl relative mx-2">
            <!-- Header sécurisé -->
            <div class="flex flex-col items-center mb-4">
                <div class="bg-orange-600 rounded-full p-2 mb-2 shadow-md flex items-center justify-center" style="width:44px;height:44px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-center text-white mb-1">{{ __('Réinitialisation du mot de passe') }}</h2>
                <p class="text-center text-gray-300 text-sm mt-1 max-w-xs">{{ __('Saisis ton adresse e-mail et ton nouveau mot de passe.') }}</p>
            </div>
            <div class="border-b border-gray-700 mb-6"></div>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <!-- Adresse e-mail -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-white" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-white" />
                    <div class="flex items-center relative">
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 pr-10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="password" name="password" required autocomplete="new-password" />
                        <button type="button" aria-label="Afficher ou masquer le mot de passe" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 p-0 m-0 bg-transparent border-0 text-gray-400 focus:outline-none flex items-center justify-center h-6 w-6">
                            <span class="eye-open">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </span>
                            <span class="eye-slash hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirmation du mot de passe -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-white" />
                    <div class="flex items-center relative">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 border border-gray-600 text-white pl-3 pr-10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <button type="button" aria-label="Afficher ou masquer le mot de passe" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 p-0 m-0 bg-transparent border-0 text-gray-400 focus:outline-none flex items-center justify-center h-6 w-6">
                            <span class="eye-open">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </span>
                            <span class="eye-slash hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-[60%] mx-auto h-[50px] my-3 flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-lg hover:scale-105 hover:shadow-2xl before:absolute before:top-0 before:-left-full before:w-full before:h-full before:bg-gradient-to-r before:from-orange-700 before:to-orange-600 before:transition-all before:duration-500 before:ease-in-out before:z-[-1] before:rounded-xl hover:before:left-0 text-white font-semibold text-lg bg-gray-700">
                        {{ __('Réinitialiser le mot de passe') }}
                    </button>
                </div>
                <div class="mt-4 text-center">
                    <a class="text-sm text-gray-300 hover:text-white hover:underline rounded-md" href="{{ route('login') }}">
                        {{ __('Retour à la connexion') }}
                    </a>
                </div>
            </form>
        </x-magic-card>
    </div>
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeSlash = btn.querySelector('.eye-slash');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeSlash.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeSlash.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
