<div class="row" wire:ignore>
    @section('plugins.Datatables', true)
    @section('plugins.DatatablesPlugins', true)
    @push('css')
        <style>
            table.dataTable tr {
                font-size: 0.9em;
            }
        </style>
    @endpush

    <div class="col-md-12 mt-4">
        <x-adminlte-card title="Report" theme="light" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">

            <div class="row">
                <div class="col-md-3">
                    <x-adminlte-input name="started_date" label="Waktu Awal" type="date"
                                      min=1 max=10 igroup-size="sm" wire:model.debounce.1s="start">
                        <x-slot name="prependSlot">
                            <button class="input-group-text text-purple" wire:click="clearDate('start')">
                                <i class="fas fa-times"></i>
                            </button>
                        </x-slot>
                    </x-adminlte-input>

                </div>
                <div class="col-md-3">
                    <x-adminlte-input name="started_date" label="Waktu Akhir" type="date" min=1
                                      max=10 igroup-size="sm" wire:model.debounce.1s="end"
                                      wire:click="clearDate('end')">
                        <x-slot name="prependSlot">
                            <button class="input-group-text text-purple" wire:click="clearDate('end')">
                                <i class="fas fa-times"></i>
                            </button>
                        </x-slot>
                    </x-adminlte-input>

                </div>
            </div>

            <x-adminlte-select name="office_id" label="Tiket" wire:model="ticket_id">
                <x-adminlte-options :options="$tickets" placeholder="Select an option..."/>
            </x-adminlte-select>

            <livewire:admin.partials.report-data-table :ticket_id="$ticket_id"/>
        </x-adminlte-card>
    </div>
</div>
