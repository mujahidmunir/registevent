@push('css')
    <style>
        ol {
            list-style-type: none;
            counter-reset: item;
            margin: 0;
            padding: 0;
        }

        ol > li {
            display: table;
            counter-increment: item;
            margin-bottom: 0.6em;
        }

        ol > li:before {
            content: counters(item, ".") ". ";
            display: table-cell;
            padding-right: 0.6em;
        }

        li ol > li {
            margin: 0;
        }

        li ol > li:before {
            content: counters(item, ".") ". ";
        }
    </style>
@endpush
<ol>
    <li><strong>Pembelian Tiket</strong>
        <ol>
            <li>Pastikan Alamat E-mail & Nomor Handphone terdaftar Whatsapp dan aktif untuk pengiriman e-tiket</li>
            <li>E-tiket akan dikirimkan setiap hari <strong>Rabu</strong> & <strong>Jum’at</strong> dari loket.com
                kepada nasabah sesuai yang di daftarkan
            </li>
            <li><strong>Untuk pembelian lebih dari 1 tiket diwajibkan scan pembayaran sesuai dengan jumlah
                    tiket</strong> e.x : pembeli membeli 2 tiket, maka wajib melakukan scan pembayaran 2 kali</li>
            <li>E-tiket mohon untuk tidak disebarluaskan / di update di sosial media. Jika terjadi kebocoran data
                diakibatkan hal tesebut / kehilangan e-tiket yang menyebabkan tiket tidak dapat digunakan, maka <strong>bukan
                    menjadi tanggung jawab panitia</strong></li>
            <li>Untuk menghindari masalah teknis jaringan di lokasi mohon untuk e-tiket dapat di print terlebih dahulu
                sebelum masuk lokasi
            </li>
            <li>Apabila terjadi kesalahan pembayaran yang disebabkan kesalahan pribadi, maka akan menjadi tangung jawab
                masing-masing
            </li>
        </ol>
    </li>

    <li><strong>Flow Pembelian Tiket</strong>
        <ol>
            <li>
                Offline (New Customer / New Account)
                <img class="image img-fluid" src="{{url('assets/images/ketentuan1.jpg?v=2')}}">
            </li>
            <li>Offline (Existing Customer)
                <img class="image img-fluid" src="{{url('assets/images/ketentuan2.jpg?v=2')}}">
            </li>
            <li>
                Online (Playlistlivefestival.com / loket.com)
                <img class="image img-fluid" src="{{url('assets/images/ketentuan3.jpg?v=2')}}">
            </li>

        </ol>
    </li>
    <li><strong>Penukaran Tiket</strong>
        <ol>
            <li><strong>Wajib membawa identitas diri sesuai dengan pendaftaran saat penukaran tiket</strong></li>
            <li>Apabila penukaran tiket diwakilkan oleh orang lain, wajib menyertakan <strong>surat kuasa penukaran
                    tiket</strong></li>
            <li>Penerima kuasa wajib melampirkan fotokopi identitas pemberi kuasa</li>
            <li>Siapkan barcode konfirmasi pembelian online anda (wajib di print untuk arsip panitia)</li>
        </ol>
    </li>
    <li><strong><a href="{{route('download.suratKuasa')}}">Download Contoh Surat Kuasa</a></strong></li>
</ol>