<x-app-layout>
    @section('title', 'Feedback')
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Help Future Alumni!</h1>
                <p class="text-xl text-gray-600">Your feedback shapes the future of our platform and helps fellow graduates succeed</p>
            </div>

            @if (session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('feedback.store') }}" method="POST" class="space-y-8" id="feedbackForm">
                        @csrf
                        
                        @if($latestFeedback)
                            <input type="hidden" name="feedback_id" value="{{ $latestFeedback->id }}">
                        @endif

                        <!-- Progress Indicator -->
                        <div class="relative">
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-100">
                                <div class="progress-bar-animate shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                            </div>
                        </div>

                        <!-- Employment Status Section -->
                        <div class="bg-gray-50 rounded-xl p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Employment Status <span class="text-red-500 text-sm font-normal">* Required</span></h2>
                            <div class="space-y-4">
                                @foreach(['yes' => 'Yes, I got hired through this platform', 
                                         'no' => 'No, still looking for opportunities',
                                         'other' => 'Found employment elsewhere'] as $value => $label)
                                    <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 cursor-pointer hover:bg-blue-50 hover:border-blue-200 transition-all">
                                        <input type="radio" name="employment_status" value="{{ $value }}" 
                                               {{ ($latestFeedback && $latestFeedback->employment_status == $value) ? 'checked' : '' }}
                                               class="form-input h-5 w-5 text-blue-600">
                                        <span class="ml-3 text-lg text-gray-900">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Employment Details Section -->
                        <div class="bg-gray-50 rounded-xl p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Employment Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="company_name" class="block text-lg font-medium text-gray-700 mb-2">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" 
                                           value="{{ old('company_name', $latestFeedback?->company_name) }}"
                                           class="form-input w-full">
                                </div>
                                <div>
                                    <label for="position" class="block text-lg font-medium text-gray-700 mb-2">Position</label>
                                    <input type="text" name="position" id="position" 
                                           value="{{ old('position', $latestFeedback?->position) }}"
                                           class="form-input w-full">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="employment_duration" class="block text-lg font-medium text-gray-700 mb-2">Employment Duration</label>
                                    <select name="employment_duration" id="employment_duration" 
                                            class="w-full text-lg rounded-lg border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('employment_duration') border-red-300 @enderror">
                                        <option value="">Select duration</option>
                                        @foreach(['less_than_3' => 'Less than 3 months',
                                                '3_to_6' => '3-6 months',
                                                '6_to_12' => '6-12 months',
                                                'more_than_12' => 'More than 12 months'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('employment_duration') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employment_duration')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Details Section -->
                        <div class="bg-gray-50 rounded-xl p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Your Feedback</h2>
                            <div class="space-y-8">
                                <div>
                                    <label for="improvements" class="block text-lg font-medium text-gray-700 mb-2">What could we improve?</label>
                                    <textarea name="improvements" id="improvements" rows="4" 
                                              class="w-full text-lg rounded-lg border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('improvements') border-red-300 @enderror"
                                              placeholder="Share your suggestions for improvement...">{{ old('improvements', $latestFeedback?->improvements) }}</textarea>
                                    @error('improvements')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="additional_comments" class="block text-lg font-medium text-gray-700 mb-2">Additional Comments</label>
                                    <textarea name="additional_comments" id="additional_comments" rows="4" 
                                              class="w-full text-lg rounded-lg border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('additional_comments') border-red-300 @enderror"
                                              placeholder="Any other thoughts you'd like to share...">{{ old('additional_comments', $latestFeedback?->additional_comments) }}</textarea>
                                    @error('additional_comments')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" id="submitButton"
                                    class="px-12 py-4 bg-blue-600 text-white text-xl font-semibold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg hover:shadow-xl">
                                {{ $latestFeedback ? 'Submit Feedback Changes' : 'Submit Feedback' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thank You Message -->
            <div class="mt-12 text-center text-gray-600">
                <p class="text-lg">Thank you for taking the time to help improve our platform!</p>
            </div>
        </div>
    </div>

    <!-- Add custom styles -->
    <style>
        .progress-bar-animate {
            width: 100%;
            animation: progress 1s ease-in-out;
        }

        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        /* Custom radio button styles */
        input[type="radio"]:checked + span {
            color: #2563eb;
        }

        /* Enhanced focus styles */
        .focus-ring {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }
    </style>

    <!-- Add this script section at the bottom of your blade file -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('feedbackForm');
            const submitButton = document.getElementById('submitButton');
            const originalButtonText = submitButton.textContent;
            let hasChanges = false;

            // Function to check if form has been modified
            function checkFormChanges() {
                const formData = new FormData(form);
                const currentValues = Object.fromEntries(formData.entries());
                
                // Compare with original values
                @if($latestFeedback)
                    const originalValues = {
                        employment_status: '{{ $latestFeedback->employment_status }}',
                        company_name: '{{ $latestFeedback->company_name }}',
                        position: '{{ $latestFeedback->position }}',
                        employment_duration: '{{ $latestFeedback->employment_duration }}',
                        improvements: '{{ $latestFeedback->improvements }}',
                        additional_comments: '{{ $latestFeedback->additional_comments }}'
                    };

                    hasChanges = Object.keys(currentValues).some(key => 
                        currentValues[key] !== originalValues[key]
                    );
                @else
                    hasChanges = Object.values(currentValues).some(value => value !== '');
                @endif

                submitButton.textContent = hasChanges ? 'Submit Feedback Changes' : 'Submit Feedback';
            }

            // Add event listeners to all form inputs
            form.querySelectorAll('input, textarea, select').forEach(input => {
                input.addEventListener('input', checkFormChanges);
                input.addEventListener('change', checkFormChanges);
            });
        });
    </script>
</x-app-layout>
