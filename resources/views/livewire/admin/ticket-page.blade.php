<div class="row">
    <div class="col-md-12">
        @include('flash::message')
        <x-adminlte-card title="Tiket" theme="primary" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light"
                         icon="fas fa-lg fa-bell" collapsible maximizable>
            <div class="row">

                <div class="col-md-6">
                    <x-adminlte-input name="name" placeholder="Username" label="ID Registrasi" wire:model="name"/>
                    <x-adminlte-input name="first_number" type="number" placeholder="1" label="Kode Awal"
                                      wire:model="first_number"/>
                    <x-adminlte-input name="last_number" type="number" placeholder="1000" label="Kode Akhir"
                                      wire:model="last_number"/>
                    <x-adminlte-input name="quota" type="number" placeholder="1000" label="Jumlah Kuota"
                                      wire:model="quota" disabled/>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input type="date" name="started_at" label="Tanggal Mulai" placeholder="MM/DD/YYYY"
                                      wire:model="started_at"/>
                    <x-adminlte-input type="date" name="ended_at" label="Tanggal Berakhir" placeholder="MM/DD/YYYY"
                                      wire:model="ended_at"/>
                    <x-adminlte-input name="max_quantity" type="number" placeholder="2" label="Max. No.HP/CIF" value="1"
                                      wire:model="max_quantity"/>
                    <x-adminlte-input name="max_ticket" type="number" placeholder="2" label="Max Ticket" value="1"
                                      wire:model="max_ticket"/>
                    <x-adminlte-select name="selBasic" label="Status" wire:model="active">
                        <option value="0">Not Active</option>
                        <option value="1">Active</option>
                    </x-adminlte-select>
                </div>
            </div>
            @include('livewire.partials.footerForm')
        </x-adminlte-card>
    </div>

    <div class="col-md-12">
        <x-adminlte-card title="Daftar Tiket" theme="dark" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Awal</th>
                        <th scope="col">Kode Akhir</th>
                        <th scope="col">Jumlah Kuota</th>
                        <th scope="col">Tersedia</th>
                        <th scope="col">Terjual</th>
                        <th scope="col">Max CIF</th>
                        <th scope="col">Max Tiket</th>
                        <th scope="col">Status</th>
                        <th scope="col">Dimulai</th>
                        <th scope="col">Berakhir</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <th scope="row">{{$ticket->name}}</th>
                            <td>{{$ticket->first_number}}</td>
                            <td>{{$ticket->last_number}}</td>
                            <td>{{$ticket->quota}}</td>
                            <td>{{number_format(($ticket->quota - $ticket->registrations_count))}}</td>
                            <td>{{number_format($ticket->registrations_count)}}</td>
                            <td>{{$ticket->max_quantity}}</td>
                            <td>{{$ticket->max_ticket}}</td>
                            <td>
                                <button wire:click="activator({{$ticket->id}})"
                                        class="btn btn-xs btn-{{$ticket->active ? 'danger' : 'success'}}">{{$ticket->status_text}}</button>
                            </td>
                            <td>{{$ticket->started_at->format('Y-m-d')}}</td>
                            <td>{{$ticket->ended_at->format('Y-m-d')}}</td>
                            <td>@include('livewire.partials.actionButton', ['id' => $ticket->id])</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <x-slot name="toolsSlot">
                @include('livewire.partials.search')
            </x-slot>
            <x-slot name="footerSlot">
                {{$tickets->links("pagination::bootstrap-4")}}
            </x-slot>
        </x-adminlte-card>

    </div>
</div>
