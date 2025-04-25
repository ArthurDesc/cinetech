<x-magic-card class="w-full sm:max-w-md mx-auto mt-6 px-4 py-8 bg-black shadow-2xl ring-2 ring-orange-700/30 rounded-2xl">
    <header>
        <h2 class="text-lg font-bold text-primary-500">
            {{ 'Modifier le mot de passe' }}
        </h2>

        <p class="mt-1 text-sm text-gray-300">
            {{ 'Pour la sécurité de votre compte, utilisez un mot de passe long et aléatoire.' }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="'Mot de passe actuel'" class="text-primary-500" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="'Nouveau mot de passe'" class="text-primary-500" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="'Confirmer le mot de passe'" class="text-primary-500" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="w-[60%] mx-auto h-[50px] flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-lg hover:scale-105 hover:shadow-2xl before:absolute before:top-0 before:-left-full before:w-full before:h-full before:bg-gradient-to-r before:from-orange-700 before:to-orange-600 before:transition-all before:duration-500 before:ease-in-out before:z-[-1] before:rounded-xl hover:before:left-0 text-white font-semibold text-lg bg-gray-700">
                {{ 'Enregistrer' }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-500"
                >{{ 'Enregistré.' }}</p>
            @endif
        </div>
    </form>
</x-magic-card>
