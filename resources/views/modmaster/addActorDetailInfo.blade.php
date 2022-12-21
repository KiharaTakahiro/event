@extends('master.master')
@section('pageTitle') | 声優情報詳細登録 @stop

@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">声優情報</h4>
    <div class ="card-body">
    <p>声優名：{{$actor->actor_name}}</p>
    </div>
</div>
<br/>
<div id="newsContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">最新ニュース</h4>
    <div class ="card-body">
    <form  method="POST" action="addNews" enctype="multipart/form-data">
        <p> ニュースのURL:
            <input id="newsurl" name="newsurl" class="form-control" type="url" placeholder="ニュースのURL" aria-label="newsurl" required>
        </p>
        <p> ニュースのタイトル:
            <input id="newstitle" name="newstitle" class="form-control" type="text" placeholder="ニュースのタイトル" aria-label="newstitle" required >
        </p>
        <p> ニュースの概要:
            <input id="newsmemo" name="newsmemo" class="form-control" type="text" placeholder="ニュースの概要" aria-label="newsmemo" >
        </p>
        <input type = "hidden" name = "newsActorCd" value = {{$actor->actor_cd}}>
        <input type ="hidden" name="_token" value ="{{csrf_token()}}">
        <button type="submit" class="btn btn-info btn-rounded">登録</button>

    </form>
    </div>
</div>
<br/>
<div id="cdContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">CD情報の登録</h4>
    <div class ="card-body">
    <form method="POST" action="addMCd" enctype="multipart/form-data">
    <p> CD名:
        <input id="cdName" name="cdName" class="form-control" type="text" placeholder="CD名" aria-label="cdName" required>
    </p>
    <p> 発売日:
        <input type="date" id="date" name="date" class="form-control" placeholder="発売日" value="" aria-label="Date"/> 
    </p>
    <p> 価格:
        <input id="price" name="price" class="form-control" type="number" placeholder="価格" aria-label="price" >
    </p>
    <p>
        <div class="form-check form-check-radio">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="01" checked>
            シングル
            <span class="circle">
                <span class="check"></span>
            </span>
        </label>
    </div>
    <div class="form-check form-check-radio">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="02" >
            アルバム
            <span class="circle">
                <span class="check"></span>
            </span>
        </label>
    </div>
    </p>
    <input type = "hidden" name = "addMcdActorCd" value = {{$actor->actor_cd}}>
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
    <br>
    <div>楽曲情報の登録は下のリンクから</div>
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
                        <a href="getAddMusicPage?actorCd={{$actor->actor_cd}}&cdCd={{$cd->cd_cd}}">{{$cd->cd_name}}</a>
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
    $('#cdResult').DataTable();

  });
  </script>
@stop