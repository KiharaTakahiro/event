@extends('master.master')
@section('pageTitle') | CD情報 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    @if(isset($actor->actor_name))
        <h4 class="card-header card-header-info">声優情報</h4>
    @else
        <h4 class="card-header card-header-info">ユニット情報</h4>
    @endif
    <div class ="card-body">
    @if(isset($actor->actor_name))
        <p>声優名：{{$actor->actor_name}}</p>
    @else
        <p>ユニット名:{{$actor->unit_name}}</p>
    @endif
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">CD情報</h4>
    <div class ="card-body">
        @if(isset($actor->actor_name))
            <p>このCDの楽曲情報は<a href="getAddMusicPage?actorCd={{$actor->actor_cd}}&cdCd={{$cd->cd_cd}}">こちら</a>から追加できます</p>
        @else
            <p>このCDの楽曲情報は<a href="getAddMusicPage?unitCd={{$actor->unit_cd}}&cdCd={{$cd->cd_cd}}">こちら</a>から追加できます</p>
        @endif
        <table class ="table table-bordered">
            <tr>
                <th class="table-info"> CD名</th>
                <td>{{$cd->cd_name}}</td>
            </tr>
            <tr>
                <th class="table-info"> 発売日</th>
                <td>{{$cd->relese_date}}</td>
            </tr>
            <tr>
                <th class="table-info"> 価格</th>
                <td>{{$cd->price}}</td>
            </tr>
            <tr>
                <th class="table-info"> シングル/アルバム</th>
                @if($cd->cd_kbn=="01")
                    <td> シングル</td>
                @else
                    <td> アルバム</td>
                @endif
            </tr>

        </table>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">楽曲情報</h4>
    <div class ="card-body">
        <table id="musicResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">曲名</th>
                <th class="table-info">公式MV</th>
            </thead>
            <tbody>
                @foreach($musicLst as $music)
                    <tr>
                        <td>{{$music->music_name}}</td>
                        <td><a href="{{$music->url}}">{{$music->url}}</a></td>
                    </tr>
                @endforeach
            </tbody>
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
    $('#musicResult').DataTable();

  });
  </script>
@stop