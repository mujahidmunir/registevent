@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            @this.
            on('pop', function (status, message) {
                Swal.fire({
                    icon: status,
                    title: message,
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        });
    </script>
@endpush
<div class="row">
    <div class="col-md-12" wire:ignore>
        <p>
        <h5>Database (Valid)</h5></p>
        <x-adminlte-datatable
                id="table3"
                :heads="$heads"
                head-theme="dark"
                :config="$config" striped hoverable
                bordered
                with-buttons compressed/>
    </div>

    <div class="col-md-12" wire:ignore>
        <p>
        <h5>Excel (Tidak Valid)</h5></p>
        <x-adminlte-datatable
                listener="updateDataTable2"
                wire:ignore
                id="table4"
                :heads="$heads2"
                head-theme="dark"
                :config="$config2" striped hoverable
                bordered
                with-buttons compressed/>
    </div>
    <div class="col-md-12">
        @if(count($valid_ids))
            <button onclick="confirm('Yakin akan sinkronisasi data?') || event.stopImmediatePropagation()" wire:click="sync"
                    class="btn btn-success">Save
            </button>
        @endif
    </div>
</div>


