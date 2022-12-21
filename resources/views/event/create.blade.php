@extends('master.master')
@section('pageTitle') | イベント作成 @stop
@section('body')
<br/>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベントの追加</h4>
    <div class ="card-body">
    <blockquote class="blockquote mb-0">
        <p class="card-text">イベントを作成することできます。</p>
        <p class="card-text">声優情報等の詳細な情報は登録後に表示されるページで登録してください。</p>
        <p class="card-text">このページで登録が完了しても声優またはユニットを登録しなければ検索画面での表示はされません。</p>
        <p class="card-text">イベント名、日付、場所は必ず入力してください。その他は分かる限りで入力をお願いします。</p>
        <p class="card-text">またここで登録した項目はから変更が可能です。</p>
    </blockquote>
    <br>
    <form method="POST" action="createEvent" enctype="multipart/form-data">
    <p>
        イベント名:
        <input id="eventName" name="eventName" class="form-control" type="text" placeholder="イベント名" aria-label="eventName" required />
    </p>
    <p style ="position: relative;">
        日付：
        <input type="date" id="date" name="date" class="form-control" placeholder="日付" value="" aria-label="Date" required/>        
    </p>
    <p>
        開演時間：
        <input id="startTime" name="startTime" class="form-control" type="time" placeholder="開演時間" aria-label="Date" />        
    </p>
    <p>
        場所名：
        <select id ="aria" name="aria" class="form-control" type="text" placeholder="場所" aria-label="Aria" list="ariaList" />    
        	@foreach($ariaLst as $aria)
                <option value={{$aria->aria_cd}}>{{$aria->aria_name}}</option>
            @endforeach
		</select>
        会場の追加は<a href="getAriaAddpage">こちら</a>から行ってください
    </p>
    <p>
        公式ホームページ:
        <input id="eventUrl" name="eventUrl" class="form-control" type="url" placeholder="公式ホームページ" aria-label="eventUrl" />
    </p>
    <p>
        チケット当落発表日:
        <input id="ticketTourakuDate" type="date" name="ticketTourakuDate" class="form-control" />
    </p>
    <p>
        チケット価格:
        <input id="ticketPrice" name="ticketPrice" type="number" class="form-control" />
    </p>
    <p>
        概要:
        <textarea id="eventMemo" name="eventMemo" class="form-control" rows="5"></textarea>
    </p>
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <button type="submit" class="btn btn-info btn-rounded">登録</button>
    </form>
</div>
</div>
@stop
