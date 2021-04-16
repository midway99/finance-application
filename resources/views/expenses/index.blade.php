@extends('layouts.one.master')

@section('title', 'Expenses')

@section('content')
    <div class="px-4 py-10">
        <div class="md:max-w-5xl md:mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div>
                    @component('components.heading', [
                    'size' => 'heading'
                    ])
                        Ваши расходы
                    @endcomponent
                </div>
                <div>
                    @component('components.button', [
                    'href' => route('expenses.create'),
                    'type' => 'link'
                    ])
                        Добавить запись
                    @endcomponent
                </div>
            </div>
            <div class="mb-5 expenses-content">
                @include('expenses.indexPartial')
            </div>
        </div>
    </div>
@endsection
@section('js-bottom')
    <script>
    </script>
@endsection
