@extends('master.master')
@section('pageTitle') | 個人ページトップ @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ユーザ情報表示</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">ユーザ用のページです。</p>
        </blockquote>
        <br>
        <p>
            ユーザコード：{{$userCd}}
        </p>
        <form method="POST" action="logout" enctype="multipart/form-data">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">ログアウト</button>
        </form>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">お気に入り声優の直近イベント</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">お気に入り声優、ユニットに登録した最新20件のイベントを表示します。</p>
            <p class="card-text">お気に入り声優とユニットの登録は、本画面の下部から行えます。</p>
        </blockquote>

        <table id="eventResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">開催日</th>
                <th class="table-info">イベント名</th>
                <th class="table-info">声優/ユニット</th>
            </thead>
            <tbody>
            @foreach($faboliteLst as $fabolite)
                <tr>
                    <td>{{$fabolite->event_date}}</td>
                    <td>{{$fabolite->event_name}}</td>
                    @if(isset($fabolite->actor_name) && $fabolite->actor_cd != '000000')
                        <td>{{$fabolite->actor_name}}</td>
                    @endif
                    @if(isset($fabolite->unit_name) && $fabolite->unit_cd != '000000')
                        <td>{{$fabolite->unit_name}}</td>
                    @endif

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">お気に入り声優登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">お気に入り声優を登録することができます。</p>
        </blockquote>
        <br>
        <form method="POST" action="matchActor" enctype="multipart/form-data">
        <p>
            声優名：
            <select id="actorCd" name="actorCd" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
                @foreach($actorLst as $actor)
                    <option value = "{{$actor->actor_cd}}">{{$actor->actor_name}}</option>
                @endforeach
            </select>
            声優の追加は<a href="addActorInfo">こちら</a>からおこなってください
        </p>
        <p>
            お気に入り度：
            <select id="rank" name="rank" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
                @foreach($rankLst as $rank)
                    <option value ="{{$rank->intvalue}}">{{$rank->cd_value}}</option>
                @endforeach
            </select>

        </p>
            <input type ="hidden" name="userCd" value ="{{$userCd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">登録</button>
        </form>
        <br>
        <p>登録済みのお気に入り声優</p>
        <table id="actorResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">声優名</th>
                <th class="table-info">お気に入り度</th>
            </thead>
            <tbody>
            @foreach($faboliteActorLst as $faboliteActor)
                <tr>
                    <td>{{$faboliteActor->actor_name}}</td>
                    <td>
                        @foreach($rankLst as $rank)
                            @if($faboliteActor->rank == $rank->intvalue)
                                {{$rank->cd_value}}
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">お気に入りユニット登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">お気に入りユニットを登録することができます。</p>
        </blockquote>
        <br>
        <form method="POST" action="matchActor" enctype="multipart/form-data">
        <p>
            ユニット名：
            <select id="unitCd" name="unitCd" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
                @foreach($unitLst as $unit)
                    <option value = "{{$unit->unit_cd}}">{{$unit->unit_name}}</option>
                @endforeach
            </select>
            ユニットの追加は<a href="addUnitInfo">こちら</a>からおこなってください
        </p>
        <p>
            お気に入り度：
            <select id="rank" name="rank" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
                @foreach($rankLst as $rank)
                    <option value ="{{$rank->intvalue}}">{{$rank->cd_value}}</option>
                @endforeach
            </select>

        </p>
            <input type ="hidden" name="userCd" value ="{{$userCd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">登録</button>
        </form>
        <p>登録済みのお気に入りユニット</p>
        <table id="unitResult" class="table table-striped tagle-bordered">
            <thead>
                <th class="table-info">ユニット名</th>
                <th class="table-info">お気に入り度</th>
            </thead>
            <tbody>
            @foreach($faboliteUnitLst as $faboliteUnit)
                <tr>
                    <td>{{$faboliteUnit->unit_name}}</td>
                    <td>
                        @foreach($rankLst as $rank)
                            @if($faboliteUnit->rank == $rank->intvalue)
                                {{$rank->cd_value}}
                            @endif
                        @endforeach
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
    $('#eventResult').DataTable();
    $('#actorResult').DataTable();
    $('#unitResult').DataTable();

  });
  </script>
@stop
