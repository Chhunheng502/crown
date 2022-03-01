

<x-layout>
    <x-slot name="title"> Login Page </x-slot>
    <x-slot name="content">
        <div class="h-screen text-white bg-yellow-300">
            <div class="flex justify-center items-center text-center">
                <h1 class="text-6xl"> Welcome to Crown </h1>
                <img src="https://img.icons8.com/color/96/000000/crown.png" alt="crown" />
            </div>
            <div class="max-w-max px-10 py-5 mx-auto my-5 space-y-3 bg-yellow-500">
                <div class="text-center">
                    <h1 class="text-3xl"> Login Form </h1>
                </div>
                <form action="{{ route('auth.login') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <input type="email" name="email" id="email" class="w-80 px-3 py-2" placeholder="Enter email">
                    </div>
                    <div>
                        <input type="password" name="password" id="password" class="w-80 px-3 py-2" placeholder="Enter password">
                    </div>
                    <div>
                        <input type="checkbox" name="remember_me" id="remember_me">
                        <label for="remember_me"> Remember me </label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-lg"> Login </button>
                    </div>
                </form>
                <hr>
                <div class="text-center text-black">
                    <h1> Not registered yet? <a href="{{ route('user.create') }}" class="text-blue-600"> Create an account </a> </h1>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout>