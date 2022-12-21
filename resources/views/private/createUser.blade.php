@extends('master.master')
@section('pageTitle') | ユーザ登録 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ユーザ登録</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">ユーザ登録を行うことができます。</p>
            <p class="card-text">ユーザ登録を行うと個人ページを使用することができます。</p>
        </blockquote>
        <br>
        <form method="POST" action="addUser" enctype="multipart/form-data">
            <p>
                ユーザコード：
                <input id="userCd" name="userCd" class="form-control" type="text" placeholder="ユーザコード" aria-label="salesName"  pattern="^[0-9A-Za-z]+$"　title="半角英数字で入力して下さい。"  maxlength="20" required>
                ※ユーザコードは20文字以内の半角英数字で入力をお願いします。
            </p>
            @if(isset($message['userCd']))
                <p><font color = "red">{{$message['userCd']}}</font></p>
            @endif
            <p>
                パスワード：
                <input id="password" name="password" class="form-control" type="password" placeholder="パスワード" aria-label="price" required>
                ※パスワードは5文字以上30文字以内の半角英数字で入力をお願いします。
            </p>
            @if(isset($message['password']))
                <p><font color = "red">{{$message['password']}}</font></p>
            @endif
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">ユーザを追加</button>
        </form>
    </div>
</div>
@stop