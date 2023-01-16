<html>
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet"/>
    <style>
        ul.list-top li:not(:last-child) {
            margin-right: 1.5rem;
        }
    </style>
</head>
<body>
<!-- Navigation-->
<nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="#!">
            <img src="https://www.bankbjb.co.id/files//2021/11/logo-bjb-default.png"
                 class="img-fluid" width="106px"></a>
        <ul class="list-linline list-top">
            <li class="list-inline-item">
                <a href="https://www.bankbjb.co.id/page/tentang-bank-bjb" class="text-decoration-none">
                    Tentang bank bjb
                </a>
            </li>
            <li class="list-inline-item">
                <a href="https://www.bankbjb.co.id/" class="text-decoration-none">bank bjb</a>
            </li>
        </ul>
    </div>
</nav>
<header class="masthead">
{{--    <div class="container position-relative">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-xl-6">--}}
{{--                <div class="text-center text-white">--}}
{{--                    <h2 class="mb-5 text-uppercase">Tiket tersedia <br/>3.400</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="container">
        <div class="text-white min-vh-100">
            <div class="position-relative">
                <div class="position-absolute top-0 start-0">sadf</div>
                <div class="position-absolute top-0 end-0">ahaha</div>
                <div class="position-absolute top-50 start-50">ghege</div>
                <div class="position-absolute bottom-50 end-50"></div>
                <div class="position-absolute bottom-0 start-0"></div>
                <div class="position-absolute bottom-0 end-0"></div>
            </div>
        </div>
    </div>
</header>
@include('layout.partials.footer')
</body>
</html>