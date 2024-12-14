<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">

                <!-- Data Cards in Same Row -->
                <div class="flex justify-between space-x-4 mt-6">
                    <!-- Pasien Card (Left) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full">
                        <div class="flex items-center">
                            <!-- Icon -->
                            <div class="w-12 h-12 bg-blue-500 text-black flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18m-9 8h9m-9 4h9m-9 0v-8" />
                                </svg>
                            </div>
                            <!-- Count and Label -->
                            <div class="ml-4 text-black">
                                <h4 class="text-lg font-semibold">Pasien</h4>
                                @if($pasienCount > 0)
                                    <p>{{ $pasienCount }} Pasien</p>
                                @else
                                    <p>No Pasien data available</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dokter Card (Center) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full md:w-1/3">
                        <div class="flex items-center">
                            <!-- Icon -->
                            <div class="w-12 h-12 bg-green-500 text-black flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM5.05 19a7 7 0 0111.9 0" />
                                </svg>
                            </div>
                            <!-- Count and Label -->
                            <div class="ml-4 text-black">
                                <h4 class="text-lg font-semibold">Dokter</h4>
                                @if($dokterCount > 0)
                                    <p>{{ $dokterCount }} Dokter</p>
                                @else
                                    <p>No Dokter data available</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Poliklinik Card (Right) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 w-full md:w-1/3">
                        <div class="flex items-center">
                            <!-- Icon -->
                            <div class="w-12 h-12 bg-red-500 text-black flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m-4-4v8m4-10H8m2-4h4a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2V4a2 2 0 012-2h4z" />
                                </svg>
                            </div>
                            <!-- Count and Label -->
                            <div class="ml-4 text-black">
                                <h4 class="text-lg font-semibold">Poliklinik</h4>
                                @if($poliklinikCount > 0)
                                    <p>{{ $poliklinikCount }} Poliklinik</p>
                                @else
                                    <p>No Poliklinik data available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
