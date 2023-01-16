@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))
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
        const nip = $("#nip");
        nip.on('keyup', function () {
            let text = $(this).val();
            text = text.replace(/[^0-9,.]+/, '');

            let format = 'xx.xx.xxxx';
            const lval = text.length - 1;
            const lFormat = format.length;

            let res = '';
            for (let i = 0; i <= lval; i++) {
                if (i >= lFormat) {
                    break;
                }

                if (format[i] === '.' && text[i] !== '.') {
                    res += '.';
                }

                res += text[i];
            }

            nip.val(res)
        })
    </script>
@endpush
@section('auth_body')

    <form action="{{ $register_url }}" method="post">
        @include('flash::message')
        @csrf

        <x-adminlte-input name="name" label="Nama Lengkap" placeholder="Masukan Nama Lengkap" igroup-size="sm"
                          class="text-capitalize" value="{{ old('name') }}">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-select name="office_id" label="Kantor Cabang" igroup-size="sm" class="selectpicker"
                           data-live-search="true">
            <x-adminlte-options :options="$offices" placeholder="Pilih Kantor Cabang"/>
        </x-adminlte-select>


        <x-adminlte-input name="nip" label="NIP" placeholder="xx.xx.xxxx" igroup-size="sm" maxlength="10" id="nip"
                          value="{{ old('nip') }}">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="domain_name" label="User Domain" placeholder="Masukan User Domain" igroup-size="sm"
                          value="{{ old('domain_name') }}">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="phone" label="No. HP" placeholder="08122334455" igroup-size="sm" type="number"
                          value="{{ old('phone') }}">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="email" label="Email" placeholder="Masukan Email" igroup-size="sm" type="email"
                          value="{{ old('email') }}">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="password" label="Password" igroup-size="sm" type="password">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>

        <x-adminlte-input name="password_confirmation" label="Konfirmasi Password" igroup-size="sm" type="password">
            <x-slot name="appendSlot">
                <div class="input-group-text ">
                </div>
            </x-slot>
        </x-adminlte-input>
        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop
