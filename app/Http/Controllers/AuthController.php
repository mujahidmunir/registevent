<?php

namespace App\Http\Controllers;

use App\Mail\ResetMail;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) return view('adminlte::auth.login');
        $attempt = Auth::attempt([
            'domain_name' => $request->input('domain_name'),
            'password' => $request->input('password'),
        ]);

        if ($attempt) {
            if (!Auth::user()->active) {
                flash('User belum diaktifkan', 'warning');
                Auth::logout();
                return redirect()->back();
            }

            if(!Auth::user()->is_admin){
                Session::put("popup", true);
            }

            $route = Auth::user()->is_admin ? route('admin.dashboard') : route('cs.dashboard');
            return redirect($route);
        }

        flash('User/Password tidak sesuai', 'danger');
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            $offices = Office::query()->orderBy('name', 'asc')->pluck('name', 'id')->toArray();
            return view('adminlte::auth.register', compact('offices'));
        }

        $data = $request->except('_token');
        $validator = Validator::make($data, [
            'name' => 'required',
            'office_id' => 'required|integer',
            'nip' => 'required|min:10|max:10|unique:users,nip',
            'domain_name' => 'required|unique:users,domain_name',
            'phone' => 'required|numeric|digits_between:10,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        if ($validator->fails()) {
            flash($validator->messages()->first(), 'danger');
            return redirect()->back()->withInput();
        }

        try {
            User::create([
                'name' => $data['name'],
                'office_id' => $data['office_id'],
                'domain_name' => $data['domain_name'],
                'nip' => $data['nip'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (\Exception $exception) {
            flash($exception->getMessage(), 'danger');
            return redirect()->back()->withInput();
        }

        flash('Mohon tunggu sampai akun anda diaktifkan');
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function forgot(Request $request)
    {
        if ($request->isMethod('get')) return view('adminlte::auth.passwords.email');
        $request->validate(['email' => 'required|email']);
        $token = md5(now()->timestamp . Str::random('10'));
        $email = $request->input('email');

        $user = User::whereEmail($email)->first();

        if (!$user) {
            flash('Email tidak terdaftar', 'danger');
            return redirect()->back()->withInput();
        }

        try {
            $user->update([
                'remember_token' => $token
            ]);

            Mail::to($user->email)
                ->send(new ResetMail($email, $token));

            flash('Cek di inbox/spam pada email anda', 'info');
            return redirect()->back();
        } catch (\Exception $exception) {
            flash($exception->getMessage(), 'danger');
            return redirect()->back()->withInput();
        }
    }

    public function reset(Request $request)
    {
        $user = User::whereRememberToken($request->get('token'))->firstOrFail();

        if ($request->isMethod('get')) return view('pages.reset');

        $user->update([
            'password' => Hash::make($request->input('password')),
            'remember_token' => null
        ]);


        flash('Ganti password berhasil', 'info');
        return redirect(route('login'));
    }
}
