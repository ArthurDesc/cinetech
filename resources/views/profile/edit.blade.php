<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white text-center w-full">
            Mon compte
        </h2>
    </x-slot>

    <div class="py-6 flex flex-col items-center min-h-screen">
        <x-magic-card class="w-full max-w-5xl mx-auto px-6 py-8 bg-black shadow-xl ring-1 ring-orange-700/20 rounded-2xl">
            <div class="flex flex-col md:flex-row md:gap-8 w-full" x-data="{ showPassword: false }">
                <!-- Colonne gauche : Profil + Mot de passe dans un seul bloc -->
                <div class="flex-1 flex flex-col justify-between">
                    <!-- Bloc profil -->
                    <div class="pb-6 border-b border-gray-700">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <!-- Bloc mot de passe -->
                    <div class="pt-6">
                        <button type="button" @click="showPassword = !showPassword" class="mb-4 w-full h-[44px] flex items-center justify-center rounded-xl cursor-pointer relative overflow-hidden transition-all duration-500 ease-in-out shadow-lg hover:scale-105 hover:shadow-2xl text-white font-semibold text-base bg-gray-700">
                            {{ 'Modifier le mot de passe' }}
                        </button>
                        <div x-show="showPassword" x-transition class="pt-2">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
                <!-- Colonne droite : Suppression du compte -->
                <div class="w-full md:w-96 flex-shrink-0 mt-10 md:mt-0 md:border-l md:border-gray-700 md:pl-8 flex flex-col justify-start">
                    <div>
                        <div class="border-gray-700 pt-4 mt-2">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </x-magic-card>
    </div>
</x-app-layout>
