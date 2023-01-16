<div class="row" wire:ignore>
    @section('plugins.Datatables', true)
    @section('plugins.DatatablesPlugins', true)
    @section('plugins.Sweetalert2', true)


    <div class="col-md-12 mt-4">
        @include('flash::message')
        <x-adminlte-card title="Rekonsiliasi" theme="dark" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">
            <div class="row mt-4">
                <div class="col-md-12">
                    <form wire:submit.prevent="upload">
                        <input type="file" wire:model="excel">
                        @error('excel') <span class="error">{{ $message }}</span> @enderror
                        <button class="btn-danger btn btn-sm" type="submit" wire:loading.attr="disabled">Import</button>
                    </form>
                </div>
                <div wire:loading wire:target="upload">
                    Validating...
                </div>
                <div class="col-md-12 mt-5">
                    <livewire:admin.partials.reconciliation-data-table/>
                </div>
            </div>
        </x-adminlte-card>
    </div>
</div>