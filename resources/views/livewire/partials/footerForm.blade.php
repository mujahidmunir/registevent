<x-slot name="footerSlot">
    <button class="btn bg-gradient-warning" wire:click="clear">
        Reset
    </button>
    <button wire:click="save" class="btn float-right bg-gradient-blue">
        Save
    </button>
</x-slot>