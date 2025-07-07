<x-app-layout>
    @section('title', 'Dashboard')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->

            <h1 style="font-size: 1.8rem" class="font-bold text-black-500">Hello, {{ auth()->user()->first_name }}!</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Saved Jobs Card -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <a href="{{ route('saved-jobs.index') }}" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Saved Jobs</p>
                                <p class="text-3xl font-bold text-blue-600 mt-1">{{ auth()->user()->savedJobs()->count() }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Notifications Card -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <a href="{{ route('notifications.index') }}" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">New Notifications</p>
                                <p class="text-3xl font-bold text-purple-600 mt-1">{{ auth()->user()->unreadNotifications()->count() }}</p>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recommended Jobs Section -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Recommended Jobs</h3>
                            <span class="text-sm text-gray-500">Based on your profile</span>
                        </div>
                        
                        @if($recommendedJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($recommendedJobs as $job)
                                    <div class="group border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors duration-200">
                                        <a href="{{ route('jobs.show', $job) }}" class="block">
                                            <div class="flex justify-between items-start">
                                                <div class="space-y-1">
                                                    <h4 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">{{ $job->title }}</h4>
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-sm text-gray-600">{{ $job->company->name }}</span>
                                                        <span class="text-gray-400">•</span>
                                                        <span class="text-sm text-gray-600">{{ $job->location }}</span>
                                                    </div>
                                                </div>
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
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $job->job_type }}
                                                </span>
                                                @if($job->salary_min && $job->salary_max)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-4 text-gray-500">No recommended jobs available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Latest Jobs Section -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Latest Jobs</h3>
                            <a href="{{ route('jobs.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
                        </div>
                        
                        @if($latestJobs->count() > 0)
                            <div class="space-y-4">
                                @foreach($latestJobs as $job)
                                    <div class="group border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors duration-200">
                                        <a href="{{ route('jobs.show', $job) }}" class="block">
                                            <div class="flex justify-between items-start">
                                                <div class="space-y-1">
                                                    <h4 class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">{{ $job->title }}</h4>
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-sm text-gray-600">{{ $job->company->name }}</span>
                                                        <span class="text-gray-400">•</span>
                                                        <span class="text-sm text-gray-600">{{ $job->location }}</span>
                                                    </div>
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    {{ $job->posted_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $job->job_type }}
                                                </span>
                                                @if($job->salary_min && $job->salary_max)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                                    </span>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="mt-4 text-gray-500">No jobs available at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 