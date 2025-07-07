<x-app-layout>
    @section('title', 'Welcome')

    <!-- Hero Section -->
    <div class="bg-[#0e2b6b] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-8">Find Your Dream Job</h1>
                <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 max-w-4xl mx-auto">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Job title, keywords, or company" 
                               class="w-full rounded-lg border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400">
                    </div>
                    <div class="flex-1">
                        <input type="text" name="location" value="{{ request('location') }}" 
                               placeholder="Location" 
                               class="w-full rounded-lg border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-400">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Search Jobs
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($statistics['total_jobs']) }}</div>
                    <div class="text-gray-600">Total Jobs</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($statistics['total_companies']) }}</div>
                    <div class="text-gray-600">Partner Companies</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($statistics['jobs_this_month']) }}</div>
                    <div class="text-gray-600">New Jobs This Month</div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Featured Jobs Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Featured Job Opportunities</h2>
                <p class="mt-4 text-lg text-gray-600">Discover the latest job openings from top companies</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredJobs as $job)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
                        <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $job->title }}
                                    </h3>
                                    <p class="text-blue-600">{{ $job->company->name }}</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $job->location }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ ucfirst($job->job_type) }}
                                </div>
                                @if($job->salary_min || $job->salary_max)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    View All Jobs
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Industries Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Popular Industries</h2>
                <p class="mt-4 text-lg text-gray-600">Explore opportunities across various sectors</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($topIndustries as $industry)
                    <a href="{{ route('jobs.index', ['industry' => $industry->industry]) }}" 
                       class="group bg-gray-50 rounded-lg p-6 text-center hover:bg-blue-50 transition-colors">
                        <div class="text-2xl font-bold text-blue-600 mb-2">{{ $industry->job_count }}</div>
                        <div class="text-gray-900 group-hover:text-blue-600">{{ $industry->industry }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Companies Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Featured Companies</h2>
                <p class="mt-4 text-lg text-gray-600">Top employers looking for talent like you</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredCompanies as $company)
                    <a href="{{ route('companies.show', $company) }}" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
                        <div class="flex items-center justify-center mb-4">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->name }}" class="h-16 w-16 object-contain">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-gray-500">{{ substr($company->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600">{{ $company->name }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ $company->jobs_count }} open positions</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('companies.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 border-blue-600">
                    View All Companies
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>