<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">検索結果</h4>
    <div class ="card-body">
    <table id="searchResult" class="table table-striped tagle-bordered">
        <thead>
            <tr>
                <th class="table-info">日付</th>
                <th class="table-info">イベント名</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventLst as $event)
                <tr>
                    <td>{{$event->event_date}}</td>
                    <td>
                        <a href="eventdetail?eventCd={{$event->event_cd}}">{{$event->event_name}}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
