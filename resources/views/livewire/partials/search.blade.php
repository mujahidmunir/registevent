<x-adminlte-input name="iSearch" placeholder="search" igroup-size="md" wire:model.debounce.1000ms="query">
    <x-slot name="prependSlot">
        <div class="input-group-text text-danger">
            <i class="fas fa-search"></i>
        </div>
    </x-slot>
</x-adminlte-input>