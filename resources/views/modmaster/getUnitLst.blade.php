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
                    <td><a href="addUnitDetailInfo?unitCd={{$unit->unit_cd}}">{{$unit->unit_name}}</a></td>
                    <td>{{$unit->furigana}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>