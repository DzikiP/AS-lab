<x-guest-layout>
    <div class="flex flex-col items-center justify-center text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            System zarządzania hurtownią tapicerską
        </h1>

        <p class="text-gray-600 mb-8 max-w-md">
            Zaloguj się do systemu lub załóż konto
        </p>

        <div class="flex gap-4">
            <a href="{{ route('login') }}">
                <x-primary-button>
                    {{ __('Zaloguj się') }}
                </x-primary-button>
            </a>

            <a href="{{ route('register') }}">
                <x-secondary-button>
                    {{ __('Zarejestruj się') }}
                </x-secondary-button>
            </a>
        </div>
    </div>
</x-guest-layout>
