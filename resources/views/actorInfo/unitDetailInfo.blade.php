@extends('master.master')
@section('pageTitle') | ユニット情報詳細 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ユニット情報</h4>
    <div class ="card-body">
    <p>ユニット名：{{$unit->unit_name}}</p>
    
    <table id="memberResult" class="table table-striped tagle-bordered">
       <thead> <th class="table-info">メンバー</th></thead>
        <tbody>
        @foreach($memberLst as $member)
            <tr><td>{{$member->actor_name}}</td></tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">最新ニュース</h4>
    <div class ="card-body">
    <p>ニュース情報は<a href="addUnitDetailInfo?unitCd={{$unit->unit_cd}}">こちら</a>から登録できます。</p>
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
<div id="cdContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">CD情報の登録</h4>
    <div class ="card-body">
    <br>
    <table id="cdResult" class="table table-striped tagle-bordered">
        <thead>
            <th class="table-info">
                シングル/アルバム
            </th>

            <th class="table-info">
                CD名
            </th>
        </thead>
       <tbody>
            @foreach($cdLst as $cd)
                <tr>
                    <td>
                    @if($cd->cd_kbn=='01')
                    シングル
                    @else
                    アルバム
                    @endif
 
                    </td>
                    <td>
                        <a href="getMusicInfo?unitCd={{$unit->unit_cd}}&cdCd={{$cd->cd_cd}}">{{$cd->cd_name}}</a>
                    </td>
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
    $('#memberResult').DataTable();
    $('#newsResult').DataTable();
    $('#eventResult').DataTable();
    $('#cdResult').DataTable();
  });
  </script>
@stop

