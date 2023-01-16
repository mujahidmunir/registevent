<div class="row mt-4">
    <div class="col-md-2">
        <x-adminlte-callout theme="info" title-class="text-uppercase" icon="fas fa-lg fa-check"
                            title="{{number_format($sold)}}">
            <i>Tiket Terjual</i>
        </x-adminlte-callout>
    </div>

    <div class="col-md-2">
        <x-adminlte-callout theme="warning" title-class="text-uppercase" icon="fas fa-lg fa-ticket-alt"
                            title="{{number_format($ticket['quota'] - $sold)}}">
            <i>Tiket Tersedia</i>
        </x-adminlte-callout>
    </div>

    <div class="col-md-2">
        <x-adminlte-callout theme="success" title-class="text-uppercase" icon="fas fa-lg fa-arrow-up"
                            title="{{$ticket['name']}}">
            <i>Tiket Aktif</i>
        </x-adminlte-callout>
    </div>

    <div class="col-md-2">
        <x-adminlte-callout title-class="text-uppercase" icon="fas fa-lg fa-users"
                            title="{{number_format($user_total)}}">
            <i>User Kantor Cabang</i>
        </x-adminlte-callout>
    </div>

    <div class="col-md-2">
        <x-adminlte-callout theme="danger" title-class="text-uppercase" icon="fa fa-lg fa-user-shield"
                            title="{{number_format($admin_total)}}">
            <i>User Admin</i>
        </x-adminlte-callout>
    </div>

    <div class="col-md-8">
        <canvas id="bar"></canvas>
    </div>
    <div class="col-md-4">
        <canvas id="donat"></canvas>
    </div>
</div>
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('bar'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($columnChart['labels']) !!},
                datasets: [{
                    label: 'Pencapaian Kantor Cabang',
                    data: {!! json_encode($columnChart['data']) !!},
                    backgroundColor: {!! json_encode($columnChart['colors']) !!}
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        new Chart(document.getElementById('donat'), {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Terjual'],
                datasets: [{
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label;
                                let value = context.formattedValue;

                                if (!label)
                                    label = 'Unknown'

                                let sum = 0;
                                let dataArr = context.chart.data.datasets[0].data;
                                dataArr.map(data => {
                                    sum += Number(data);
                                });

                                let percentage = (value * 100 / sum).toFixed(2) + '%';
                                return label + ": " + percentage;
                            }
                        }
                    },
                    label: 'Sales',
                    data: [{{$available_percent}}, {{$sold_percent}}],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            },

        });
    </script>
@endsection