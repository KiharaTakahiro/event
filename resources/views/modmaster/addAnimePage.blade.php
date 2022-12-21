@extends('master.master')
@section('pageTitle') | アニメ情報登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">アニメ情報登録</h4>
    <div class ="card-body">
    <blockquote class="blockquote mb-0">
        <p class="card-text">アニメ情報登録が行えます。</p>    
        <p class="card-text">アニメ情報登録後、再度この画面に遷移します。キャスト情報登録で検索し、登録されていることを確認してください。</p>
    </blockquote>
    <br>
    <form method="POST" action="addAnime" enctype="multipart/form-data">
        <p>アニメ名：
            <input id="animeName" name="animeName" class="form-control" type="text" placeholder="アニメ名" aria-label="animeName" required>
        </p>
        <p>開始日:
            <input id="startDate" name="startDate" class="form-control datetimepicker" type="date" placeholder="開始日" aria-label="startDate" >
        </p>
        <p>終了日:
            <input id="endDate" name="endDate" class="form-control datetimepicker" type="date" placeholder="終了日" aria-label="endDate" >
        </p>
        <p>概要:
        <textarea id="comment" name="comment" class="form-control" rows="5"></textarea>
        </p>
        <input type ="hidden" name="_token" value ="{{csrf_token()}}">
        <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
    </div>
</div>
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">キャスト情報登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">キャスト情報登録が行えます。</p>    
            <p class="card-text">アニメ情報を検索し、表示されるリンクから遷移した画面でキャスト情報を登録してください。</p>
        </blockquote>
        <br>
        <p>アニメ名：
            <input id="searchAnimeName" name="searchAnimeName" class="form-control" type="text" placeholder="アニメ名" aria-label="searchAnimeName" >
        </p>
        <button type="submit" onclick="searchBtnClick();" class="btn btn-info btn-rounded">検索</button>

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
    function searchBtnClick() {
        $.post("getAnimePageLst" ,
            {
                searchAnimeName    : $("#searchAnimeName").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#animeResult').DataTable();});
    }
</script>
@stop