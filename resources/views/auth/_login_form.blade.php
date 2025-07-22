<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <input id="email" type="email" name="email" required autofocus placeholder="Email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
    </div>
    <div>
        <input id="password" type="password" name="password" required placeholder="Password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
    </div>
    <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-400">
            <input type="checkbox" name="remember" class="mr-2 rounded" /> Remember me
        </label>
        <a href="{{ route('password.request') }}" class="text-indigo-400 text-sm hover:underline">Forgot?</a>
    </div>
    <button type="submit" class="w-full py-2 bg-indigo-500 text-white rounded-lg font-semibold hover:bg-indigo-600 transition">Sign In</button>
</form>
<div class="flex items-center my-4">
    <div class="flex-grow border-t border-gray-200"></div>
    <span class="mx-2 text-gray-300 text-xs">or</span>
    <div class="flex-grow border-t border-gray-200"></div>
</div>
@guest
@if (Route::has('google.redirect'))
<a href="{{ route('google.redirect') }}" class="flex items-center justify-center w-full py-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
    <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48"><g><path fill="#4285F4" d="M24 9.5c3.54 0 6.7 1.22 9.19 3.23l6.85-6.85C36.68 2.7 30.7 0 24 0 14.82 0 6.73 5.48 2.69 13.44l7.98 6.2C12.13 13.13 17.62 9.5 24 9.5z"/><path fill="#34A853" d="M46.1 24.55c0-1.64-.15-3.22-.42-4.74H24v9.01h12.42c-.54 2.9-2.18 5.36-4.65 7.01l7.19 5.6C43.98 37.13 46.1 31.3 46.1 24.55z"/><path fill="#FBBC05" d="M10.67 28.09a14.5 14.5 0 0 1 0-8.18l-7.98-6.2A23.94 23.94 0 0 0 0 24c0 3.77.9 7.34 2.69 10.29l7.98-6.2z"/><path fill="#EA4335" d="M24 48c6.48 0 11.93-2.15 15.9-5.85l-7.19-5.6c-2.01 1.35-4.6 2.15-8.71 2.15-6.38 0-11.87-3.63-14.33-8.94l-7.98 6.2C6.73 42.52 14.82 48 24 48z"/><path fill="none" d="M0 0h48v48H0z"/></g></svg>
    <span class="text-gray-700 font-medium">Sign in with Google</span>
</a>
@endif
@endguest
<div class="text-center mt-6">
    <span class="text-gray-400 text-sm">Don't have an account?</span>
    <a href="{{ route('register') }}" class="text-indigo-500 text-sm font-semibold hover:underline ml-1">Sign up</a>
</div> 