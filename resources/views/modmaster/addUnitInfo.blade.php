@extends('master.master')
@section('pageTitle') | ユニット情報登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">新規ユニットの追加</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">新規ユニットの追加を行うことができます。</p>
            <p class="card-text">詳細情報については登録後に詳細情報の登録で検索してください。</p>
            <p class="card-text">登録後はこの画面に再度遷移します。詳細情報の登録で検索し、登録されていることを確認してください。</p>
        </blockquote>
        <br>
        <form method="POST" action="addMUnit" enctype="multipart/form-data">
            <p>
                ユニット名：
                <input id="unitName" name="unitName" class="form-control" type="text" placeholder="ユニット名" aria-label="unitName" required>
            </p>
            <p>
                ユニット名(ふりがな)：
                <input id="unitNameFurigana" name="unitNameFurigana" class="form-control" type="text" placeholder="ユニット名(ふりがな)" aria-label="unitName" >
            </p>
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">ユニットを追加</button>
        </form>
    </div>
</div>
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">詳細情報の登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">追加済みのユニットの詳細情報を登録できます。</p>
            <p class="card-text">ユニットを検索し、検索後に表示されるリストのリンクを押して編集ページに移動してください。</p>
        </blockquote>
        <br>
        <p>
            ユニット名：
            <input id="searchUnit" name="searchUnit" class="form-control" type="text" placeholder="ユニット名" aria-label="serchUnitName" >
        </p>
        <button onclick="searchBtnClick()" class="btn btn-info btn-rounded">ユニットを検索</button>
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
        $.post("searchUnit" ,
            {
                unitName    : $("#searchUnit").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#unitResult').DataTable();});
    }
</script>
@stop