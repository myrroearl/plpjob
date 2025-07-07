<x-app-layout>
    @section('title', 'Profile')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Profile Settings</h2>
                        <p class="mt-1 text-sm text-gray-600">Update your account's profile information.</p>
                    </div>

                    @if(session('status'))
                        <div class="mb-8 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Card -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- First Name -->
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            First Name
                                        </label>
                                        <input type="text" name="first_name" id="first_name" 
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed"
                                            value="{{ old('first_name', auth()->user()->first_name) }}" 
                                            readonly>
                                    </div>

                                    <!-- Middle Name -->
                                    <div>
                                        <label for="middle_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Middle Name
                                        </label>
                                        <input type="text" name="middle_name" id="middle_name" 
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed"
                                            value="{{ old('middle_name', auth()->user()->middle_name) }}" 
                                            readonly>
                                    </div>

                                    <!-- Last Name -->
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Last Name
                                        </label>
                                        <input type="text" name="last_name" id="last_name" 
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed"
                                            value="{{ old('last_name', auth()->user()->last_name) }}" 
                                            readonly>
                                    </div>
                                </div>

                                <!-- Email and Age -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address
                                        </label>
                                        <input type="email" name="email" id="email" 
                                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            readonly>
                                    </div>

                                    <div>
                                        <label for="age" class="block text-sm font-medium text-gray-700 mb-2">
                                            Age
                                        </label>
                                        <input type="number" name="age" id="age" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 
                                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                                hover:border-blue-400 transition-colors duration-200"
                                            value="{{ old('age', auth()->user()->age) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Card -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">Academic Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Degree -->
                                    <div>
                                        <label for="degree_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Degree
                                        </label>
                                        <input type="text" name="degree_name" id="degree_name" 
                                               class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 cursor-not-allowed"
                                               value="{{ old('degree_name', auth()->user()->degree_name) }}"
                                               readonly>
                                        @error('degree_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Average Grade -->
                                    <div>
                                        <label for="average_grade" class="block text-sm font-medium text-gray-700 mb-2">
                                            Average Grade
                                        </label>
                                        <input type="number" step="0.01" name="average_grade" id="average_grade" 
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900 
                                                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                                hover:border-blue-400 transition-colors duration-200"
                                               value="{{ old('average_grade', auth()->user()->average_grade) }}">
                                        @error('average_grade')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <!-- ACT Member -->
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="act_member" id="act_member" 
                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                   value="1"
                                                   {{ old('act_member', auth()->user()->act_member) ? 'checked' : '' }}>
                                            <label for="act_member" class="ml-2 block text-sm text-gray-700">
                                                ACT Member
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            @if(auth()->user()->act_member)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Leadership -->
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="leadership" id="leadership" 
                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                   value="1"
                                                   {{ old('leadership', auth()->user()->leadership) ? 'checked' : '' }}>
                                            <label for="leadership" class="ml-2 block text-sm text-gray-700">
                                                Leadership Experience
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            @if(auth()->user()->leadership)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Verified
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Not Verified
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Optional: Add tooltip/help text -->
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p class="mb-1">• ACT Member status indicates your membership in the ACT organization</p>
                                        <p>• Leadership Experience verifies your participation in leadership roles</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Board Passer Examination Card -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">Board Passer Information</h3>
                                
                                <div class="space-y-6">
                                    <!-- Is Board Passer Toggle -->
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_board_passer" id="is_board_passer" 
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                value="1"
                                                {{ old('is_board_passer', auth()->user()->is_board_passer) ? 'checked' : '' }}>
                                            <label for="is_board_passer" class="ml-2 block text-sm text-gray-700">
                                                Board Examination Passer
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            @if(auth()->user()->is_board_passer)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Passed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Not a Board Passer
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Board Exam Details -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Board Exam Name -->
                                        <div>
                                            <label for="board_exam_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                Board Examination Name
                                            </label>
                                            <input type="text" name="board_exam_name" id="board_exam_name" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900
                                                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                                        hover:border-blue-400 transition-colors duration-200"
                                                value="{{ old('board_exam_name', auth()->user()->board_exam_name) }}">
                                            @error('board_exam_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Board Exam Year -->
                                        <div>
                                            <label for="board_exam_year" class="block text-sm font-medium text-gray-700 mb-2">
                                                Year Taken
                                            </label>
                                            <input type="number" name="board_exam_year" id="board_exam_year" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900
                                                        focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                                        hover:border-blue-400 transition-colors duration-200"
                                                value="{{ old('board_exam_year', auth()->user()->board_exam_year) }}">
                                            @error('board_exam_year')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- License Number -->
                                    <div>
                                        <label for="license_number" class="block text-sm font-medium text-gray-700 mb-2">
                                            License Number
                                        </label>
                                        <input type="text" name="license_number" id="license_number" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-900
                                                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                                    hover:border-blue-400 transition-colors duration-200"
                                            value="{{ old('license_number', auth()->user()->license_number) }}">
                                        @error('license_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <!-- Account Information Card -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">Change Password</h3>
                                
                                <div class="space-y-6">
                                    <!-- Current Password -->
                                    <div class="relative">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Current Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" 
                                                   name="current_password"
                                                   id="current_password"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 @error('current_password') border-red-500 @enderror"
                                                   autocomplete="current-password">
                                            <button type="button" 
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                                    onclick="togglePassword('current_password')">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="relative">
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            New Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" 
                                                   name="new_password"
                                                   id="new_password"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 @error('new_password') border-red-500 @enderror"
                                                   autocomplete="new-password">
                                            <button type="button" 
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                                    onclick="togglePassword('new_password')">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="relative">
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirm New Password
                                        </label>
                                        <div class="relative">
                                            <input type="password" 
                                                   name="new_password_confirmation"
                                                   id="new_password_confirmation"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700"
                                                   autocomplete="new-password">
                                            <button type="button" 
                                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                                    onclick="togglePassword('new_password_confirmation')">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg 
                                           hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 
                                           focus:ring-offset-2 transition-colors duration-200">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        }

        // Add smooth fade-out for success message
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.bg-green-50');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 1s ease-out';
                    successMessage.style.opacity = '0';
                    setTimeout(() => successMessage.remove(), 1000);
                }, 3000);
            }
        });
    </script>
    @endpush
</x-app-layout>