@extends('master.master')
@section('pageTitle') | ログインページ @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">ログイン</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">ユーザでログインすると機能が追加されます。</p>
            <p class="card-text">ユーザの登録は<a href="getAddUserPage">こちら</a>から行えます。</p>
            <p class="card-text">ユーザの登録後は再びこの画面に遷移します。</p>
            <p class="card-text">ユーザコードとパスワードを入力してログインしてください。</p>
        </blockquote>
        <br>
        <form method="POST" action="login" enctype="multipart/form-data">
            <p>
                ユーザコード：
                <input id="userCd" name="userCd" class="form-control" type="text" placeholder="ユーザコード" aria-label="userCd"  pattern="^[0-9A-Za-z]+$" maxlength="20" required>
                ※ユーザコードは20文字以内の半角英数字で入力をお願いします。
            </p>
            <p>
                パスワード：
                <input id="password" name="password" class="form-control" type="password" placeholder="パスワード" aria-label="price" required>
                ※パスワードは5文字以上30文字以内の半角英数字で入力をお願いします。
            </p>
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">ログイン</button>
        </form>
    </div>
</div>
@stop