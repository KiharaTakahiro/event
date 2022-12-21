@extends('master.master')
@section('pageTitle') | イベント情報検索 @stop
@section('body')
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベント検索</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">声優名、日付でイベントを検索できます。</p>
            <p class="card-text">検索ボタンを押下すると入力項目で絞り込まれた検索結果が表示されます。</p>
            <p class="card-text">それぞれの項目の入力は必須ではありません。空の場合はその条件で絞り込まれずに表示されます。</p>
        </blockquote>
        <div class="active-cyan-4 mb-4">
            <p class="card-text">声優で検索</p>
            <input id="actorName" name="actorName" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
        </div>
        <div class="active-cyan-4 mb-4">
            <p class="card-text">ユニットで検索</p>
            <input id="unitName" name="unitName" class="form-control selectpicker" type="text" placeholder="ユニット名" aria-label="ActorName" list="actorList">
        </div>
        <div class="active-cyan-4 mb-4" >
        <p class="card-text">日付で検索</p>
            <table>
                <td>
                    From:&nbsp;&nbsp;
                </td>
                <td>
                    <input type="date" name="fromDate" id="fromDate" class="form-control" placeholder="From日付で検索"  value="{{$nowDate}}" aria-label="Search"/>
                </td>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;～&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td>
                    To:&nbsp;&nbsp;
                </td>
                <td>
                    <input type="date" id="toDate" name="toDate" class="form-control" placeholder="To日付で検索" value=""  aria-label="Search"/>
                </td>
            </table>
        </div>
        <br>
        <button type="button" onclick="searchBtnClick();" class="btn btn-info btn-rounded">検索</button>

    </div>
</div>
<br>
<div id ="resultAria">

</div>
@stop
@section('bodyScriptAfter')
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <!-- DataTables -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
 
    function searchBtnClick() {
            $.post("searchEvent" ,
            {
                actorName    : $("#actorName").val(),
                unitName    : $("#unitName").val(),
                fromDate : $("#fromDate").val(),
                toDate : $("#toDate").val(),
                _token: '{{ csrf_token() }}'
            } ,
            function(data){ $("#resultAria").html(data); } ).done(function(){$('#searchResult').DataTable();});
            

        

    }

</script>
@stop