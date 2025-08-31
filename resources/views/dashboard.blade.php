<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
                <p class="text-gray-600">Welcome, <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>! 👋</p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Calendar Card -->
                <div class="group">
                    <a href="{{ route('calendar') }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center transition-all duration-300 hover:shadow-lg hover:border-blue-300 hover:transform hover:-translate-y-1 group-hover:shadow-lg">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors">
                            <span class="text-2xl text-blue-600">📅</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Calendar</h3>
                        <p class="text-gray-600 text-sm mb-4">View upcoming events and schedule</p>
                        <span class="inline-flex items-center text-blue-600 text-sm font-medium">
                            View Events
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Emails Card -->
                <div class="group">
                    <a href="{{ route('emails') }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center transition-all duration-300 hover:shadow-lg hover:border-green-300 hover:transform hover:-translate-y-1 group-hover:shadow-lg">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                            <span class="text-2xl text-green-600">📧</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Emails</h3>
                        <p class="text-gray-600 text-sm mb-4">Check latest emails and messages</p>
                        <span class="inline-flex items-center text-green-600 text-sm font-medium">
                            Check Emails
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>

                <!-- Todos Card -->
                <div class="group">
                    <a href="{{ route('todos') }}" class="block bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center transition-all duration-300 hover:shadow-lg hover:border-purple-300 hover:transform hover:-translate-y-1 group-hover:shadow-lg">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-200 transition-colors">
                            <span class="text-2xl text-purple-600">✅</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">To-Dos</h3>
                        <p class="text-gray-600 text-sm mb-4">Manage tasks and to-do lists</p>
                        <span class="inline-flex items-center text-purple-600 text-sm font-medium">
                            View Tasks
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <!-- User Info Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Account Information</h3>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <span class="w-20 text-sm font-medium text-gray-500">Name:</span>
                        <span class="text-gray-800">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-20 text-sm font-medium text-gray-500">Email:</span>
                        <span class="text-gray-800">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">Signed in via Google OAuth • {{ now()->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>