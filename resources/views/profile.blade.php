@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div id="profileApp" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">My Profile</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your account information and preferences</p>
    </div>

    <!-- Quick Actions Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
        <button @click="scrollToSection('profile')" class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Edit Profile</span>
        </button>
        
        <button @click="scrollToSection('password')" class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Security</span>
        </button>
        
        <button @click="exportProfile" class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Export Data</span>
        </button>
        
        <button @click="showActivity = !showActivity" class="flex items-center justify-center gap-2 px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Activity</span>
        </button>
    </div>

    <!-- Profile Overview Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
        <div class="bg-gradient-to-br from-slate-700 via-slate-600 to-slate-700 px-8 py-10">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center text-white text-2xl font-semibold border border-white/20">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-white mb-1">{{ $user->name }}</h2>
                        <p class="text-slate-200 text-sm mb-3">{{ $user->email }}</p>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/15 backdrop-blur-sm text-white border border-white/20">
                                {{ $user->isAdmin() ? 'Administrator' : 'Employee' }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/15 backdrop-blur-sm text-white border border-white/20">
                                ID: {{ $user->employee_id }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-slate-300 text-xs mb-1">Member Since</p>
                    <p class="text-white text-sm font-medium">{{ $user->created_at->format('M j, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log (Toggle) -->
    <div v-show="showActivity" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900 dark:text-white">Profile updated</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">2 hours ago</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm text-gray-900 dark:text-white">Password changed</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">3 days ago</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information Form -->
    <div id="profile" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your account details and personal information</p>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Employee ID -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Employee ID</label>
                    <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $user->employee_id) }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                    @error('employee_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <div class="relative">
                        <input type="text" value="{{ $user->role->name ?? 'User' }}" disabled 
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 cursor-not-allowed">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Contact admin to change your role</p>
                </div>

                <!-- Account Created -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Account Created</label>
                    <div class="relative">
                        <input type="text" value="{{ $user->created_at->format('F j, Y') }}" disabled 
                               class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 cursor-not-allowed">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="resetForm" class="px-5 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    Reset
                </button>
                <button type="submit" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Password Update Form -->
    <div id="password" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Password</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Maintain account security with a strong password</p>
        </div>
        
        <form method="POST" action="{{ route('profile.password') }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                    <div class="relative">
                        <input :type="showCurrentPassword ? 'text' : 'password'" name="current_password" id="current_password" 
                               class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                        <button type="button" @click="showCurrentPassword = !showCurrentPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <svg v-show="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg v-show="showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <div class="relative">
                        <input :type="showNewPassword ? 'text' : 'password'" name="password" id="password" 
                               class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                        <button type="button" @click="showNewPassword = !showNewPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <svg v-show="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg v-show="showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Minimum 8 characters with letters and numbers</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" 
                               class="w-full px-4 py-2.5 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-slate-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <svg v-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg v-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="clearPasswordFields" class="px-5 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    Clear
                </button>
                <button type="submit" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            showActivity: false,
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmPassword: false
        }
    },
    methods: {
        scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        resetForm() {
            document.querySelector('#profile form').reset();
        },
        clearPasswordFields() {
            document.getElementById('current_password').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';
        },
        exportProfile() {
            // Simulate export functionality
            alert('Profile data export will be available soon!');
        }
    }
}).mount('#profileApp');
</script>
@endsection