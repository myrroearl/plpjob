<x-app-layout>
    @section('title', $company->name)

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Company Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-8">
                    <div class="flex items-start space-x-6">
                        @if($company->logo)
                            <img src="{{ $company->logo }}" alt="{{ $company->name }}" class="w-24 h-24 object-contain rounded">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-4xl font-bold text-gray-500">{{ substr($company->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $company->name }}</h1>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                @if($company->industry)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $company->industry }}
                                    </div>
                                @endif
                                @if($company->location)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $company->location }}
                                    </div>
                                @endif
                                @if($company->website)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ parse_url($company->website, PHP_URL_HOST) }}
                                        </a>
                                    </div>
                                @endif
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $company->jobs->count() }} open positions
                                </div>
                            </div>
                            @if($company->description)
                                <div class="mt-4 text-gray-600">
                                    {{ $company->description }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Open Positions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Open Positions at {{ $company->name }}</h2>

                    @if($company->jobs->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-600">No open positions available at the moment.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($company->jobs as $job)
                                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow border border-gray-200">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-900">
                                                    <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                                                        {{ $job->title }}
                                                    </a>
                                                </h3>
                                                <div class="mt-4 grid grid-cols-2 gap-4">
                                                    <div class="flex items-center text-gray-600">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        {{ $job->location }}
                                                    </div>
                                                    <div class="flex items-center text-gray-600">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ ucfirst($job->job_type) }}
                                                    </div>
                                                    @if($job->salary_min || $job->salary_max)
                                                        <div class="flex items-center text-gray-600">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml-4 flex flex-col items-end">
                                                <div class="flex items-center space-x-2">
                                                    @if(auth()->user()->savedJobs->contains($job->id))
                                                        <form action="{{ route('jobs.unsave', $job) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('jobs.save', $job) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-gray-400 hover:text-blue-600">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <span class="mt-2 text-sm text-gray-500">
                                                    Posted {{ $job->posted_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
