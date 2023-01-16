@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            @this.
            on('doSave', function () {
                console.log("oke nih");
                Swal.fire({
                    title: 'Apakah data sudah benar?',
                    html: "<strong class='text-danger'>Anda tidak dapat mengubah data yang sudah tersimpan</strong>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Data Sudah Benar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.
                        save();
                    }
                })

            });

            @this.
            on('afterSaving', function (success, message) {
                if (success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data sudah tersimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    })
                }
            })
        });

        @if($this->popup)
        $(window).on('load', function () {
            $('#ketentuan').modal('show');
        });
        @endif
    </script>
@endpush
<div class="row mt-4">
    <x-adminlte-modal wire:ignore id="ketentuan" title="Ketentuan Tiketing" theme="green"
                      size='lg' disable-animations show>
        @include('livewire.cs.partials.ketentuan')
    </x-adminlte-modal>
    <div class="col-md-12">
        @include('flash::message')
        @if($duplicate_cif || $duplicate_phone)
            <x-adminlte-alert theme="danger" title="Oops..">
                CIF/No. HP dibatas {{$this->ticket['max_quantity']}}
            </x-adminlte-alert>
        @endif

        @if($error_max)
            <x-adminlte-alert theme="danger" title="Oops..">
                Maksimal {{$this->ticket['max_ticket']}} Tiket
            </x-adminlte-alert>
        @endif

        @if(!$available && !$edit_mode)
            <x-adminlte-alert theme="danger" title="Oops..">
                Tiket Habis
            </x-adminlte-alert>
        @endif

        <x-adminlte-card title="Registrasi" theme="maroon" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light"
                         icon="fas fa-lg fa-edit">
            <x-slot name="toolsSlot">
                <strong class="text-danger">Tersisa {{number_format(($ticket['quota'] - $this->sold), 0, ',', '.')}}
                    tiket</strong>
            </x-slot>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="quantity" label="Jumlah Tiket" wire:model.lazy="quantity" type="number"
                                      min="1" max="{{$ticket['max_ticket']}}"/>
                    <x-adminlte-input name="cif" label="No. CIF" wire:model.lazy="cif" maxlength="6"
                                      placeholder="Masukan CIF (6 karakter)">
                        @if($duplicate_cif)
                            <x-slot name="bottomSlot">
                            <span class="text-sm text-danger">
                                CIF sudah melebihi batas
                            </span>
                            </x-slot>
                        @endif
                    </x-adminlte-input>
                    <x-adminlte-input type="number" name="phone" label="No. Whatsapp" wire:model.lazy="phone"
                                      placeholder="cth: 08133854429">
                        @if($duplicate_phone)
                            <x-slot name="bottomSlot">
                            <span class="text-sm text-danger">
                                Nomor sudah melebihi batas
                            </span>
                            </x-slot>
                        @endif
                        <x-slot name="bottomSlot">
                                    <span class="text-sm text-gray">
                                        Pastikan nomor whatsapp aktif
                                    </span>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="bank_id" label="No. Rekening" wire:model="bank_id"
                                      placeholder="Masukan Nomor Rekening"/>

                    <div class="form-group">
                        <label style="margin-bottom: 0.4rem">Konfirmasi Client Memiliki Digi & Digicash</label>
                        <div class="form-row align-items-center mt-2">
                            <div class="col-auto  mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="digi">
                                    <label class="form-check-label" for="autoSizingCheck">DIGI</label>
                                </div>
                                @error('digi')
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-auto  mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="digicash">
                                    <label class="form-check-label" for="autoSizingCheck">DIGICASH</label>
                                </div>
                                @error('digicash')
                                <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-8">
                            <x-adminlte-input name="rrn" label="No. RRN/No. Resi." wire:model.lazy="rrn" maxlength="12"
                                              placeholder="Masukan Nomor RRN / Nomor Resi"/>
                        </div>
                        <div class="col-md-4">
                            <x-adminlte-select name="method" wire:model.defer="method" label="Metode Pembayaran">
                                <x-adminlte-options :options="['DIGI', 'DIGICASH']"
                                                    placeholder="Pilih metode"/>
                            </x-adminlte-select>
                        </div>
                    </div>
                    <x-adminlte-input name="reg_id" label="No. Registrasi" wire:model.defer="reg_id" disabled/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="ktp" label="No. KTP" wire:model.defer="ktp" placeholder="Masukan Nomor KTP">
                        <x-slot name="appendSlot">
                            <button class="input-group-text bg-maroon" wire:click="searchKTP">
                                <i class="fas fa-search"></i>
                            </button>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input type="text" name="first_name" label="Nama Depan"
                                      wire:model.defer="first_name"
                                      placeholder="Masukan Nama Depan"/>
                    <x-adminlte-input type="text" name="last_name" label="Nama Belakang"
                                      wire:model.defer="last_name"
                                      placeholder="Masukan Nama Belakang"/>
                    <x-adminlte-input name="city" label="Kota" wire:model.defer="city"
                                      placeholder="Masukan Kota"/>
                    <x-adminlte-input type="text" name="address" label="Alamat" wire:model.defer="address"/>
                    <x-adminlte-input type="email" name="email" label="Email"
                                      wire:model.defer="email">
                        <x-slot name="bottomSlot">
                            <span class="text-sm text-gray">Pastikan email valid. Tiket akan dikirim ke email</span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <x-slot name="footerSlot">
                <button class="btn bg-gradient-warning" wire:click="clear">
                    Reset
                </button>
                <button wire:click="$emit('doSave')" class="btn float-right bg-gradient-blue">
                    Save
                </button>
            </x-slot>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Pendaftar" theme="maroon" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">

            <livewire:cs.partials.registration-data-table :ticket_id="$ticket['id']"/>
        </x-adminlte-card>

        {{--        <x-adminlte-card title="Daftar Pembeli Tiket" theme="dark" theme-mode="outline"--}}
        {{--                         class="elevation-3" header-class="bg-light"--}}
        {{--                         footer-class="border-top rounded border-light">--}}
        {{--            <div class="table-responsive">--}}
        {{--                <table class="table">--}}
        {{--                    <thead>--}}
        {{--                    <tr>--}}
        {{--                        <th scope="col">#</th>--}}
        {{--                        <th scope="col">Name</th>--}}
        {{--                        <th scope="col">KTP</th>--}}
        {{--                        <th scope="col">Phone</th>--}}
        {{--                        <th scope="col">Rekening</th>--}}
        {{--                        <th scope="col">Kota</th>--}}
        {{--                        <th scope="col">Email</th>--}}
        {{--                        <th scope="col">CIF</th>--}}
        {{--                        <th scope="col">RRN</th>--}}
        {{--                        <th scope="col">CS</th>--}}
        {{--                        <th scope="col">Status</th>--}}
        {{--                    </tr>--}}
        {{--                    </thead>--}}
        {{--                    <tbody>--}}
        {{--                    @foreach($registrations as $registration)--}}
        {{--                        <tr>--}}
        {{--                            <th scope="row">{{$registration->registration_id}}</th>--}}
        {{--                            <td>{{$registration->name}}</td>--}}
        {{--                            <td>{{$registration->ktp}}</td>--}}
        {{--                            <td>{{$registration->phone}}</td>--}}
        {{--                            <td>{{$registration->bank_id}}</td>--}}
        {{--                            <td>{{$registration->city}}</td>--}}
        {{--                            <td>{{$registration->email}}</td>--}}
        {{--                            <td>{{$registration->cif}}</td>--}}
        {{--                            <td>{{$registration->rrn}}</td>--}}
        {{--                            <td>{{$registration->cs->name}}</td>--}}
        {{--                            <td>--}}
        {{--                                <span class="badge badge-{{$registration->validation_color}}">{{$registration->validation_text}}</span>--}}
        {{--                            </td>--}}
        {{--                        </tr>--}}
        {{--                    @endforeach--}}
        {{--                    </tbody>--}}
        {{--                </table>--}}
        {{--            </div>--}}
        {{--            <x-slot name="toolsSlot">--}}
        {{--                @include('livewire.partials.search')--}}
        {{--            </x-slot>--}}
        {{--            <x-slot name="footerSlot">--}}
        {{--                {{$registrations->links("pagination::bootstrap-4")}}--}}
        {{--            </x-slot>--}}
        {{--        </x-adminlte-card>--}}
    </div>
</div>
