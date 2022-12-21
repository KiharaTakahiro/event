@extends('master.master')
@section('pageTitle') | 声優情報登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">新規声優の追加</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">新規声優の追加を行うことができます。</p>
            <p class="card-text">詳細情報については登録後に詳細情報の登録で検索してください。</p>
            <p class="card-text">登録後はこの画面に再度遷移します。詳細情報の登録で検索し、登録されていることを確認してください。</p>
        </blockquote>
        <br>
        <form method="POST" action="addMVoiceActor" enctype="multipart/form-data">
            <p>
                声優名：
                <input id="actorName" name="actorName" class="form-control" type="text" placeholder="声優名" aria-label="salesName" required>
            </p>
            <p>
                声優名(ふりがな)：
                <input id="actorNameFurigana" name="actorNameFurigana" class="form-control" type="text" placeholder="声優名(ふりがな)" aria-label="price" >
            </p>
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">声優を追加</button>
        </form>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">詳細情報の登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">追加済みの声優の詳細情報を登録できます。</p>
            <p class="card-text">声優を検索し、検索後に表示されるリストのリンクを押して編集ページに移動してください。</p>
        </blockquote>
        <br>
        <p>
            声優名：
            <input id="serchActorName" name="serchActorName" class="form-control" type="text" placeholder="声優名" aria-label="salesName" >
        </p>
        <button onclick="searchBtnClick()" class="btn btn-info btn-rounded">声優を検索</button>
        <br/>
        <div id = "resultAria"></div>
    </div>
</div>

@stop
@section('bodyScriptAfter')
<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <!-- DataTables -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
    function searchBtnClick() {
        $.post("searchActor" ,
            {
                actorName    : $("#serchActorName").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#actorResult').DataTable();});
            
        }
</script>
@stop