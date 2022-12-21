<div class="card" style ="max-width:800px; margin-left:7px;">
    <h4 class="card-header card-header-info">検索結果</h4>
    <div class ="card-body">
        <table id="unitResult" class="table table-striped tagle-bordered">
            <thead>
                <tr>
                    <th class="table-info">ユニット名</th>
                    <th class="table-info">ユニット名(ふりがな）</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unitLst as $unit)
                    <tr>
                        <td><a href="getDetailUnitInfo?unitCd={{$unit->unit_cd}}">{{$unit->unit_name}}</a></td>
                        <td>{{$unit->furigana}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>