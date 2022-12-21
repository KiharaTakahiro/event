    <table id="actorResult" class="table table-striped tagle-bordered">
        <thead>
            <tr>
                <th class="table-info">声優名</th>
                <th class="table-info">声優名(ふりがな）</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actorLst as $actor)
                <tr>
                    <td><a href="addActorDetailInfo?actorCd={{$actor->actor_cd}}">{{$actor->actor_name}}</a></td>
                    <td>{{$actor->furigana}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>