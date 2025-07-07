<x-app-layout>
    @section('title', $job->title)

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">{{ $job->title }}</h1>
                        <div class="flex items-center space-x-4 text-gray-600">
                            <p>{{ $job->company->name }}</p>
                            <p>{{ $job->location }}</p>
                            <p>{{ $job->job_type }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-2">
                            <div class="prose max-w-none">
                                <h2 class="text-xl font-semibold mb-4">Job Description</h2>
                                <div class="mb-6">
                                    {!! nl2br(e($job->job_description)) !!}
                                </div>

                                @if($job->responsibilities)
                                    <h2 class="text-xl font-semibold mb-4">Responsibilities</h2>
                                    <div class="mb-6">
                                        {!! nl2br(e($job->responsibilities)) !!}
                                    </div>
                                @endif

                                @if($job->qualifications)
                                    <h2 class="text-xl font-semibold mb-4">Qualifications</h2>
                                    <div class="mb-6">
                                        {!! nl2br(e($job->qualifications)) !!}
                                    </div>
                                @endif

                                @if($job->benefits)
                                    <h2 class="text-xl font-semibold mb-4">Benefits</h2>
                                    <div class="mb-6">
                                        {!! nl2br(e($job->benefits)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h2 class="text-xl font-semibold mb-4">Job Details</h2>
                                <div class="space-y-4">
                                    @if($job->salary_min || $job->salary_max)
                                        <div>
                                            <h3 class="font-medium">Salary Range</h3>
                                            <p>{{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}</p>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-medium">Industry</h3>
                                        <p>{{ $job->industry }}</p>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Posted</h3>
                                        <p>{{ $job->posted_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    @if($job->application_link)
                                        <a href="{{ $job->application_link }}" target="_blank" 
                                           class="block w-full bg-blue-500 text-white text-center py-2 px-4 rounded-md hover:bg-blue-600">
                                            Apply Now
                                        </a>
                                    @endif

                                    @if(auth()->user()->savedJobs->contains($job->id))
                                        <form action="{{ route('jobs.unsave', $job) }}" method="POST" class="mt-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-500 text-white text-center py-2 px-4 rounded-md hover:bg-red-600">
                                                Remove from Saved Jobs
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('jobs.save', $job) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="w-full bg-gray-500 text-white text-center py-2 px-4 rounded-md hover:bg-gray-600">
                                                Save Job
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            @if($similarJobs->isNotEmpty())
                                <div class="mt-6">
                                    <h2 class="text-xl font-semibold mb-4">Similar Jobs</h2>
                                    <div class="space-y-4">
                                        @foreach($similarJobs as $similarJob)
                                            <div class="border rounded-lg p-4">
                                                <h3 class="font-medium">
                                                    <a href="{{ route('jobs.show', $similarJob) }}" class="text-blue-600 hover:text-blue-800">
                                                        {{ $similarJob->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-gray-600">{{ $similarJob->company->name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 