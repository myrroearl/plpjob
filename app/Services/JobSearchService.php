<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobSearchService
{
    public function search(Request $request): Builder
    {
        $query = Job::query()->with('company')->latest('posted_at');

        // Apply search filters
        $this->applySearchFilters($query, $request);
        
        // Apply additional filters
        $this->applyJobTypeFilter($query, $request);
        $this->applySalaryFilter($query, $request);
        $this->applyLocationFilter($query, $request);
        $this->applyIndustryFilter($query, $request);

        return $query;
    }

    private function applySearchFilters(Builder $query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('job_description', 'like', "%{$search}%")
                  ->orWhereHas('company', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
    }

    private function applyJobTypeFilter(Builder $query, Request $request): void
    {
        if ($request->filled('job_type')) {
            $query->whereIn('job_type', (array) $request->input('job_type'));
        }
    }

    private function applySalaryFilter(Builder $query, Request $request): void
    {
        if ($request->filled('salary_range')) {
            [$min, $max] = explode('-', $request->input('salary_range'));
            $query->where('salary_min', '>=', $min)
                  ->when($max !== '+', function($q) use ($max) {
                      $q->where('salary_max', '<=', $max);
                  });
        }
    }

    private function applyLocationFilter(Builder $query, Request $request): void
    {
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->input('location')}%");
        }
    }

    private function applyIndustryFilter(Builder $query, Request $request): void
    {
        if ($request->filled('industry')) {
            $query->whereIn('industry', (array) $request->input('industry'));
        }
    }
} 