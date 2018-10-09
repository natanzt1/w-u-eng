<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets/images/favicon.png')}}">
    <title>Limited Access!</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1>403</h1>
                <h3 class="text-uppercase">System Isn't Available For You</h3>
                <p class="text-muted m-t-30 m-b-30">Sorry, this system is not available for you. <br>For more information please contact <b>SIMAK Universitas Hindu Indonesia Administration Support</b><br>Thank You</p>
                <hr>
                <p class="text-muted m-t-30 m-b-30">Maaf, sistem ini tidak tersedia untuk Anda. <br>Informasi lebih lanjut dapat menghubungi <b>SIMAK Universitas Hindu Indonesia Administration Support</b><br>Terima Kasih</p>
                <a href="http://127.0.0.1:8000/" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Kembali ke SSO</a> </div>
            <footer class="footer text-center">© 2018 Universitas Hindu Indonesia.</footer>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
</body>

</html>
