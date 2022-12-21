<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">検索結果</h4>
    <div class ="card-body">
    <table id="actorResult" class="table table-striped tagle-bordered">
        <thead>
            <tr>
                <th class="table-info">声優名</th>
                <th class="table-info">声優名(ふりがな)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actorLst as $actor)
                <tr>
                    <td><a href="getDetailActorInfo?actorCd={{$actor->actor_cd}}">{{$actor->actor_name}}</a></td>
                    <td>{{$actor->furigana}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
