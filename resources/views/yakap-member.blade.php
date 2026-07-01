<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('YAKAP Members') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-teal-700 dark:text-teal-400">YAKAP MEMBER-LIST</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Refine directory listings using the specific name filters below.</p>
                </div>

                <form method="GET" action="{{ url('/yakap-member') }}" class="w-full grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-6 p-4 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700">
                    
                    <div>
                        <label for="last_name" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Last Name</label>
                        <input 
                            type="text" 
                            id="last_name"
                            name="last_name" 
                            value="{{ $lastName ?? '' }}"
                            placeholder="e.g., Dela Cruz" 
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 rounded-md shadow-sm text-sm"
                        >
                    </div>

                    <div>
                        <label for="first_name" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">First Name</label>
                        <input 
                            type="text" 
                            id="first_name"
                            name="first_name" 
                            value="{{ $firstName ?? '' }}"
                            placeholder="e.g., Juan" 
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 rounded-md shadow-sm text-sm"
                        >
                    </div>

                    <div>
                        <label for="suffix" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase mb-1">Suffix</label>
                        <select 
                            id="suffix"
                            name="suffix" 
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 rounded-md shadow-sm text-sm"
                        >
                            <option value="">All / Any</option>
                            <option value="none" {{ ($suffix ?? '') === 'none' ? 'selected' : '' }}>None (No Suffix)</option>
                            <option value="JR" {{ ($suffix ?? '') === 'Jr' ? 'selected' : '' }}>JR</option>
                            <option value="Sr." {{ ($suffix ?? '') === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                            <option value="II" {{ ($suffix ?? '') === 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ ($suffix ?? '') === 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ ($suffix ?? '') === 'IV' ? 'selected' : '' }}>IV</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm h-[42px]">
                            Apply Filter
                        </button>

                        @if(!empty($lastName) || !empty($firstName) || !empty($suffix))
                            <a href="{{ url('/yakap-member') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 px-1 whitespace-nowrap">
                                Clear All
                            </a>
                        @endif
                    </div>
                </form>

                <div class="relative overflow-x-auto max-h-[500px] overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-xl shadow-inner custom-scrollbar">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 whitespace-nowrap border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-700 uppercase dark:text-gray-300">
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">Patient ID</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">PIN</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">Full Name</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10 text-center">Sex</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">Member Type</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">Contact No.</th>
                                <th scope="col" class="sticky top-0 bg-gray-50 dark:bg-gray-700 px-6 py-4 shadow-[inset_0_-2px_0_rgba(0,0,0,0.05)] z-10">Reg. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50/80 dark:hover:bg-gray-700/80 transition">
                                    <td class="px-6 py-3.5 font-medium text-gray-900 dark:text-white">
                                        {{ $patient->patient_id }}
                                    </td>
                                    <td class="px-6 py-3.5">{{ $patient->pin }}</td>
                                    <td class="px-6 py-3.5 font-bold text-teal-800 dark:text-teal-400">
                                        {{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->suffix }}
                                    </td>
                                    <td class="px-6 py-3.5 text-center">
                                        @if($patient->sex === 'M')
                                            <img src="{{ asset('images/male.png') }}" alt="Male" class="h-6 w-6 mx-auto object-contain" title="Male">
                                        @elseif($patient->sex === 'F')
                                            <img src="{{ asset('images/female.png') }}" alt="Female" class="h-6 w-6 mx-auto object-contain" title="Female">
                                        @else
                                            <span class="text-xs text-gray-400">{{ $patient->sex ?: '—' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3.5">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $patient->member_type === 'DEPENDENT' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200' }}">
                                            {{ $patient->member_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5">{{ $patient->contact_no ?: '—' }}</td>
                                    <td class="px-6 py-3.5">{{ $patient->registration_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>No matching patient records found matching criteria.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($patients, 'links'))
                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>