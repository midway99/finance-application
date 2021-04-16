@extends('layouts.one.app')

@section('content')
    <div class="relative px-4 lg:px-6 py-16 lg:py-24 bg-gray-100 h-screen flex items-center">
        <div class="absolute left-0 right-0 top-0 bg-white">
            <div class="px-4 mx-auto py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="/" class="py-2 md:py-0">
                            <div class="flex items-center">
                                <span
                                    class="font-bold text-gray-800 text-lg md:text-xl ml-2">Mony Keep</span>
                            </div>
                        </a>
                    </div>
                    <div>
                        {{ __('Already have an account?') }}
                        @component('components.linkto', [
                        'href' => route('login')
                        ])
                            {{ __('Login') }}
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-3xl mx-auto w-full h-full py-4 md:py-10">
            @component('components.card', [
            'padding' => false
            ])
                <div class="p-10">
                    <div class="w-full md:w-2/3 mx-auto">
                        @component('components.heading', [
                        'size' => 'heading2',
                        'classes' => "mb-6 text-center"
                        ])
                            Создайте аккаунт и начните записывать свои расходы!)
                        @endcomponent

                        <form method="POST" action="{{ route('register') }}" onsubmit="
                            registerButton.disabled = true;
                            registerButton.classList.add('base-spinner');">
                            @csrf

                            @component('components.input', [
                            'label' => 'Имя',
                            'name' => 'name',
                            'attributes' => 'required autofocus'
                            ])
                            @endcomponent

                            @component('components.input', [
                            'label' => 'Email',
                            'name' => 'email',
                            'type' => 'email',
                            'attributes' => 'required'
                            ])
                            @endcomponent

                            @component('components.input', [
                            'label' => 'Password',
                            'name' => 'password',
                            'type' => 'password',
                            'attributes' => 'required'
                            ])
                            @endcomponent

                            @component('components.input', [
                            'label' => 'Confirm Password',
                            'name' => 'password_confirmation',
                            'type' => 'password',
                            'attributes' => 'required'
                            ])
                            @endcomponent


                            @component('components.button', [
                            'name' => 'registerButton',
                            'type' => 'submit',
                            'classes' => 'w-full font-semibold'
                            ])
                                Давайте начнем!)
                            @endcomponent
                        </form>
                    </div>
                </div>

            @endcomponent

            @component('components.heading', [
            'size' => 'small',
            'classes' => "text-center my-4 text-sm",
            'color' => 'text-gray-500'
            ])
                Copyrights &copy; {{date('Y')}} {{ config('app.name', 'Money Keep') }}
            @endcomponent
        </div>
    </div>
@endsection
