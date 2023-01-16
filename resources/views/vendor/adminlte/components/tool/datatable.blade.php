{{-- Table --}}

<div class="table-responsive">

    <table id="{{ $id }}" style="width:100%" {{ $attributes->merge(['class' => $makeTableClass()]) }}>

        {{-- Table head --}}
        <thead @isset($headTheme) class="thead-{{ $headTheme }}" @endisset>
        <tr>
            @foreach($heads as $th)
                <th @isset($th['width']) style="width:{{ $th['width'] }}%" @endisset
                @isset($th['no-export']) dt-no-export @endisset>
                    {{ is_array($th) ? ($th['label'] ?? '') : $th }}
                </th>
            @endforeach
        </tr>
        </thead>

        {{-- Table body --}}
        <tbody>{{ $slot }}</tbody>

        {{-- Table footer --}}
        @isset($withFooter)
            <tfoot @isset($footerTheme) class="thead-{{ $footerTheme }}" @endisset>
            <tr>
                @foreach($heads as $th)
                    <th>{{ is_array($th) ? ($th['label'] ?? '') : $th }}</th>
                @endforeach
            </tr>
            </tfoot>
        @endisset

    </table>

</div>

{{-- Add plugin initialization and configuration code --}}

@push('js')
    <script>
        let cfg{{$id}} =  @json($config);
        let cd{{$id}} = cfg{{$id}}['columnDefs'];
        if (cd{{$id}} !== undefined) {
            cd{{$id}}.map(function (a, i) {
                if (a.str) {
                    cfg{{$id}}['columnDefs'][i]['render'] = function (data) {
                        return '\u200C' + data
                    }
                }
            })
        }
        const datatable{{$id}} = $('#{{ $id }}').DataTable(cfg{{$id}});
        const updateListener{{$id}} = '{{isset($attributes['listener']) ? $attributes['listener'] : 'updateDataTable'}}';

        Livewire.on('updateLen{{$id}}', function (len) {
            datatable{{$id}}.page.len(len).draw();
        })

        Livewire.on(updateListener{{$id}}, rows => {
            datatable{{$id}}.clear().draw();
            datatable{{$id}}.rows.add(rows);
            datatable{{$id}}.draw();
        })
    </script>
@endpush

{{-- Add CSS styling --}}

@isset($beautify)
    @push('css')
        <style type="text/css">
            #{{ $id }} tr td, #{{ $id }} tr th {
                vertical-align: middle;
                text-align: center;
            }
        </style>
    @endpush
@endisset
