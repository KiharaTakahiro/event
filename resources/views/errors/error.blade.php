@extends('master.master')
@section('pageTitle') | エラーページ @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">エラー発生</h4>
    <div class ="card-body">
        <p>システムエラーが発生しております。</p>
        <p>しばらくお待ちいただき、再度同じ操作お願いします。</p>
        <p>登録を行っていた場合は、登録内容をご確認いただき再度ご登録をお願いします。</p>
    </div>
</div>
@stop