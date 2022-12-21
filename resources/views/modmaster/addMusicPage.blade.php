@extends('master.master')
@section('pageTitle') | 楽曲情報登録 @stop
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
        <p>ユニット名：{{$actor->unit_name}}</p>
    @endif
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">CD情報</h4>
    <div class ="card-body">
    @if(isset($actor->actor_name))
    <p>この声優のCD情報の追加は<a href="addActorDetailInfo?actorCd={{$actor->actor_cd}}">こちら</a>から行えます。
    @else
    <p>この声優のCD情報の追加は<a href="addUnitDetailInfo?unitCd={{$actor->unit_cd}}">こちら</a>から行えます。
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
    <h4 class="card-header card-header-info">楽曲情報の登録</h4>
    <div class ="card-body">
    <form method="POST" action="addMusic" enctype="multipart/form-data">
        <p>曲名:
           <input id="musicName" name="musicName" class="form-control" type="text" placeholder="曲名" aria-label="musicName" required>
        </p>
        <p>公式MVのURL※公式のみとしてください:
           <input id="url" name="url" class="form-control" type="url" placeholder="公式MVのURL" aria-label="url" >
        </p>
        @if(isset($actor->actor_name))
            <input type = "hidden" name = "addMusicActorCd" value = {{$actor->actor_cd}}>
        @else
            <input type = "hidden" name = "addMusicUnitCd" value = {{$actor->unit_cd}}>
        @endif
        <input type = "hidden" name = "addMusicCdCd" value = {{$cd->cd_cd}}>
        <input type ="hidden" name="_token" value ="{{csrf_token()}}">
        <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
    <div>登録済の楽曲はこちら</div>
    <table id="musicResult" class="table table-striped tagle-bordered">
    <thead>
        <th class="table-info">曲名</th>
    </thead>
    <tbody>
        @foreach($musicLst as $music)
            <tr><td>{{$music->music_name}}</td></tr>
        @endforeach
    </tbody>
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