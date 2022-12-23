<?php

namespace App\Http\Controllers;

/**
 * DBアクセス用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　DBアクセス用のクラス test
 */
class DaoController extends Controller
{
    //イベントの登録
    public static function insertTEvent($eventMap)
    {
        $sql = '';
        $sql .= 'insert into t_event ("event_cd", "aria_cd", "event_name", "event_date", "event_start_time", "event_url", "event_comment","ticket_touraku_date","price", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values(to_char(nextval(\'event_cd_seq\'),\'FM000000\'),?,?,?,?,?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$eventMap['aria_cd'], $eventMap['event_name'], $eventMap['event_date'], $eventMap['event_start_time'], $eventMap['event_url'], $eventMap['event_comment'], $eventMap['ticket_touraku_date'], $eventMap['price']]);

        return self::selectBylastEvent();
    }

    //イベント更新処理
    public static function updateTEvent($eventMap)
    {
        $sql = '';
        $sql = 'update t_event set aria_cd = ?,event_name = ?,event_date = ?,event_start_time = ?,event_url = ?,event_comment = ?,ticket_touraku_date = ?,price = ?,update_date=now() where event_cd = ?';
        \DB::update($sql, [$eventMap['aria_cd'], $eventMap['event_name'], $eventMap['event_date'], $eventMap['event_start_time'], $eventMap['event_url'], $eventMap['event_comment'], $eventMap['ticket_touraku_date'], $eventMap['price'], $eventMap['event_cd']]);
    }

    //最新のイベントseqを取得するメソッド
    public static function getLeastEventSeq()
    {
        $sql = '';
        $sql = 'select last_value from  event_cd_seq';
        $rtn = \DB::selectOne($sql);

        return $rtn->last_value;
    }

    //最新のイベントを取得
    public static function selectBylastEvent()
    {
        $leastSeq = self::getLeastEventSeq();
        $sql = '';
        $sql = 'select * from t_event where event_cd = ?';
        $rtnLst = \DB::selectOne($sql, [sprintf('%06d', $leastSeq)]);

        return $rtnLst;
    }

    //イベントコードにてイベントを検索
    public static function selectByTEventByEventCd($eventCd)
    {
        $sql = '';
        $sql = 'select * from t_event where event_cd = ?';
        $rtnLst = \DB::selectOne($sql, [$eventCd]);

        return $rtnLst;
    }

    public static function selectEventBySerachParam($eventCdLst, $date, $type)
    {
        $query = \DB::table('t_event');
        if ($type == '1') {
            $query->wherein('event_cd', $eventCdLst);
        }
        if ($date != '') {
            $query->where('event_date', '=', $date);
        }

        return $query->get();
    }

    //声優コードからイベント情報を取得
    public static function selectTeventByActorCd($actorCd)
    {
        $sql = '';
        $sql = 'select e.event_cd as event_cd ,e.event_name as event_name,e.event_date as event_date from t_event e inner join t_event_actor ea on (e.event_cd = ea.event_cd and ea.actor_cd = ?)  order by e.event_date desc';
        $rtnLst = \DB::select($sql, [$actorCd]);

        return $rtnLst;
    }

    //声優コードからニュース情報を取得
    public static function selectTNewsByActorCd($actorCd)
    {
        $sql = '';
        $sql = 'select * from t_news where actor_cd = ? and delete_flg = \'0\' order by insert_date desc';
        $rtnLst = \DB::select($sql, [$actorCd]);

        return $rtnLst;
    }

    //ユニットコードからニュース情報を取得
    public static function selectTNewsByUnitCd($unitCd)
    {
        $sql = '';
        $sql = 'select * from t_news where unit_cd = ? and delete_flg = \'0\' order by insert_date desc';
        $rtnLst = \DB::select($sql, [$unitCd]);

        return $rtnLst;
    }

    //ニュース情報を登録
    public static function insertTNews($newsMap)
    {
        $sql = '';
        $sql .= 'insert into t_news ("news_cd", "actor_cd", "unit_cd", "news_title", "url", "memo", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values(to_char(nextval(\'news_cd_seq\'),\'FM000000\'),?,?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$newsMap['actor_cd'], $newsMap['unit_cd'], $newsMap['news_title'], $newsMap['url'], $newsMap['memo']]);
    }

    //ユニットコードからイベント情報を取得
    public static function selectTeventByUnitCd($unitCd)
    {
        $sql = '';
        $sql = 'select e.event_cd as event_cd ,e.event_name as event_name,e.event_date as event_date from t_event e inner join t_event_actor ea on (e.event_cd = ea.event_cd and ea.unit_cd = ?)  order by e.event_date desc';
        $rtnLst = \DB::select($sql, [$unitCd]);

        return $rtnLst;
    }

    //登壇者マスタから声優コードで検索
    public static function selectTEvetnActorbyParam($actorName, $unitName, $fromDate, $toDate)
    {
        $sqlArray = array();
        $actorCdFlg = false;
        $unitCdFlg = false;
        $fromDateFlg = false;
        $toDateFlg = false;
        $sql = '';
        $sql = 'select distinct te.event_cd,te.event_name,te.event_date from t_event te ';
        $sql .= 'left join t_event_actor tea on (tea.event_cd = te.event_cd)';
        $sql .= 'left join m_voice_actor mva  ';
        $sql .= 'on (tea.actor_cd = mva.actor_cd)';
        $sql .= 'left join m_unit mu ';
        $sql .= 'on (tea.unit_cd = mu.unit_cd)';
        if (($actorName != null && $actorName != '')
            || ($unitName != null && $unitName != '')
            || ($fromDate != null && $fromDate != '')
            || ($toDate != null && $toDate != '')) {
            $sql .= ' where ';
        }
        if ($actorName != '' && $actorName != null) {
            $sql .= 'mva.actor_name like ?';
            array_push($sqlArray, '%'.$actorName.'%');
            $actorCdFlg = true;
        }
        if ($fromDate != '' && $fromDate != null) {
            if ($actorCdFlg) {
                $sql .= 'and ';
            }
            $sql .= 'te.event_date >= ?';
            array_push($sqlArray, $fromDate);
            $fromDateFlg = true;
        }
        if ($toDate != '' && $toDate != null) {
            if ($actorCdFlg || $fromDateFlg) {
                $sql .= 'and ';
            }
            $sql .= 'te.event_date <= ?';
            array_push($sqlArray, $toDate);
            $toDateFlg = true;
        }
        if ($unitName != '' && $unitName != null) {
            if ($actorCdFlg || $fromDateFlg || $toDateFlg) {
                $sql .= 'and ';
            }
            $sql .= 'mu.unit_name like ? ';
            array_push($sqlArray, '%'.$unitName.'%');
            $unitCdFlg = true;
        }
        $sql .= ' order by event_date desc';
        if (empty($sqlArray)) {
            return \DB::select($sql);
        } else {
            return \DB::select($sql, $sqlArray);
        }
    }

    //イベント登壇者テーブルに登録
    public static function insertTEventActor($eventActorMap)
    {
        $sql = '';
        $sql .= 'insert into t_event_actor ("event_cd", "actor_cd", "unit_cd", "regstration_kbn", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values(?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$eventActorMap['event_cd'], $eventActorMap['actor_cd'], $eventActorMap['unit_cd'], $eventActorMap['regstration_kbn']]);
    }

    //イベント登壇者テーブルをイベントコードで検索
    public static function setlecTeventActorByEventCd($eventCd)
    {
        $rtnLst = \DB::table('t_event_actor')
        ->leftjoin('m_voice_actor', 't_event_actor.actor_cd', 'm_voice_actor.actor_cd')
        ->leftjoin('m_unit', 't_event_actor.unit_cd', 'm_unit.unit_cd')
        ->where('event_cd', '=', $eventCd)
        ->get();

        return $rtnLst;
    }

    //声優マスタの検索
    public static function selectMVoiceActorAll()
    {
        $rtnLst = \DB::table('m_voice_actor')
                    ->where('delete_flg', '=', '0')
                    ->orderby('furigana')
                    ->get();

        return $rtnLst;
    }

    //声優マスタから情報を取得
    public static function selectMVoiceActorByActorName($actorName)
    {
        $rtnActor = \DB::table('m_voice_actor')
                  ->where('actor_name', '=', $actorName)
                  ->where('delete_flg', '=', '0')
                  ->first();

        return $rtnActor;
    }

    //声優マスタから情報を取得
    public static function selectMVoiceActorByActorCd($actorCd)
    {
        $sql = '';
        $sql .= 'select * from m_voice_actor mva where mva.actor_cd = ? and mva.delete_flg = \'0\'';
        $rtnActor = \DB::selectOne($sql, [$actorCd]);

        return $rtnActor;
    }

    //声優名からあいまい検索
    public static function selectMVoiceActorLstByActorName($actorName)
    {
        $sql = '';
        $sql = 'select * from m_voice_actor';
        if ($actorName != null && $actorName != '') {
            $sql .= ' where actor_name like ?';

            return \DB::select($sql, ['%'.$actorName.'%']);
        } else {
            return \DB::select($sql);
        }
    }

    //声優マスタに登録
    public static function insertMVoiceActor($actorMap)
    {
        $sql = '';
        $sql .= 'insert into m_voice_actor ("actor_cd", "actor_name", "furigana", "regstration_kbn", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values(to_char(nextval(\'actor_cd_seq\'),\'FM000000\'),?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$actorMap['actor_name'], $actorMap['furigana'], $actorMap['regstration_kbn']]);

        return self::selectMVoiceActorByActorName($actorMap['actor_name']);
    }

    //ユニットマスタから検索
    public static function selectMUnitAll()
    {
        $rtnLst = \DB::table('m_unit')
                    ->where('delete_flg', '=', '0')
                    ->orderby('furigana')
                    ->get();

        return $rtnLst;
    }

    //ユニットマスタから検索
    public static function selectMUnitByUnitName($unitName)
    {
        $rtnLst = \DB::table('m_unit')
                        ->where('unit_name', '=', $unitName)
                        ->where('delete_flg', '=', '0')
                        ->orderby('furigana')
                        ->first();

        return $rtnLst;
    }

    //ユニット名からあいまい検索
    public static function selectMUnitLstByUnitName($unitName)
    {
        $sql = '';
        $sql = 'select * from m_unit';
        if ($unitName != null && $unitName != '') {
            $sql .= ' where unit_name like ?';

            return \DB::select($sql, ['%'.$unitName.'%']);
        } else {
            return \DB::select($sql);
        }
    }

    //ユニット名からあいまい検索
    public static function selectMUnitByUnitCd($unitCd)
    {
        $sql = '';
        $sql = 'select * from m_unit where unit_cd = ?';

        return \DB::selectOne($sql, [$unitCd]);
    }

    //ユニットマスタに登録
    public static function insertMUnit($unitMap)
    {
        $sql = '';
        $sql .= 'insert into m_unit ("unit_cd", "unit_name", "furigana", "regstration_kbn", "work_pause_flg", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values(to_char(nextval(\'unit_cd_seq\'),\'FM000000\'),?,?,?,\'0\',\'0\',now(),now())';
        \DB::insert($sql, [$unitMap['unit_name'], $unitMap['furigana'], $unitMap['regstration_kbn']]);
    }

    //ユニットのメンバーを登録
    public static function insertMUnitMember($unitMemberMap)
    {
        $sql = '';
        $sql .= 'insert into m_unit_member ("unit_cd","actor_cd","withdrawal_flg", "delete_flg", "insert_date", "update_date") ';
        $sql .= 'values (?,?,\'0\',\'0\',now(),now())';
        \DB::insert($sql, [$unitMemberMap['unit_cd'], $unitMemberMap['actor_cd']]);
    }

    //ユニットメンバーを取得
    public static function selectMUnitMember($unitCd)
    {
        $sql = '';
        $sql .= 'select mu.unit_cd as unit_cd,mu.actor_cd as actor_cd,mu.withdrawal_flg as withdrawal_flg ,mva.actor_name as actor_name from m_unit_member mu inner join m_voice_actor mva on (mu.actor_cd = mva.actor_cd) where mu.unit_cd = ? order by mva.furigana';
        $rtnLst = \DB::select($sql, [$unitCd]);

        return $rtnLst;
    }

    //場所マスタから検索
    public static function selectMPositionAll()
    {
        $rtnLst = \DB::table('m_position')
                 ->where('delete_flg', '=', '0')
                 ->get();

        return $rtnLst;
    }

    //場所マスタから検索
    public static function selectMPositionByAriaName($ariaName)
    {
        $rtnLst = \DB::table('m_position')
                    ->where('aria_name', '=', $ariaName)
                    ->where('delete_flg', '=', '0')
                     ->first();

        return $rtnLst;
    }

    //場所マスタの情報を取得
    public static function selectMPositionByAriaCd($ariaCd)
    {
        $rtnLst = \DB::table('m_position')
                    ->where('aria_cd', '=', $ariaCd)
                    ->where('delete_flg', '=', '0')
                     ->first();

        return $rtnLst;
    }

    //商品情報の数をカウント
    public static function countTProductSales($eventCd)
    {
        $sql = '';
        $sql = 'select count(*) as count from t_product_sale where event_cd = ?';
        $rtn = \DB::selectOne($sql, [$eventCd]);

        return $rtn->count;
    }

    //同一イベントの商品情報を取得する
    public static function getTProductSales($eventCd)
    {
        $sql = '';
        $sql = 'select * from t_product_sale where event_cd =?';

        $rtnLst = \DB::select($sql, [$eventCd]);

        return $rtnLst;
    }

    //商品情報を登録する
    public static function insertTProductSales($productMap)
    {
        $productSeq = self::countTProductSales($productMap['event_cd']) + 1;
        $sql = '';
        $sql = 'insert into t_product_sale ("event_cd","sales_cd","sales_name","price","file_name","sold_out_flg","delete_flg","insert_date","update_date")';
        $sql .= 'values (?,?,?,?,?,\'0\',\'0\',now(),now())';
        \DB::insert($sql, [$productMap['event_cd'], sprintf('%06d', $productSeq), $productMap['sales_name'], $productMap['price'], $productMap['file_name']]);
    }

    //CD情報を取得する
    public static function selectMCdbyActorCd($actorCd)
    {
        $sql = '';
        $sql = 'select * from m_cd where actor_cd=? order by relese_date desc';
        $rtnLst = \DB::select($sql, [$actorCd]);

        return $rtnLst;
    }

    //CD情報を取得する
    public static function selectMCdbyUnitCd($unitCd)
    {
        $sql = '';
        $sql = 'select * from m_cd where unit_cd=? order by relese_date desc';
        $rtnLst = \DB::select($sql, [$unitCd]);

        return $rtnLst;
    }

    //CD情報を登録する
    public static function insertMCdByActorMap($actorMap)
    {
        $sql = '';
        $sql = 'insert into m_cd ("cd_cd","actor_cd","unit_cd","price","cd_name","relese_date","cd_kbn","delete_flg","insert_date","update_date")';
        $sql .= 'values (to_char(nextval(\'cd_cd_seq\'),\'FM000000\'),?,?,?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$actorMap['actor_cd'], $actorMap['unit_cd'], $actorMap['price'], $actorMap['cd_name'], $actorMap['relese_date'], $actorMap['cd_kbn']]);
    }

    //CD情報を取得する
    public static function selectMCdByCdCd($cdCd)
    {
        $sql = '';
        $sql = 'select * from m_cd where cd_cd=?';
        $rtn = \DB::selectOne($sql, [$cdCd]);

        return $rtn;
    }

    //CD情報から楽曲情報を取得する
    public static function selectMMusicByCdCd($cdCd)
    {
        $sql = '';
        $sql = 'select * from m_music where cd_cd=?';
        $rtnLst = \DB::select($sql, [$cdCd]);

        return $rtnLst;
    }

    //楽曲情報を登録する
    public static function insertMMusic($musicMap)
    {
        $sql = '';
        $sql = 'insert into m_music ("music_cd","cd_cd","music_name","url","delete_flg","insert_date","update_date")';
        $sql .= 'values(to_char(nextval(\'music_cd_seq\'),\'FM000000\'),?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$musicMap['cd_cd'], $musicMap['music_name'], $musicMap['url']]);
    }

    //アニメ情報を登録する
    public static function insertMAnime($animeMap)
    {
        $sql = '';
        $sql = 'insert into m_anime ("anime_cd","anime_name","start_date","end_date","comment","delete_flg","insert_date","update_date")';
        $sql .= 'values(to_char(nextval(\'anime_cd_seq\'),\'FM000000\'),?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$animeMap['anime_name'], $animeMap['start_date'], $animeMap['end_date'], $animeMap['comment']]);
    }

    //アニメ情報を取得する
    public static function selectMAnimebyAnimeName($animeName)
    {
        $sql = '';
        $sql = 'select * from m_anime where anime_name like ? and delete_flg =\'0\' order by start_date';
        $rtnLst = \DB::select($sql, ['%'.$animeName.'%']);

        return $rtnLst;
    }

    //アニメコードからアニメ情報を取得
    public static function selectMAnimeByAnimeCd($animeCd)
    {
        $sql = '';
        $sql = 'select * from m_anime where anime_cd = ?';
        $rtn = \DB::selectOne($sql, [$animeCd]);

        return $rtn;
    }

    //アニメコードからキャスト情報を取得
    public static function selectMAnimeCastByAnimeCd($animeCd)
    {
        $sql = '';
        $sql = 'select mac.anime_cd as anime_cd,mac.actor_cd as actor_cd,mac.chara_name as chara_name,mva.actor_name as actor_name from m_anime_cast mac inner join m_voice_actor mva on (mac.actor_cd = mva.actor_cd) where anime_cd = ? ';
        $rtnLst = \DB::select($sql, [$animeCd]);

        return $rtnLst;
    }

    //キャスト情報登録処理
    public static function insertMAnimeCast($animeCastMap)
    {
        $sql = '';
        $sql = 'insert into m_anime_cast ("anime_cd","actor_cd","chara_name","delete_flg","insert_date","update_date")';
        $sql .= 'values (?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$animeCastMap['anime_cd'], $animeCastMap['actor_cd'], $animeCastMap['chara_name']]);
    }

    //声優情報からアニメ情報を取得
    public static function selectMAnimeCastbyActorCd($actorCd)
    {
        $sql = '';
        $sql = 'select ma.anime_cd as anime_cd ,ma.anime_name as anime_name,mac.chara_name as chara_name from m_anime ma inner join m_anime_cast mac on (ma.anime_cd = mac.anime_cd) where mac.actor_cd = ?';
        $rtnLst = \DB::select($sql, [$actorCd]);

        return $rtnLst;
    }

    //場所マスタ登録処理
    public static function insertMPosition($ariaMap)
    {
        $sql = '';
        $sql = 'insert into m_position ("aria_cd","prefecture_cd","aria_name","regstration_kbn","latitude","longitude","delete_flg","insert_date","update_date","adress")';
        $sql .= 'values (to_char(nextval(\'aria_cd_seq\'),\'FM000000\'),?,?,?,?,?,\'0\',now(),now(),?)';
        \DB::insert($sql, [$ariaMap['prefecture_cd'], $ariaMap['aria_name'], $ariaMap['regstration_kbn'], $ariaMap['latitude'], $ariaMap['longitude'], $ariaMap['adress']]);
    }

    //県マスタ取得処理
    public static function selectMPrefecture()
    {
        $sal = '';
        $sql = 'select * from m_prefecture';
        $rtnLst = \DB::select($sql);

        return $rtnLst;
    }

    //登壇者の楽曲を取得する
    public static function selectMusicInfoByEventCd($eventCd)
    {
        $sql = '';
        $sql = 'select * from m_cd mc inner join m_music mm on (mc.cd_cd = mm.cd_cd) where exists (select * from t_event_actor te where ((te.actor_cd = mc.actor_cd and te.unit_cd =\'000000\') or (te.actor_cd =\'000000\' and te.unit_cd = mc.unit_cd)) and te.event_cd = ?)';
        $rtnLst = \DB::select($sql, [$eventCd]);

        return $rtnLst;
    }

    //セットリストを取得する
    public static function selectTSetListByEventCd($eventCd)
    {
        $sql = '';
        $sql = 'select * from t_set_list where event_cd =?';
        $rtnLst = \DB::select($sql, [$eventCd]);

        return $rtnLst;
    }

    //セットリストを登録する
    public static function insertTSetList($setListMap)
    {
        $seq = count(self::selectTSetListByEventCd($setListMap['event_cd'])) + 1;
        $sql = '';
        $sql = 'insert into t_set_list ("event_cd","set_list_seq","music_cd","music_kbn","song_title","delete_flg","insert_date","update_date")';
        $sql .= 'values (?,to_char(cast(? as integer),\'FM000000\'),?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$setListMap['event_cd'], $seq, $setListMap['music_cd'], $setListMap['music_kbn'], $setListMap['song_title']]);
    }

    //楽曲コードから楽曲を取得
    public static function selectMMusicByMusicCd($musicCd)
    {
        $sql = '';
        $sql = 'select * from m_music where music_cd =?';
        $rtn = \DB::selectOne($sql, [$musicCd]);

        return $rtn;
    }

    //完売フラグ(flg:0　取消　flg:1 完売)
    public static function updateTProductSale($eventCd, $salesCd, $flg)
    {
        $sql = '';
        $sql = 'update t_product_sale set sold_out_flg=?,update_date=now() where event_cd = ? and sales_cd = ?';
        \DB::update($sql, [$flg, $eventCd, $salesCd]);
    }

    //ユーザ検索処理
    public static function selectMUser($userCd)
    {
        $sql = '';
        $sql = 'select * from m_user where user_cd = ?';
        $rtn = \DB::selectOne($sql, [$userCd]);

        return $rtn;
    }

    //ユーザを登録する
    public static function insertMUser($userMap)
    {
        $sql = '';
        $sql = 'insert into m_user ("user_cd","password","delete_flg","insert_date","update_date")';
        $sql .= 'values (?,?,\'0\',now(),now())';
        \DB::insert($sql, [$userMap['user_cd'], encrypt($userMap['password'])]);
    }

    //お気に入り声優を登録する
    public static function insertTFaboliteActor($faboliteMap)
    {
        $sql = '';
        $sql = 'insert into t_faborite_actor ("actor_cd","unit_cd","user_cd","rank","delete_flg","insert_date","update_date")';
        $sql .= 'values (?,?,?,?,\'0\',now(),now())';
        \DB::insert($sql, [$faboliteMap['actor_cd'], $faboliteMap['unit_cd'], $faboliteMap['user_cd'], $faboliteMap['rank']]);
    }

    //お気に入り声優の登録イベントを表示
    public static function selectTFaboliteByUserCd($userCd)
    {
        $sql = '';
        $sql .= 'select tfa.actor_cd,tfa.unit_cd,te.event_cd,te.event_name,te.event_date,mva.actor_name,mu.unit_name from  t_faborite_actor tfa ';
        $sql .= 'inner join t_event_actor tea on (tfa.actor_cd = tea.actor_cd and tfa.unit_cd = tea.unit_cd ) ';
        $sql .= 'inner join t_event te on (tea.event_cd = te.event_cd) ';
        $sql .= 'left join m_voice_actor mva on (tfa.actor_cd = mva.actor_cd)';
        $sql .= 'left join m_unit mu on (tfa.unit_cd = mu.unit_cd) ';
        $sql .= 'where tfa.user_cd = ? and to_date(te.event_date,\'yyyy/mm/dd\') >= date(now())';
        $sql .= 'order by tfa.rank desc,te.event_date desc ';
        $sql .= 'limit 20';
        $rtnLst = \DB::select($sql, [$userCd]);

        return $rtnLst;
    }

    //お気に入り声優を取得
    public static function selectTFaboliteActorByUserCd($userCd)
    {
        $sql = 'select tfa.actor_cd,mva.actor_name,tfa.rank from t_faborite_actor tfa ';
        $sql .= 'left join m_voice_actor mva on (tfa.actor_cd = mva.actor_cd)';
        $sql .= 'where tfa.user_cd = ? and tfa.actor_cd <> \'000000\'';
        $rtnLst = \DB::select($sql, [$userCd]);

        return $rtnLst;
    }

    //お気に入り声優を取得
    public static function selectTFaboliteUnitByUserCd($userCd)
    {
        $sql = 'select tfa.unit_cd,mva.unit_name,tfa.rank from t_faborite_actor tfa ';
        $sql .= 'left join m_unit mva on (tfa.unit_cd = mva.unit_cd)';
        $sql .= 'where tfa.user_cd = ? and tfa.unit_cd <> \'000000\'';
        $rtnLst = \DB::select($sql, [$userCd]);

        return $rtnLst;
    }

    //コードリストの取得
    public static function selectMCodeByCdKind($cdKind)
    {
        $sql = '';
        $sql = 'select * from m_code where cd_kind = ? and delete_flg = \'0\'';
        \Log::info($cdKind);
        $rtnLst = \DB::select($sql, [$cdKind]);

        return $rtnLst;
    }
}
