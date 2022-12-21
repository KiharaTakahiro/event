@extends('master.master')
@section('pageTitle') | 声優情報詳細 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">声優情報</h4>
    <div class ="card-body">
    <p>この声優の情報は<a href="addActorDetailInfo?actorCd={{$actor->actor_cd}}">こちら</a>から更新できます。</p>
    <p>声優名：{{$actor->actor_name}}</p>
    @isset($actor->sex)
        <p>性別：{{$actor->sex}}</p>
    @endisset
    @isset($actor->birth_day)
        <p>生年月日：{{$actor->birth_day}}</p>
    @endisset
    @isset($actor->birth_place)
        <p>出身地：{{$actor->birth_place}}</p>
    @endisset
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">最新ニュース</h4>
    <div class ="card-body">
    <p>ニュース情報は<a href="addActorDetailInfo?actorCd={{$actor->actor_cd}}">こちら</a>から登録できます。</p>
        <table id="newsResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">URL</th>
                <th class="table-info">概要</th>
            </thead>
            <tbody>
            @foreach($newsLst as $news)
                <tr>
                    <td><a href ="{{$news->url}}">{{$news->news_title}}</a></td>
                    <td>{{$news->memo}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベント情報</h4>
    <div class ="card-body">
        <p>イベントの追加は<a href="EventCreate">こちら</a>から行ってください</p>
        <table id="eventResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">開催日</th>
                <th class="table-info">イベント名</th>
            </thead>
            <tbody>
            @foreach($eventLst as $event)
                <tr>
                    <td>{{$event->event_date}}</td>
                    <td><a href ="eventdetail?eventCd={{$event->event_cd}}">{{$event->event_name}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">アニメ出演情報</h4>
    <div class ="card-body">
    <p>アニメ情報の追加は<a href="getAnimeAddpage">こちら</a>から行ってください</p>
        <table id="animeResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">アニメ名</th>
                <th class="table-info">キャラクター</th>
            </thead>
            <tbody>
            @foreach($animeLst as $anime)
                <tr>
                <td>{{$anime->anime_name}}</td>
                <td>{{$anime->chara_name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">CD情報</h4>
    <div class ="card-body">
    <p>CD情報の追加は<a href="addActorDetailInfo?actorCd={{$actor->actor_cd}}">こちら</a>から行ってください</p>
        <table id="cdResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">発売日</th>
                <th class="table-info">シングル/アルバム</th>
                <th class="table-info">CD名</th>
            </thead>
            <tbody>
                @foreach($cdLst as $cd)
                    <tr>
                        <td>{{$cd->relese_date}}</td>
                        @if($cd->cd_kbn=="01")
                            <td>シングル</td>
                        @else
                            <td>アルバム</td>
                        @endif
                        <td><a href="getMusicInfo?actorCd={{$actor->actor_cd}}&cdCd={{$cd->cd_cd}}">{{$cd->cd_name}}</a></td>
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
    $('#newsResult').DataTable();
    $('#eventResult').DataTable();
    $('#animeResult').DataTable();
    $('#cdResult').DataTable();

  });
  </script>
@stop