@extends('layouts.one.master')

@section('title', 'Reports')

@section('content')
    <div class="px-4 py-6">
        <div class="md:max-w-5xl md:mx-auto">
            @component('components.heading', [
            'size' => 'heading',
            'classes' => 'mb-4'
            ])
                Отчет
            @endcomponent

            @component('components.heading', [
            'size' => 'large',
            'classes' => 'mb-2'
            ])
                Расходы за последние 30 дней
            @endcomponent
            @component('components.card')
                @include('reports.barChartWidget', [
                'keys' => $expensesDataForGraph->keys(),
                'values' => $expensesDataForGraph->values(),
                'id' => 'expenseBarChart'
                ])
            @endcomponent

            @component('components.heading', [
            'size' => 'large',
            'classes' => 'mb-2 mt-8'
            ])
                Расходы по категориям
            @endcomponent
            @component('components.card')
                @include('reports.barChartWidget', [
                'keys' => $categoryWiseExpenseGraph->keys(),
                'values' => $categoryWiseExpenseGraph->values(),
                'id' => 'categoryWiseExpenseGraph',
                'chartType' => 'horizontalBar',
                'tooltipData' => 'xLabel'
                ])
            @endcomponent
        </div>
    </div>
@endsection

@section('js-bottom')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" defer data-turbolinks-track="reload">
    </script>
@endsection
