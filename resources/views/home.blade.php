@extends('layouts.one.master')

@section('title', 'Dashboard')

@section('content')
    <div class="px-4 py-6">
        <div class="md:max-w-5xl md:mx-auto">

            @component('components.heading', [
            'size' => 'heading'
            ])
                Главаня страница
            @endcomponent
            @component('components.heading', [
            'size' => 'normal',
            'classes' => "mb-4"
            ])
                Текущее время: {{ \Carbon\Carbon::now()->format('D j M, Y') }}
            @endcomponent

            @component('components.heading', [
            'size' => 'large',
            'classes' => 'mb-2'
            ])
                Растраты
            @endcomponent
            <div class="flex flex-wrap -mx-2 md:-mx-4 mb-6">
                <div class="w-1/2 md:w-1/4 px-2 md:px-4 mb-4">
                    @component('components.card')
                        @component('components.heading', [
                        'size' => 'heading2',
                        'classes' => "mb-3 md:hidden text-center tracking-tight"
                        ])
                            &#8377;{{ number_format($expenses->sum('expense_amount'), 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'heading',
                        'classes' => "mb-3 hidden md:block text-center tracking-tight"
                        ])
                            &#8377;{{ number_format($expenses->sum('expense_amount'), 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'small-caps',
                        'classes' => "text-center"
                        ])
                            Сегодня
                        @endcomponent

                    @endcomponent
                </div>
                <div class="w-1/2 md:w-1/4 px-2 md:px-4 mb-4">
                    @component('components.card')

                        @component('components.heading', [
                        'size' => 'heading2',
                        'classes' => "mb-3 md:hidden text-center"
                        ])
                            &#8377;{{ number_format($expensesYesterday, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'heading',
                        'classes' => "mb-3 hidden md:block text-center tracking-tight"
                        ])
                            &#8377;{{ number_format($expensesYesterday, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'small-caps',
                        'classes' => "text-center"
                        ])
                            Вчера
                        @endcomponent

                    @endcomponent
                </div>
                <div class="w-1/2 md:w-1/4 px-2 md:px-4 mb-4">
                    @component('components.card')

                        @component('components.heading', [
                        'size' => 'heading2',
                        'classes' => "mb-3 md:hidden text-center"
                        ])
                            &#8377;{{ number_format($expensesLastSevenDays, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'heading',
                        'classes' => "mb-3 hidden md:block text-center tracking-tight"
                        ])
                            &#8377;{{ number_format($expensesLastSevenDays, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'small-caps',
                        'classes' => "text-center"
                        ])
                            Последние 7 дней
                        @endcomponent

                    @endcomponent
                </div>

                <div class="w-1/2 md:w-1/4 px-2 md:px-4 mb-4">
                    @component('components.card')

                        @component('components.heading', [
                        'size' => 'heading2',
                        'classes' => "mb-3 md:hidden text-center"
                        ])
                            &#8377;{{ number_format($expensesCurrentMonth, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'heading',
                        'classes' => "mb-3 hidden md:block text-center tracking-tight"
                        ])
                            &#8377;{{ number_format($expensesCurrentMonth, 2)}}
                        @endcomponent

                        @component('components.heading', [
                        'size' => 'small-caps',
                        'classes' => "text-center"
                        ])
                            За текущей месяц
                        @endcomponent

                    @endcomponent
                </div>

            </div>

            @component('components.heading', [
            'size' => 'large',
            'classes' => 'mb-2'
            ])
                Недавние расходы
            @endcomponent
            @if ($expenses->isEmpty())
                @component('components.card')
                    <div class="py-10 text-center">
                        <p class="mb-6">Расходов не найдено за сегодня <br>Нажмите на кнопку что-бы добавить новую
                            запись</p>
                        @component('components.button', [
                        'type' => 'link',
                        'href' => route('expenses.create')
                        ])
                            Добавить расход
                        @endcomponent
                    </div>
                @endcomponent
            @else
                @include('expenses.expenseTablePartial')
            @endif
        </div>
    </div>
@endsection
