<div class ="card">
    <h4 class="card-header card-header-info">検索結果</h4>
    <div class ="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="table-info">イベント名</th>
                    <th class="table-info">日付</th>
                    <th class="table-info">出演者</th>
                </tr>
            </thead>
            <tbody>
            @foreach($eventLst as $event)
                <td>{{$event->eventName}}</td>
                <td>{{$event->date}}</td>
                <td>{{$event->actorName}}</td>
            @endforeach
            </tbody>
        </table>
    </div>
</div>