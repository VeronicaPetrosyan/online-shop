@extends('layouts.main')
@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5" style="margin-top: 100px">
            <div id="orders-by-month-chart"></div>

            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Highcharts.chart('orders-by-month-chart', {
                        chart: {
                            type: 'line'
                        },
                        title: {
                            text: 'Orders by Month'
                        },
                        xAxis: {
                            title: {
                                text: 'Months'
                            },
                            categories: @json($months)
                        },
                        yAxis: {
                            title: {
                                text: 'Number of Orders'
                            }
                        },
                        series: [{
                            name: 'Orders',
                            data: @json($orderCounts)
                        }]
                    });
                });
            </script>
        </div>
    </div>
@endsection
