<x-adminlte-datatable
        wire:ignore
        id="table2"
        :heads="$heads"
        head-theme="dark"
        :config="$config" striped hoverable
        bordered
        with-buttons compressed/>
