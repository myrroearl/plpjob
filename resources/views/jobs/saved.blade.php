<x-app-layout>
    @section('title', 'Saved Jobs')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-4">Saved Jobs</h2>

                    @if($savedJobs->isEmpty())
                        <p class="text-gray-600">You haven't saved any jobs yet.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($savedJobs as $job)
                                <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-semibold">
                                                <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600">{{ $job->company->name }}</p>
                                            <div class="mt-2 space-y-2">
                                                <p class="text-gray-600">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                                </p>
                                                <p class="text-gray-600">
                                                    <i class="fas fa-clock"></i> {{ $job->job_type }}
                                                </p>
                                                @if($job->salary_min || $job->salary_max)
                                                    <p class="text-gray-600">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                        {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }} {{ $job->currency }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('jobs.unsave', $job) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-heart"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-gray-600">
                                            Saved {{ $job->pivot->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $savedJobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 