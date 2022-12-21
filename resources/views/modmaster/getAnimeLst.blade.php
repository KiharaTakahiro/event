<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">キャスト情報の追加</h4>
    <div class ="card-body">
        <table id="animeResult" class="table table-striped tagle-bordered">
            <thead>
                <tr>
                    <th class="table-info">アニメ名</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animeLst as $anime)
                    <tr>
                        <td><a href="getAddAnimeCastPage?animeCd={{$anime->anime_cd}}">{{$anime->anime_name}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>