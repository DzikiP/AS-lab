<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Strona główna
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Jesteś zalogowany</h1>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md 
                                font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 
                                focus:ring-offset-2 focus:ring-blue-500">
                            Przejdź do tabeli
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
