@extends('master.master')
@section('pageTitle') | 声優情報検索 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">声優情報検索</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">声優とユニットごとの情報を検索できます。</p>
            <p class="card-text">声優を検索したい場合は声優検索ボタンを押下してください。</p>
            <p class="card-text">ユニットを検索したい場合はユニット検索ボタンを押下してください。</p>
            <p class="card-text">あいまい検索されるため、すべて入力しなくても表示されます。</p>
            <p class="card-text">入力欄が空の場合はすべての声優、ユニットが表示されます。</p>
        </blockquote>
        <br>
        <div class="active-cyan-4 mb-4">
            <h5>声優検索</h5>
            <input  id="actorName" name="actorName" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" />
            <p class="card-text">声優情報の追加は<a href="addActorInfo">こちら</a>から行ってください。</p>
        </div>
        <button type="submit" onclick="searchActorBtnClick();" class="btn btn-info btn-rounded">声優検索</button>
        <div class="active-cyan-4 mb-4">
            <h5>ユニット検索</h5>
            <input  id="unitName" name="unitName" class="form-control selectpicker" type="text" placeholder="ユニット名" aria-label="unitName" />
            <p class="card-text">ユニット情報の追加は<a href="addUnitInfo">こちら</a>から行ってください。</p>
        </div>
        <button type="submit" onclick="searchUnitBtnClick();" class="btn btn-info btn-rounded">ユニット検索</button>
    </div>
</div>
<br/>
<div id ="resultAria">

</div>

@stop
@section('bodyScriptAfter')
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <!-- DataTables -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
    function searchActorBtnClick() {
        $.post("getActorPageLst" ,
            {
                actorName    : $("#actorName").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#actorResult').DataTable();});
    }
    function searchUnitBtnClick() {
        $.post("getUnitPageLst" ,
            {
                actorName    : $("#unitName").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#unitResult').DataTable();});
            
    }
</script>
@stop