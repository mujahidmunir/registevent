@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.emit('updateLenTable1', 10)
            Livewire.emit('updateLenTable2', 10)
        })
    </script>
@endpush
@push('css')
    <style>
        table.dataTable tr {
            font-size: 0.9em;
        }
    </style>
@endpush
<div class="col-md-12 mt-4">
    @include('flash::message')
    <x-adminlte-card title="Report" theme="dark" theme-mode="outline"
                     class="elevation-3" header-class="bg-light"
                     footer-class="border-top rounded border-light">
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Data Valid: {{number_format(count($config['data']), 0, ',','.')}}</h5>
                <x-adminlte-datatable
                        wire:key="{{now()}}"
                        id="Table1"
                        :heads="$heads"
                        head-theme="dark"
                        :config="$config" striped hoverable
                        bordered
                        with-buttons compressed/>
            </div>

            <div class="col-md-12 mt-5">
                <h5>Data Tidak Valid: {{number_format(count($config2['data']), 0, ',','.')}}</h5>
                <x-adminlte-datatable
                        listener="updateDataTable2"
                        id="Table2"
                        :heads="$heads"
                        head-theme="dark"
                        :config="$config2" striped hoverable
                        bordered
                        with-buttons compressed/>
            </div>
        </div>
    </x-adminlte-card>
</div>
