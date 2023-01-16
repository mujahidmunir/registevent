@push('css')
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        document.addEventListener("livewire:load", function (event) {
            Livewire.hook('message.processed', (el, component) => {
                $('.selectpicker').selectpicker('refresh');
            })
        });
    </script>
@endpush
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
<div class="row mt-4">
    <div class="col-md-12">
        @include('flash::message')

        <x-adminlte-card title="Pengguna" theme="success" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light"
                         icon="fas fa-lg fa-users" collapsible maximizable>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama" wire:model.defer="name">
                        <x-slot name="appendSlot">
                            <select class="form-control" wire:model.defer="is_admin" name="is_admin">
                                <x-adminlte-options :options="['CS', 'Admin']"/>
                            </select>
                        </x-slot>
                    </x-adminlte-input>
                    <div class="form-group">
                        <label for="office_id">Kantor Cabang</label>
                        <div class="input-group">
                            <select class="selectpicker form-control" wire:model.defer="office_id" name="office_id"
                                    data-live-search="true">
                                <x-adminlte-options :options="$offices" placeholder="Select an option..."/>
                            </select>
                        </div>
                    </div>
                    <x-adminlte-input name="domain_name" type="text" label="User Domain"
                                      wire:model.defer="domain_name" maxlength="4"/>
                    <x-adminlte-input name="nip" type="text" label="NIP" wire:model="nip"/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="phone" type="number" label="No. HP" wire:model.defer="phone"/>
                    <x-adminlte-input name="email" type="text" label="Email" wire:model.defer="email"/>
                    <x-adminlte-input name="password" type="password" label="Password" wire:model.defer="password">
                        <x-slot name="appendSlot">
                            <button class="input-group-text bg-maroon" wire:click="generate">
                                <i class="fas fa-key"></i>
                            </button>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="password_confirmation" type="password" label="Re-Password"
                                      wire:model.defer="password_confirmation"/>
                </div>
            </div>
            @include('livewire.partials.footerForm')
        </x-adminlte-card>
    </div>

    <div class="col-md-12">
        <x-adminlte-card title="Daftar Pengguna" theme="dark" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">
            <livewire:admin.partials.user-data-table/>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        {{--        <x-adminlte-card title="Daftar Pengguna" theme="dark" theme-mode="outline"--}}
        {{--                         class="elevation-3" header-class="bg-light"--}}
        {{--                         footer-class="border-top rounded border-light">--}}
        {{--            <div class="table-responsive">--}}
        {{--                <table class="table">--}}
        {{--                    <thead>--}}
        {{--                    <tr>--}}
        {{--                        <th scope="col">Nama</th>--}}
        {{--                        <th scope="col">Domain</th>--}}
        {{--                        <th scope="col">NIP</th>--}}
        {{--                        <th scope="col">Divisi</th>--}}
        {{--                        <th scope="col">No. HP</th>--}}
        {{--                        <th scope="col">Email</th>--}}
        {{--                        <th scope="col">Action</th>--}}
        {{--                    </tr>--}}
        {{--                    </thead>--}}
        {{--                    <tbody>--}}
        {{--                    @foreach($users as $user)--}}
        {{--                        <tr>--}}
        {{--                            <th scope="row">{{$user->name}}</th>--}}
        {{--                            <td>{{$user->domain_name}}</td>--}}
        {{--                            <td>{{$user->nip}}</td>--}}
        {{--                            <td>{{$user->office->name}}</td>--}}
        {{--                            <td>{{$user->phone}}</td>--}}
        {{--                            <td>{{$user->email}}</td>--}}
        {{--                            <td>@include('livewire.partials.actionButton', ['id' => $user->id])</td>--}}
        {{--                        </tr>--}}
        {{--                    @endforeach--}}
        {{--                    </tbody>--}}
        {{--                </table>--}}
        {{--            </div>--}}

        {{--            <x-slot name="toolsSlot">--}}
        {{--                @include('livewire.partials.search')--}}
        {{--            </x-slot>--}}
        {{--            <x-slot name="footerSlot">--}}
        {{--                {{$users->links("pagination::bootstrap-4")}}--}}
        {{--            </x-slot>--}}
        {{--        </x-adminlte-card>--}}
    </div>
</div>
