<x-app-layout>
    @section('title', 'Browse Jobs')
    
    <!-- Hero Search Section -->
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

    <!-- Main Content -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="font-semibold text-lg mb-4">Filters</h3>
                        <form action="{{ route('jobs.index') }}" method="GET" class="space-y-6">
                            <!-- Preserve search query -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="location" value="{{ request('location') }}">
                            
                            <!-- Job Type -->
                            <div>
                                <label class="font-medium text-gray-700 block mb-2">Job Type</label>
                                <div class="space-y-2">
                                    @foreach(['full-time', 'part-time', 'contract', 'internship'] as $type)
                                        <label class="flex items-center">
                                            <input type="checkbox" name="types[]" value="{{ $type }}"
                                                   {{ in_array($type, request('types', [])) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-gray-700 capitalize">{{ $type }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            

                            <!-- Industry -->
                            <div>
                                <label class="font-medium text-gray-700 block mb-2">Industry</label>
                                <select name="industry" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">All Industries</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry }}" {{ request('industry') == $industry ? 'selected' : '' }}>
                                            {{ $industry }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Salary Range -->
                            <div>
                                <label class="font-medium text-gray-700 block mb-2">Salary Range</label>
                                <div class="flex gap-2">
                                    <input type="number" name="salary_min" value="{{ request('salary_min') }}" 
                                           placeholder="Min" 
                                           class="w-1/2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <input type="number" name="salary_max" value="{{ request('salary_max') }}" 
                                           placeholder="Max" 
                                           class="w-1/2 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                            </div>

                            <!-- Sort By -->
                            <div>
                                <label class="font-medium text-gray-700 block mb-2">Sort By</label>
                                <select name="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="salary_high" {{ request('sort') == 'salary_high' ? 'selected' : '' }}>Highest Salary</option>
                                    <option value="salary_low" {{ request('sort') == 'salary_low' ? 'selected' : '' }}>Lowest Salary</option>
                                    <option value="relevant" {{ request('sort') == 'relevant' ? 'selected' : '' }}>Most Relevant</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Job Listings -->
                <div class="lg:w-3/4">
                    @if($jobs->isEmpty())
                        <div class="bg-white rounded-lg shadow p-6 text-center">
                            <img src="https://illustrations.popsy.co/gray/question-mark.svg" alt="No results" class="w-48 h-48 mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No jobs found</h3>
                            <p class="text-gray-600">Try adjusting your search criteria or filters</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($jobs as $job)
                                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-900">
                                                    <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600">
                                                        {{ $job->title }}
                                                    </a>
                                                </h3>
                                                <div class="mt-1">
                                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">{{ $job->company->name }}</a>
                                                </div>
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
                                                    <div class="flex items-center text-gray-600">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                                        </svg>
                                                        {{ $job->industry }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex flex-col items-end">
                                                <div class="flex items-center space-x-2">
                                                    @if(auth()->user()->savedJobs->contains($job->id))
                                                        <form action="{{ route('jobs.unsave', $job) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-blue-600 hover:text-blue-700">
                                                                <svg class="w-6 h-6" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
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

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>