@extends('master.master')
@section('pageTitle') | 会場情報登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベント会場の追加</h4>
    <div class ="card-body">
        <form method="POST" action="addAria" enctype="multipart/form-data">
            <p>
                県：
                <select id="prefectureCd" name="prefectureCd" class="form-control" type="text" placeholder="県" aria-label="prefecture" >
                @foreach($prefectureLst as $prefecture)
                    <option value ="{{$prefecture->prefecture_cd}}">{{$prefecture->prefecture}}</option>
                @endforeach
                </select>
            </p>
            <p>
                会場名：
                <input id="ariaName" name="ariaName" class="form-control" type="text" placeholder="会場名" aria-label="placeName" >
            </p>
            <p>
                住所(※すでに県を入力済みですが、県から入力ください):
                <input id="adress" name="adress" class="form-control" type="text" placeholder="住所" aria-label="adress" >
                ※会場の位置は下のマップをクリックで選択できます。住所を反映ボタンを押すと住所の位置に移動します。
                <button type="button" onclick="getLatLng();" class="btn btn-info btn-rounded">住所を反映</button>
                <div id = "map"></div>
                <input type ="hidden" id="lat" name="lat" value ="">
                <input type ="hidden" id="lng" name="lng" value ="">
            </p>
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">会場を追加</button>
        </form>
    </div>
</div>

@stop
@section('bodyScriptAfter')
<script>
    function initMap() {

        // マップの初期化
        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat: 36.38992, lng: 139.06065}
        });

        // クリックイベントを追加
        map.addListener('click', function(e) {
            getClickLatLng(e.latLng, map);
        });
    }

    function getClickLatLng(lat_lng, map) {

        // 座標を表示
        document.getElementById('lat').value = lat_lng.lat();
        document.getElementById('lng').value = lat_lng.lng();

       // マーカーを設置
        var marker = new google.maps.Marker({
        position: lat_lng,
        map: map
        }); 

        // 座標の中心をずらす
        // http://syncer.jp/google-maps-javascript-api-matome/map/method/panTo/
        map.panTo(lat_lng);
    }


        function getLatLng() {
        //一度マップを初期化する
        // マップの初期化
        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: {lat: 36.38992, lng: 139.06065}
        });

        // クリックイベントを追加
        map.addListener('click', function(e) {
            getClickLatLng(e.latLng, map);
        });

        // ジオコーダのコンストラクタ
        var geocoder = new google.maps.Geocoder();
            geocoder.geocode(
            {
            'address': $('#adress').val(),
            'region': 'jp'
            },
            function(results, status){
                if(status==google.maps.GeocoderStatus.OK){
                    var bounds = new google.maps.LatLngBounds();

                    for (var i in results) {
                        if (results[i].geometry) {

                            // 緯度経度を取得
                            var latlng = results[i].geometry.location;
                            getClickLatLng(latlng, map);
                            // 住所を取得(日本の場合だけ「日本, 」を削除)
                            var address = results[0].formatted_address.replace(/^日本, /, '');
                            bounds.extend(latlng);

                            
                        }
                    }

                    // 範囲を移動
                    map.fitBounds(bounds);
                }
            }
);
        }
    function searchBtnClick() {
        $.post("searchActor" ,
            {
                actorName    : $("#serchActorName").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } );
    }
</script>
<!--  Google Maps Plugin  -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXlwEWLCWxInk2Ya4XIGQdMocZNKnqymE&callback=initMap"
    async defer></script>

@stop