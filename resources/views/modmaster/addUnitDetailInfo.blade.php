@extends('master.master')
@section('pageTitle') | ユニット情報詳細登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ユニット情報</h4>
    <div class ="card-body">
    <p>ユニット名：{{$unit->unit_name}}</p>

    <p>追加済みの声優はこちら</p>
    <table class ="table table-bordered">
    <th class="table-info">声優名</th>
    @foreach($memberLst as $member)
        <tr><td>{{$member->actor_name}}</td></tr>
    @endforeach
    </table>
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
            <input id="newstitle" name="newstitle" class="form-control" type="text" placeholder="ニュースのタイトル" aria-label="newstitle" required>
        </p>
        <p> ニュースの概要:
            <input id="newsmemo" name="newsmemo" class="form-control" type="text" placeholder="ニュースの概要" aria-label="newsmemo" >
        </p>
        <input type = "hidden" name = "newsUnitCd" value = {{$unit->unit_cd}}>
        <input type ="hidden" name="_token" value ="{{csrf_token()}}">
        <button type="submit" class="btn btn-info btn-rounded">登録</button>

    </form>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ユニットメンバーの追加</h4>
    <div class ="card-body">
    <form method="POST" action="addMUnitMember" enctype="multipart/form-data">
    <p> 声優名:
        <select id="actorName" name="actorName" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
            @foreach($actorLst as $actor)
                <option value ={{$actor->actor_cd}} >{{$actor->actor_name}}</option>
            @endforeach
        </select>
    </p>
    <input type ="hidden" name="unitCd" value ="{{$unit->unit_cd}}">
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <button type="submit" class="btn btn-info btn-rounded">声優のメンバーを追加</button>
    </form>
    </div>
</div>
<br>
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
        <input id="price" name="price" class="form-control" type="text" placeholder="価格" aria-label="price" >
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
    <input type = "hidden" name = "addMcdUnitCd" value = {{$unit->unit_cd}}>
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
    <br>
    <div>楽曲情報の登録は下のリンクから</div>
    <br>
    <table class ="table table-bordered">
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
                        <a href="getAddMusicPage?unitCd={{$unit->unit_cd}}&cdCd={{$cd->cd_cd}}">{{$cd->cd_name}}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@stop