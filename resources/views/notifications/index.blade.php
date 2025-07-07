<x-app-layout>
    @section('title', 'Notifications')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Notifications
                            @if($notifications->count() > 0)
                                <span class="ml-2 text-sm text-gray-500">({{ $notifications->total() }} total)</span>
                            @endif
                        </h2>
                        
                        @if($notifications->count() > 0)
                            <div class="flex space-x-4">
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Mark all as read
                                    </button>
                                </form>
                                <form action="{{ route('notifications.destroyAll') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Clear all
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Notifications List -->
                    @forelse($notifications as $notification)
                        <div class="mb-4 p-4 rounded-lg {{ $notification->read_at ? 'bg-gray-50' : 'bg-blue-50 border-l-4 border-blue-500' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        @if(!$notification->read_at)
                                            <span class="h-2 w-2 bg-blue-500 rounded-full mr-2"></span>
                                        @endif
                                        <h3 class="font-medium text-gray-900">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h3>
                                    </div>
                                    
                                    <p class="text-gray-600">
                                        {{ $notification->data['message'] ?? '' }}
                                    </p>

                                    @if(isset($notification->data['action_url']))
                                        <a href="{{ $notification->data['action_url'] }}" 
                                           class="inline-block mt-2 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            View Details →
                                        </a>
                                    @endif

                                    <div class="mt-2 text-sm text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>

                                <div class="ml-4 flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">You're all caught up! Check back later for new notifications.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($notifications->hasPages())
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add smooth fade-out for success messages
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

        // Add confirmation for delete actions
        document.querySelectorAll('form').forEach(form => {
            if (form.action.includes('destroy')) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this notification?')) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Add confirmation for clear all action
        document.querySelectorAll('form').forEach(form => {
            if (form.action.includes('destroyAll')) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to clear all notifications? This cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>