@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.emit('updateLenTable2', 10)
        })
    </script>
@endpush
<x-adminlte-datatable
        id="Table2"
        :heads="$heads"
        head-theme="dark"
        :config="$config" striped hoverable
        bordered
        compressed/>
