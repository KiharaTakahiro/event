@extends('master.master')
@section('pageTitle') | アニメ情報詳細登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">アニメ情報</h4>
    <div class ="card-body">
    <p>アニメ名：{{$anime->anime_name}}</p>
    <p>追加済みのキャストはこちら</p>
    <table id="animeResult" class="table table-striped tagle-bordered">
        <thead>
            <th class="table-info">キャラクター</th>
            <th class="table-info">声優</th>
        </thead>
        @foreach($animeCastLst as $animeCast)
            <tr>
                <td>{{$animeCast->chara_name}}</td> 
                <td>{{$animeCast->actor_name}}</td> 
            </tr>
        @endforeach
    </table>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">キャスト情報の登録</h4>
    <div class ="card-body">
    <form method="POST" action="addAnimeCast" enctype="multipart/form-data">
    <p> 声優名:
        <select id="actorName" name="actorName" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
            @foreach($actorLst as $actor)
                <option>{{$actor->actor_name}}</option>
            @endforeach
        </select>
    </p>
    <p> キャラクタ名:
        <input type="text" id="charaName" name="charaName" class="form-control" placeholder="キャラクタ名" value="" aria-label="charaName" required/> 
    </p>
    <input type ="hidden" name="animeCd" value ="{{$anime->anime_cd}}">    
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
</div>


@stop
@section('bodyScriptAfter')
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <!-- DataTables -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $('#animeResult').DataTable();

  });
  </script>
@stop