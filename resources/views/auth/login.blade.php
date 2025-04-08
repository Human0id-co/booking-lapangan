<x-guest-layout>
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-1">Welcome Back 👋</h2>
    <p class="text-center text-sm text-gray-600 mb-6">Login to your account</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-150 ease-in-out" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-150 ease-in-out" />
        </div>

        <!-- Remember me & forgot -->
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Forgot password?</a>
            @endif
        </div>

        <!-- Submit -->
        <div>
            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-150 ease-in-out">
                LOG IN
            </button>
        </div>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Sign up</a>
    </p>
</x-guest-layout>
