<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center border-l-4 border-teal-500">
                    <div class="p-3 rounded-full bg-teal-100 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total YAKAP Members</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalMembers) }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Gender Demographics</p>
                    <div class="flex justify-between items-end mt-2">
                        <div>
                            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($femaleCount) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Female</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($maleCount) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Male</p>
                        </div>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2 mt-3 flex overflow-hidden">
                        <div class="bg-indigo-500 h-2" style="width: {{ $totalMembers > 0 ? ($femaleCount / $totalMembers) * 100 : 0 }}%"></div>
                        <div class="bg-blue-500 h-2" style="width: {{ $totalMembers > 0 ? ($maleCount / $totalMembers) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Membership Status</p>
                    <div class="flex justify-between items-end mt-2">
                        <div>
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($independentCount) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Primary / Independent</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ number_format($dependentCount) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Dependents</p>
                        </div>
                    </div>
                     <div class="w-full bg-orange-200 rounded-full h-2 mt-3 flex overflow-hidden">
                        <div class="bg-emerald-500 h-2" style="width: {{ $totalMembers > 0 ? ($independentCount / $totalMembers) * 100 : 0 }}%"></div>
                        <div class="bg-orange-500 h-2" style="width: {{ $totalMembers > 0 ? ($dependentCount / $totalMembers) * 100 : 0 }}%"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>