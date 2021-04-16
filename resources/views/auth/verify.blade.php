@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center">
            <div class="w-full max-w-sm">

                @if (session('resent'))
                    <div
                        class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100  px-3 py-4 mb-4"
                        role="alert">
                        {{ __('На ваш адрес электронной почты была отправлена новая ссылка для подтверждения.') }}
                    </div>
                @endif

                <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
                    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                        {{ __('Проверьте свой адрес электронной почты') }}
                    </div>

                    <div class="w-full flex flex-wrap p-6">
                        <p class="leading-normal">
                            {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
                        </p>

                        <p class="leading-normal mt-6">
                            {{ __('Если вы не получили письмо') }}, <a
                                class="text-blue-500 hover:text-blue-700 no-underline"
                                onclick="event.preventDefault(); document.getElementById('resend-verification-form').submit();">{{ __('') }}</a>.
                        </p>

                        <form id="resend-verification-form" method="POST" action="{{ route('verification.resend') }}"
                              class="hidden">
                            @csrf
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
