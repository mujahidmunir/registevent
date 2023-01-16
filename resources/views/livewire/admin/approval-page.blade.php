@section('plugins.Sweetalert2', true)
@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            @this.
            on('pop', function (success, message) {
                if (success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
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
            });

            @this.
            on('mass', function () {
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.
                        massApprove()
                    }
                })
            });
        });


    </script>
@endpush
<div class="row mt-4">
    <div class="col-md-12">
        <x-adminlte-card title="Daftar Pengguna" theme="dark" theme-mode="outline"
                         class="elevation-3" header-class="bg-light"
                         footer-class="border-top rounded border-light">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" wire:model="selectAll">
                        </th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIP</th>
                        <th scope="col">User Domain</th>
                        <th scope="col">Divisi</th>
                        <th scope="col">No. HP</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">
                                <input type="checkbox" wire:model="ids" value="{{$user->id}}">
                            </th>
                            <th scope="row">{{$user->name}}</th>
                            <td>{{$user->nip}}</td>
                            <td>{{$user->domain_name}}</td>
                            <td>{{$user->office->name}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->active)
                                    <button wire:click="approve({{$user->id}}, 0)" class="btn btn-xs btn-danger">
                                        Disapprove
                                    </button>
                                @else
                                    <button wire:click="approve({{$user->id}}, 1)" class="btn btn-xs btn-success">
                                        Approve
                                    </button>
                                    <button onclick="confirm('Yakin akan menghapus?') || event.stopImmediatePropagation()" wire:click="delete({{$user->id}}, 1)" class="btn btn-xs btn-danger">
                                        Reject
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <x-slot name="toolsSlot">
                <div class="row">
                    <div class="col-auto mb-2">
                        @include('livewire.partials.search')
                    </div>
                    <div class="col-auto mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="query_active">
                            <label class="form-check-label" for="autoSizingCheck">Approved</label>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footerSlot">
                <div class="float-left">
                    {{$users->links("pagination::bootstrap-4")}}
                </div>
                <div class="float-right">
                    @if($query_active)
                        <button class="btn btn-danger" @empty($ids) disabled @endempty
                                wire:click="$emit('mass')">Disapprove
                        </button>
                    @else
                        <button class="btn btn-success" @empty($ids) disabled @endempty
                                wire:click="$emit('mass')">Approve
                        </button>
                    @endif
                </div>
            </x-slot>
        </x-adminlte-card>

    </div>
</div>
