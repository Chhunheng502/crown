

<x-layout>
    <x-slot name="title"> Register Page </x-slot>
    <x-slot name="content">
        <div class="h-screen text-white bg-yellow-300">
            <div class="flex justify-center items-center text-center">
                <h1 class="text-6xl"> Welcome to Crown </h1>
                <img src="https://img.icons8.com/color/96/000000/crown.png" alt="crown" />
            </div>
            <div class="max-w-max px-10 py-5 mx-auto my-5 space-y-3 bg-yellow-500">
                <div class="text-center">
                    <h1 class="text-3xl"> Create an account </h1>
                </div>
                <form action="{{ route('user.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <input type="text" name="name" id="name" class="w-80 px-3 py-2" placeholder="Enter name" value="{{ old('name') }}">
                    </div>
                    <div>
                        <input type="email" name="email" id="email" class="w-80 px-3 py-2" placeholder="Enter email" value="{{ old('email') }}">
                    </div>
                    <div>
                        <input type="password" name="password" id="password" class="w-80 px-3 py-2" placeholder="Enter password">
                    </div>
                    <div>
                        <input type="password" name="confirm_password" id="confirm_password" class="w-80 px-3 py-2" placeholder="Enter password again">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-lg"> Create </button>
                    </div>

                    @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500 text-xs"> {{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif
                </form>
                <div>
                    <a href="{{ route('auth.loginForm') }}" class="text-blue-600"> Go back </a>
                </div>
            </div>
        </div>
    </x-slot>
</x-layout>