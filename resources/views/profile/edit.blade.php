<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-primary-500 text-center w-full">
            Mon profil
        </h2>
    </x-slot>

    <div class="py-6 flex flex-col items-center min-h-screen">
        <x-magic-card class="w-full max-w-5xl mx-auto px-10 py-8 bg-black shadow-xl ring-1 ring-orange-700/20 rounded-2xl">
            <div class="flex flex-col md:flex-row md:divide-x md:divide-gray-600/40 w-full">
                <div class="flex-1 flex flex-col px-0 md:px-8 pb-8 md:pb-0">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="flex-1 flex flex-col px-0 md:px-8 pb-8 md:pb-0">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="flex-1 flex flex-col px-0 md:px-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </x-magic-card>
    </div>
</x-app-layout>
