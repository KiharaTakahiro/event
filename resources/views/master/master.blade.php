<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=480">
      <meta name="keyword" content="声優,イベント">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta http-equiv="content-language" content="ja">
      <meta name="description" content="声優イベンター用の情報共有サイトです。自分の好きな声優の情報を共有できるようになります。">
      <meta name="twitter:card" content="summary">
      <meta name="twitter:site" content="@05sSKlFpAlSgZkm" />
      <meta property="og:site_name" content="声の推しごと" />
      <meta property="og:url" content="http://www.koenooshigoto.net/" />
      <meta property="og:title" content="声の推しごと" />
      <meta property="og:description" content="声優イベンター用の情報共有サイトです。自分の好きな声優の情報を共有できるようになります。" />
      <meta property="og:image" content="rogo.png" />
      @yield('meta')
      <title>声の推しごと@yield('pageTitle')</title>
      <link rel="shortcut icon" href="rogo.png" type="image/png">
      <!--     Fonts and icons     -->

      @yield('css')
      @yield('headScript')
  </head>

  <body>
    @yield('bodyScriptBfore')
    <nav class="navbar navbar-expand-lg bg-info">
      <div class="container">
          <div class="navbar-translate" >
              <h1 class="navbar-brand">声の推しごと</h1>
              <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="sr-only"></span>
                  <span class="navbar-toggler-icon"></span>
                  <span class="navbar-toggler-icon"></span>
                  <span class="navbar-toggler-icon"></span>
              </button>
          </div>

          <div class="collapse navbar-collapse">
              <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                      <a href="/" class="nav-link">
                          Topページ
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="EventSearch" class="nav-link">
                          イベント検索
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="EventCreate" class="nav-link">
                          イベント作成
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="Private" class="nav-link">
                          個人ページ
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="searchActorInfoTop" class="nav-link">
                          声優情報
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="modMaster" class="nav-link">
                          その他情報編集
                      </a>
                  </li>
              </ul>
          </div>
      </div>
   </nav>
      @yield('body')
      
        <!--   Core JS Files   -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <link href="assets/css/material-kit.css?v=2.0.4" rel="stylesheet" />
        <link href="css/common.css" rel="stylesheet" />
        <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
        <script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
        <script src="assets/js/plugins/moment.min.js"></script>
        <!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker -->
        <script src="assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Kit: parallax effects, scripts for the example pages etc -->
        <script src="assets/js/material-kit.js?v=2.0.4" type="text/javascript"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
        <script type="text/javascript">$('select').select2();</script>
      @yield('bodyScriptAfter')
  </body>

</html>