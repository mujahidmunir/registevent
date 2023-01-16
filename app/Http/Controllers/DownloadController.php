<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function ketentuan()
    {
        return Storage::disk('public')->download('/Ketentuan-tiketing-digicash-playlist-live-festival-2.0.pdf');
    }

    public function suratKuasa()
    {
        return Storage::disk('public')->download('/surat-kuasa-digicash-playlist-live-festival-2.0.pdf');
    }
}
