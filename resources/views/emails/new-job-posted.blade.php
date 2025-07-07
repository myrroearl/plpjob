<x-mail::message>
# New Job Opportunity!

A new job has been posted that might interest you:

**Position:** {{ $job->title }}
**Company:** {{ $job->company->name }}
**Location:** {{ $job->location }}
**Job Type:** {{ $job->job_type }}

## Job Description
{{ $job->job_description }}

<x-mail::button :url="route('jobs.show', $job)">
View Job Details
</x-mail::button>

Good luck!<br>
{{ config('app.name') }}
</x-mail::message> 