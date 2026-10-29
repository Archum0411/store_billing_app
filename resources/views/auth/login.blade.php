<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 antialiased">
        <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-10">
            <div class="flex items-center justify-center bg-slate-50 p-6 sm:p-8 lg:p-12">
                <div class="w-full max-w-md">
                    <div class="mb-8">
                        <p class="text-sm font-medium text-indigo-600">Welcome back</p>
                        <h2 class="mt-2 text-3xl font-bold text-slate-900">Sign in</h2>
                        <p class="mt-2 text-sm text-slate-500">Access your Store billing dashboard and continue your outreach.</p>
                    </div>

                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                placeholder="Enter your email"
                                required
                            >
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                placeholder="Enter your password"
                                required
                            >
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                                Remember me
                            </label>
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Secure login
                            </span>
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3 text-base font-semibold text-white shadow-lg shadow-indigo-500/20 transition hover:translate-y-[-1px] hover:shadow-xl hover:shadow-indigo-500/25"
                        >
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6">
                        <div class="relative flex items-center">
                            <div class="flex-1 border-t border-slate-200"></div>
                            <span class="mx-3 text-xs uppercase tracking-[0.2em] text-slate-400">or</span>
                            <div class="flex-1 border-t border-slate-200"></div>
                        </div>

                        
                    </div>

                    <p class="mt-8 text-center text-sm text-slate-500">
                        Don’t have an account?
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Create one</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
