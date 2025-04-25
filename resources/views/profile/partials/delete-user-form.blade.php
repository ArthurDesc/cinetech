<div>
    <header>
        <h2 class="text-lg font-bold text-primary-500">
            {{ 'Supprimer le compte' }}
        </h2>
        <p class="mt-1 mb-4 text-sm text-gray-300">
            {{ 'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.' }}
        </p>
    </header>
    <div class="flex justify-center">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="w-[70%] h-[50px] flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-lg hover:scale-105 hover:shadow-2xl text-white font-semibold text-lg"
        >{{ 'SUPPRIMER LE COMPTE' }}</x-danger-button>
    </div>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            <h2 class="text-lg font-bold text-primary-500">
                {{ 'Êtes-vous sûr de vouloir supprimer votre compte ?' }}
            </h2>
            <p class="mt-1 text-sm text-gray-300">
                {{ 'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer la suppression définitive de votre compte.' }}
            </p>
            <div class="mt-6">
                <x-input-label for="password" value="{{ 'Mot de passe' }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-gray-700 border border-gray-600 text-white pl-3 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="{{ 'Mot de passe' }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ 'Annuler' }}
                </x-secondary-button>
                <x-danger-button class="ms-3">
                    {{ 'Supprimer le compte' }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
