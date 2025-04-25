<div>
    <header>
        <h2 class="text-lg font-bold text-primary-500">
            {{ __('Informations du profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-300">
            {{ "Mettez à jour les informations de votre compte et votre adresse e-mail." }}
        </p>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="nickname" :value="'Pseudo'" class="text-primary-500" />
            <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" :value="old('nickname', $user->nickname)" required autofocus autocomplete="nickname" />
            <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
        </div>
        <div>
            <x-input-label for="email" :value="'Email'" class="text-primary-500" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-orange-400">
                        {{ "Votre adresse e-mail n'est pas vérifiée." }}
                        <button form="send-verification" class="underline text-sm text-primary-500 hover:text-primary-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ "Cliquez ici pour renvoyer l'e-mail de vérification." }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-500">
                            {{ "Un nouveau lien de vérification a été envoyé à votre adresse e-mail." }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button class="w-[60%] mx-auto h-[50px] flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-lg hover:scale-105 hover:shadow-2xl before:absolute before:top-0 before:-left-full before:w-full before:h-full before:bg-gradient-to-r before:from-orange-700 before:to-orange-600 before:transition-all before:duration-500 before:ease-in-out before:z-[-1] before:rounded-xl hover:before:left-0 text-white font-semibold text-lg bg-gray-700">
                {{ 'Enregistrer' }}
            </x-primary-button>
            @if (session('status') === 'profile-updated')
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
</div>
