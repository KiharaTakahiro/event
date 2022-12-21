@extends('master.master')
@section('pageTitle') | イベント情報詳細 @stop
@section('body')
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベント情報</h4>

    <div class ="card-body">
    <blockquote class="blockquote mb-0">
        <p class="card-text">イベントの情報です。</p>
        <p class="card-text">このイベントの登壇者などの詳細な情報の編集は
        <a href="detailAddPage?eventCd={{$event->event_cd}}">こちら</a>から行えます。</p>
        <p class="card-text">新しくイベントを作成する場合は<a href="EventCreate">こちら</a>から行ってください。</p>
    </blockquote>
    <br>
    <table id ="eventTable" class = "table table-bordered">
        <tr>
            <th class="table-info">イベント名</th>
            <td>{{$event->event_name}}</td>
        </tr>
        <tr>
            <th class="table-info">登壇者</th>
            <td>
                @foreach($eventActor as $actor)
                @if($actor->actor_name != null && $actor->actor_name !='')
                    <p class="card-text"><a href="getDetailActorInfo?actorCd={{$actor->actor_cd}}">{{$actor->actor_name}}</a></p> 
                @endif
                @if($actor->unit_name != null && $actor->unit_name != '')
                    <p class="card-text"><a href="getDetailUnitInfo?unitCd={{$actor->unit_cd}}">{{$actor->unit_name}}</a></p>
                @endif 
                @endforeach
                <p class="card-text">登壇者の追加は<a href="detailAddPage?eventCd={{$event->event_cd}}#actorContent">こちら</a>から行えます。</p>
            </td>
        </tr>
        <tr>
            <th class="table-info">開催日</th>
            <td>{{$event->event_date}}</td>
        </tr>
        <tr>
            <th class="table-info">開演時間</th>
            <td>{{$event->event_start_time}}</td>
        </tr>
        <tr>
            <th class="table-info">公式ホームページ</th>
            <td><a href ={{$event->event_url}}>{{$event->event_url}}</a></td>
        </tr>
        <tr>
            <th class="table-info">チケット価格</th>
            <td>{{$event->price}}</td>
        </tr>
        <tr>
            <th class="table-info">チケット当落発表日</th>
            <td>{{$event->ticket_touraku_date}}</td>
        </tr>
        <tr>
            <th class="table-info">概要</th>
            <td>{{$event->event_comment}}</td>
        </tr>

    </table>
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">会場情報</h4>
    <div class ="card-body">
        <p class="card-text">会場名:{{$aria->aria_name}}</p>
        <p class="card-text">住所：{{$aria->adress}}</p>
        <div id = "map"></div>
    </div>
</div>
<br>
@isset($productLst)
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">物販情報</h4>
    <div class ="card-body">
    <blockquote class="blockquote mb-0">
        <p class="card-text">物販に関する情報です。</p>
        <p class="card-text">物販で完売したら一覧内の完売ボタンを押してください。</p>
        <p class="card-text">物販情報の追加は<a href="detailAddPage?eventCd={{$event->event_cd}}#salesContent">こちら</a>から行ってください。</p>
    </blockquote>
        <p class="card-text">・物販一覧</p>
        <table id="salesResult" class="table table-striped tagle-bordered">
        <thead>
            <th class="table-info">商品名</th>
            <th class="table-info">価格</th>
            <th class="table-info">完売</th>
        </thead>
        <tbody>
        <?php $tanka = 0; ?>
        @foreach($productLst as $product)
            <tr>
                <td>{{$product->sales_name}}</td>
                <td>{{$product->price}}</td>
                @if($product->sold_out_flg == "0")
                <td><input type="button" onclick = "soldOut('{{$product->sales_cd}}');" value ="完売" /></td>
                @else
                <td>完売しました&nbsp;<input type="button" onclick = "cansel('{{$product->sales_cd}}');" value ="取消" /></td>
                @endif
                <?php $tanka = $tanka + $product->price; ?>
            </tr>
        @endforeach
        </tbody>
        </table>
        <br>
        <p class="card-text">総合計金額:<input type="text" value = {{$tanka}} disabled = "true"></p>
        ※総合計金額はすべての商品を1つずつ購入した場合の金額
        <br>
        <p class="card-text">・物販情報の詳細</p>
        <div id="carouselExampleIndicators" class="carousel slide" style ="max-width:800px; margin-left:7px;" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $i = 0; ?>
            @foreach($productLst as $product)
                @if($i == 0)
                    <li data-target="#carouselExampleIndicators" data-slide-to={{$i}} class="active"></li>
                @else
                    <li data-target="#carouselExampleIndicators" data-slide-to={{$i}}></li>
                @endif
                <?php ++$i; ?>
            @endforeach
        </ol>
        <div class="carousel-inner">
            <?php $i = 0; ?>
            @foreach($productLst as $product)
                @if($i == 0)
                    <div class="carousel-item active">
                        <table class = "table table-bordered">
                            <tr>
                                <th class="table-info">商品名</th>
                                <td>{{$product->sales_name}}</td>
                            </tr>
                            <tr>
                                <th class="table-info">画像</th>
                                <td><img src={{"../images/".$event->event_cd."/".$product->file_name}}></td>
                            </tr>
                            <tr>
                                <th class="table-info">価格</th>
                                <td>{{$product->price}}</td>
                            </tr>
                        </table>
                    </div>
                @else
                    <div class="carousel-item">
                    <table class = "table table-bordered">
                            <tr>
                                <th class="table-info">商品名</th>
                                <td>{{$product->sales_name}}</td>
                            </tr>
                            <tr>
                                <th class="table-info">画像</th>
                                <td><img src={{"../images/".$event->event_cd."/".$product->file_name}}></td>
                            </tr>
                            <tr>
                                <th class="table-info">価格</th>
                                <td>{{$product->price}}</td>
                            </tr>
                        </table>
                    </div>
                @endif
                <?php ++$i; ?>
            @endforeach
        </div>
        <br><br>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="sr-only">Next</span>
        </a>
        </div>
    </div>
</div>
@endisset
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">セットリスト情報</h4>
    <div class ="card-body">
    <blockquote class="blockquote mb-0">
        <p class="card-text">セットリストの情報です。</p>    
        <p class="card-text">イベントが終わったらセットリストを追加してください。</p>
        <p class="card-text">セットリストの追加は<a href="detailAddPage?eventCd={{$event->event_cd}}#setListContent">こちら</a>から行うことができます。</p>    
    </blockquote>
    <br>
        <table id="musicResult" class="table table-striped tagle-bordered">
        <thead><th class="table-info">曲名</th></thead>
            @foreach($setLst as $set)
            <tr>
                <td>
                {{$set->song_title}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

@stop
@section('bodyScriptAfter')
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <!-- DataTables -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
  $(function(){
    $('#salesResult').DataTable();
    $('#musicResult').DataTable();
  });

function soldOut(salesCd){
        $.post("soldOut" ,
            {
                eventCd    : '{{$event->event_cd}}',
                salesCd    :salesCd,
                _token: '{{ csrf_token() }}'
            });
        location.reload();
    }
    function cansel(salesCd){
        $.post("cansel" ,
            {
                eventCd    : '{{$event->event_cd}}',
                salesCd    :salesCd,
                _token: '{{ csrf_token() }}'
            });
        location.reload();
    }
    function initMap() {
        // マップの初期化
        var latlng = new google.maps.LatLng({{$aria->latitude}},{{$aria->longitude}});
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 17,
            center: latlng
        });
        var markerOptions = {
            position : latlng,
            map : map
        };
        var marker = new google.maps.Marker(markerOptions);
    }
</script>
<!--  Google Maps Plugin  -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXlwEWLCWxInk2Ya4XIGQdMocZNKnqymE&callback=initMap"
    async defer></script>
@stop