<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Attendance System</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div class="mt-12 flex flex-col items-center">
                    <h1 class="text-2xl xl:text-3xl font-extrabold">
                        Sign in to your account
                    </h1>
                    <div class="w-full flex-1 mt-8">

                        @if($errors->any())
                            <div class="mx-auto max-w-xs mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <ul class="text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="mx-auto max-w-xs">
                            @csrf
                            
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                type="email" 
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Email"
                                required
                                autofocus />
                            
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="password" 
                                name="password"
                                id="password"
                                placeholder="Password"
                                required />
                            
                            <div class="flex items-center justify-between mt-5">
                                <label class="flex items-center">
                                    <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-indigo-600">
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>
                            </div>
                            
                            <button
                                type="submit"
                                class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                                </svg>
                                <span class="ml-3">
                                    Sign In
                                </span>
                            </button>
                            
                            <p class="mt-6 text-xs text-gray-600 text-center">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="border-b border-gray-500 border-dotted">
                                    Sign up here
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
                <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');">
                </div>
            </div>
        </div>
    </div>
</body>
</html>