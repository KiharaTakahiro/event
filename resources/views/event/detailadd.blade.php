@extends('master.master')
@section('pageTitle') | イベント情報詳細変更 @stop
@section('body')
<br>
<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">イベントの更新</h4>
    <div  id="eventContent" class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">イベント登録内容の更新が可能です。</p>
        </blockquote>
    <br>
    <form method="POST" action="updateEvent" enctype="multipart/form-data">
    <p>
        イベント名:
        <input id="eventName" name="eventName" class="form-control" value ="{{$event->event_name}}" type="text" placeholder="イベント名" aria-label="eventName" required/>
    </p>
    <p style ="position: relative;">
        日付：
        <input type="date" id="date" name="date" value ="{{$event->event_date}}" class="form-control" placeholder="日付" value="" aria-label="Date" required/>        
    </p>
    <p>
        開演時間：
        <input id="startTime" name="startTime" class="form-control" value ="{{$event->event_start_time}}" type="time" placeholder="開演時間" aria-label="Date" />        
    </p>
    <p>
        場所名：
        <select id ="aria" name="aria" class="form-control" type="text" placeholder="場所" aria-label="Aria" list="ariaList" >    
        	@foreach($ariaLst as $aria)
                @if ($aria->aria_cd == $event->aria_cd)
                    <option value={{$aria->aria_cd}} selected>{{$aria->aria_name}}</option>
                @else
                <option value={{$aria->aria_cd}}>{{$aria->aria_name}}</option>
                @endif
            @endforeach
		</select>
        会場の追加は<a href="getAriaAddpage">こちら</a>から行ってください
    </p>
    <p>
        公式ホームページ:
        <input id="eventUrl" name="eventUrl" value ="{{$event->event_url}}" class="form-control" type="url" placeholder="公式ホームページ" aria-label="eventUrl" />
    </p>
    <p>
        チケット当落発表日:
        <input id="ticketTourakuDate"  name="ticketTourakuDate" value ="{{$event->ticket_touraku_date}}" class="form-control" type="date" placeholder="チケット当落日" aria-label="ticketTourakuDate"/>
    </p>
    <p>
        チケット価格:
        <input id="ticketPrice" value ="{{$event->price}}" name="ticketPrice" class="form-control" type ="number"/>
    </p>
    <p>
        概要:
        <textarea id="eventMemo" name="eventMemo"  class="form-control" rows="5">{{$event->event_comment}}</textarea>
    </p>
    <input type ="hidden" name="_token" value ="{{csrf_token()}}">
    <input type ="hidden" name="eventCd" value ="{{$event->event_cd}}">
    <button type="submit" class="btn btn-info btn-rounded">更新</button>
    </form>
</div>
</div>
<br>
<div  id="actorContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">登壇者情報の追加</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">登壇者の追加が行えます。</p>
            <p class="card-text">イベントを追加している場合でも登壇者の追加を行わなければ検索ページから検索しても表示されないのでご注意ください。</p>
        </blockquote>
        <br>
        <form method="POST" action="addActor" enctype="multipart/form-data">
            <p>
                声優名：
                <select id="actorCd" name="actorCd" class="form-control selectpicker" type="text" placeholder="声優名" aria-label="ActorName" list="actorList">
                    @foreach($actorLst as $actor)
                        <option value ="{{$actor->actor_cd}}" >{{$actor->actor_name}}</option>
                    @endforeach
                </select>
                声優の追加は<a href="addActorInfo">こちら</a>からおこなってください
            </p>
            <input type="hidden" name ="eventCd" value="{{$event->event_cd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">声優を追加</button>
        </form>
        <form method="POST" action="addUnit" enctype="multipart/form-data">
            <p>
                ユニット名：
                <select id="unitCd" name="unitCd" class="form-control selectpicker" type="text" placeholder="ユニット名" aria-label="unitName" list="unitList">
                    @foreach($unitLst as $unit)
                        <option value ="{{$unit->unit_cd}}">{{$unit->unit_name}}</option>
                    @endforeach
                </select>
            </p>
            <p>ユニットの追加は<a href="addUnitInfo">こちら</a>からおこなってください</p>
            <input type="hidden" name ="eventCd" value="{{$event->event_cd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">ユニットを追加</button>
        </form>
        <br>
        <p>追加済みのキャストはこちら</p>
        <table class ="table table-bordered">
            <thead><th class="table-info">キャスト一覧</th></thead>
            @foreach($eventActor as $actor)
                @if($actor->actor_name != null && $actor->actor_name !='')
                    <tr><td>{{$actor->actor_name}}</td></tr> 
                @endif
                @if($actor->unit_name != null && $actor->unit_name != '')
                <tr><td>{{$actor->unit_name}}</td></tr>
                @endif 
            @endforeach                    
        </table>
    </div>
</div>

<br>
<div  id="salesContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">物販情報の追加</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">物販の商品の追加が可能です。</p>
        </blockquote>
        <br>
        <form method="POST" action="addProduct" enctype="multipart/form-data">
            <p>
                商品名：
                <input id="salesName" name="salesName" class="form-control" type="text" placeholder="商品名" aria-label="salesName" required>
            </p>
            <p>
                価格：
                <input id="price" name="price" class="form-control" type="number" placeholder="価格" aria-label="price" >
            </p>
            <p>
                画像：
                <input id="image" name="image" class="form-control" type="file" placeholder="価格" aria-label="price" >
            </p>

            <input type="hidden" name ="eventCd" value="{{$event->event_cd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">物販情報を追加</button>
        </form>
        <br>
        <p>追加済みの商品はこちら</p>
        <table class ="table table-bordered">
            <th class="table-info">商品名</th>
            @if(isset($productLst))
                @foreach($productLst as $product)
                    <tr><td>{{$product->sales_name}}</tr></td>
                @endforeach
            @endif
        </table>
    </div>
</div>

<br>
<div  id="setListContent" class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">セットリストの追加</h4>
    <div class ="card-body">
        <blockquote class="blockquote mb-0">
            <p class="card-text">セットリストの追加ができます。</p>
            <p class="card-text">登壇者の曲は声優の楽曲情報をもとに表示されます。
            <a href="addActorInfo">こちら</a>から対象の声優を検索して登録してください</p>
            <p class="card-text">カバー曲の場合は自由に登録が可能です。</p>
        </blockquote>
        <br>
        <form method="POST" action="addSetList" enctype="multipart/form-data">
        <p>
            <div class="form-check form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" onchange = "onChangeRadio();" type="radio" name="musicKbn" id="exampleRadios1" value="01" checked>
                    登壇者の曲
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check form-check-radio">
                <label class="form-check-label">
                    <input class="form-check-input" onchange = "onChangeRadio();" type="radio" name="musicKbn" id="exampleRadios2" value="02" >
                    カバー曲
                    <span class="circle">
                        <span class="check"></span>
                    </span>
                </label>
            </div>
        </p>
        <p>
            曲名：
            <select id="musicName" name="musicName" class="form-control" type="text" placeholder="曲名" aria-label="musicName" >
                @foreach($musicLst as $music)
                    <option value ="{{$music->music_cd}}">{{$music->music_name}}</option>
                @endforeach
            </select>
        </p>
        <p>
            曲名（カバー曲の場合に入力）：
            <input id="musicNameByCover" name="musicNameByCover" class="form-control" type="text" placeholder="カバー曲" aria-label="musicNameByCover" disabled ="true" >
        </p>

            <input type="hidden" name ="eventCd" value="{{$event->event_cd}}">
            <input type ="hidden" name="_token" value ="{{csrf_token()}}">
            <button type="submit" class="btn btn-info btn-rounded">セットリストを追加</button>
        </form>
        <br>
        <p>追加済みのセットリストはこちら</p>
        <table class ="table table-bordered">
        <thead><th class="table-info">曲名</th></thead>
            @foreach($setLst as $set)
            <tr>
                <td>
                {{$set->song_title}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop
@section('bodyScriptAfter')
<script>
    function onChangeRadio(){
        var check = $('#exampleRadios1').prop('checked');
        if(check) {
            $('#musicName').prop('disabled', false);
            $('#musicNameByCover').prop('disabled', true);

        } else {
            $('#musicName').prop('disabled', true);
            $('#musicNameByCover').prop('disabled', false);
            
        }
    }
</script>
@stop