<?php

namespace App\Http\Controllers;

/**
 * マスタ編集用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　マスタ編集用のクラス
 */
class ModMasterController extends Controller
{
    //マスター編集トップページ表示処理
    public function getMasterTopPage()
    {
        \Log::info('マスター編集トップページ表示処理　開始');
        \Log::info('マスター編集トップページ表示処理　終了');

        return view('modmaster.top');
    }

    //マスター編集トップ声優追加ページ表示処理
    public function getActorInfoPage()
    {
        \Log::info('声優追加ページ表示処理　開始');
        \Log::info('声優追加ページ表示処理　終了');

        return view('modmaster.addActorInfo');
    }

    //マスター編集トップユニット追加ページ表示処理
    public function getUnitInfoPage()
    {
        \Log::info('ユニット追加ページ表示処理　開始');
        \Log::info('ユニット追加ページ表示処理　終了');

        return view('modmaster.addUnitInfo');
    }

    //声優詳細情報表示処理
    public function getActorDetailInfoPage()
    {
        try {
            \Log::info('声優詳細ページ表示処理　開始');

            $actorCd = \Request::input('actorCd');
            $actor = \Dao::selectMVoiceActorByActorCd($actorCd);
            $cdLst = \Dao::selectMCdbyActorCd($actorCd);
            \Log::info('声優コード:'.$actorCd);
            \Log::info('声優詳細ページ表示処理　終了');

            return view('modmaster.addActorDetailInfo')
                    ->with('actor', $actor)
                    ->with('cdLst', $cdLst);
        } catch (\Exception $e) {
            \Log::error('声優詳細ページ表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユニットメンバーを追加
    public function addMUnitMember()
    {
        try {
            \Log::info('ユニットメンバー追加処理　開始');
            $unitCd = \Request::input('unitCd');
            $actorCd = \Request::input('actorName');
            $unitMemberMap = array(
                'unit_cd' => $unitCd,
                'actor_cd' => $actorCd,
            );
            \Dao::insertMUnitMember($unitMemberMap);
            \Log::info('ユニットメンバー追加処理　終了');

            return redirect()->route('getAddUnitDetailInfo', ['unitCd' => $unitCd]);
        } catch (\Exception $e) {
            \Log::error('ユニットメンバー追加処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユニット詳細情報表示処理
    public function getUnitDetailInfoPage()
    {
        try {
            \Log::info('ユニット詳細ページ表示処理　開始');

            $unitCd = \Request::input('unitCd');
            $unit = \Dao::selectMUnitByUnitCd($unitCd);
            $cdLst = \Dao::selectMCdbyUnitCd($unitCd);
            $memberLst = \Dao::selectMUnitMember($unitCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            \Log::info('ユニットコード:'.$unitCd);
            \Log::info('ユニット詳細ページ表示処理　終了');

            return view('modmaster.addUnitDetailInfo')
                    ->with('actorLst', $actorLst)
                    ->with('unit', $unit)
                    ->with('memberLst', $memberLst)
                    ->with('cdLst', $cdLst);
        } catch (\Exception $e) {
            \Log::error('ユニット詳細ページ表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //声優情報追加処理
    public function addActorInfo()
    {
        try {
            \Log::info('声優情報追加処理　開始');

            $actorName = \Request::input('actorName');
            $actorNameFurigana = \Request::input('actorNameFurigana');
            $actorMap = array(
                        'actor_name' => $actorName,
                        'furigana' => $actorNameFurigana,
                        'regstration_kbn' => '01',
                    );

            \Dao::insertMVoiceActor($actorMap);
            \Log::info('声優名:'.$actorName);
            \Log::info('声優名フリガナ:'.$actorNameFurigana);

            \Log::info('声優情報追加処理　終了');

            return redirect()->route('getAddActorInfo');
        } catch (\Exception $e) {
            \Log::error('声優情報追加処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //声優情報追加処理
    public function addUnitInfo()
    {
        try {
            \Log::info('ユニット情報追加処理　開始');

            $unitName = \Request::input('unitName', '');
            $unitNameFurigana = \Request::input('unitNameFurigana', '');
            $unitMap = array(
                            'unit_name' => $unitName,
                            'furigana' => $unitNameFurigana,
                            'regstration_kbn' => '01',
                        );

            \Dao::insertMUnit($unitMap);
            \Log::info('ユニット名:'.$unitName);
            \Log::info('ユニット名フリガナ:'.$unitNameFurigana);

            \Log::info('ユニット情報追加処理　終了');

            return redirect()->route('getAddUnitInfo');
        } catch (\Exception $e) {
            \Log::error('ユニット情報追加処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //声優情報リスト取得
    public function getActorInfoList()
    {
        try {
            \Log::info('声優情報リスト取得処理　開始');

            $actorName = \Request::input('actorName');
            $actorLst = \Dao::selectMVoiceActorLstByActorName($actorName);
            \Log::info('声優名:'.$actorName);

            \Log::info('声優情報リスト取得処理　終了');

            return view('modmaster.getActorLst')
                    ->with('actorLst', $actorLst);
        } catch (\Exception $e) {
            \Log::error('声優情報リスト取得処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //ユニット情報リスト取得
    public function getUnitInfoList()
    {
        try {
            \Log::info('ユニット情報リスト取得処理　開始');

            $unitName = \Request::input('unitName');
            $unitLst = \Dao::selectMUnitLstByUnitName($unitName);
            \Log::info('ユニット名:'.$unitName);

            \Log::info('ユニット情報リスト取得処理　終了');

            return view('modmaster.getUnitLst')
                    ->with('unitLst', $unitLst);
        } catch (\Exception $e) {
            \Log::error('ユニット情報リスト取得処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //CD情報追加処理
    public function addMcd()
    {
        try {
            \Log::info('CD情報追加処理　開始');

            $actorCd = \Request::input('addMcdActorCd', '000000');
            $unitCd = \Request::input('addMcdUnitCd', '000000');
            $cdName = \Request::input('cdName');
            $price = \Request::input('price');
            $date = str_replace('-', '/', \Request::input('date'));
            $cdKbn = \Request::input('exampleRadios');
            $cdMap = array(
                'actor_cd' => $actorCd,
                'unit_cd' => $unitCd,
                'price' => $price,
                'cd_name' => $cdName,
                'relese_date' => $date,
                'cd_kbn' => $cdKbn,
            );
            \Dao::insertMCdByActorMap($cdMap);
            \Log::info('声優コード:'.$actorCd);
            \Log::info('ユニットコード'.$unitCd);
            \Log::info('CD名:'.$cdName);
            \Log::info('価格:'.$price);
            \Log::info('発売日:'.$date);
            \Log::info('CD区分:'.$cdKbn);

            \Log::info('CD情報追加処理　終了');
            //声優コードが初期値の場合は声優の詳細ページに移動
            if ($actorCd != '000000') {
                return redirect()->route('getAddActorDetailInfo', ['actorCd' => $actorCd]);
            } else {
                return redirect()->route('getAddUnitDetailInfo', ['unitCd' => $unitCd]);
            }
        } catch (\Exception $e) {
            \Log::error('CD情報追加処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //楽曲追加ページの取得
    public function getAddMusicPage()
    {
        try {
            \Log::info('楽曲追加ページ取得処理　開始');

            $actorCd = \Request::input('actorCd', '000000');
            $unitCd = \Request::input('unitCd', '000000');
            $cdCd = \Request::input('cdCd');
            $actor;
            if ($actorCd != '000000') {
                $actor = \Dao::selectMVoiceActorByActorCd($actorCd);
            } else {
                $actor = \Dao::selectMUnitByUnitCd($unitCd);
            }
            $cd = \Dao::selectMCdByCdCd($cdCd);
            $music = \Dao::selectMMusicByCdCd($cdCd);
            \Log::info('声優コード:'.$actorCd);
            \Log::info('ユニットコード:'.$unitCd);
            \Log::info('CDコード:'.$cdCd);
            \Log::info('楽曲追加ページ取得処理　終了');

            return view('modmaster.addMusicPage')->with('actor', $actor)->with('cd', $cd)->with('musicLst', $music);
        } catch (\Exception $e) {
            \Log::error('楽曲追加ページ取得処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //楽曲追加処理
    public function addMusic()
    {
        try {
            \Log::info('楽曲追加処理　開始');

            $actorCd = \Request::input('addMusicActorCd', '000000');
            $unitCd = \Request::input('addMusicUnitCd', '000000');
            $cdCd = \Request::input('addMusicCdCd');
            $musicName = \Request::input('musicName');
            $url = \Request::input('url');
            $musicMap = array(
                'cd_cd' => $cdCd,
                'music_name' => $musicName,
                'url' => $url,
            );
            \Dao::insertMMusic($musicMap);
            \Log::info('声優コード:'.$actorCd);
            \Log::info('ユニットコード:'.$unitCd);
            \Log::info('CDコード:'.$cdCd);
            \Log::info('楽曲名:'.$musicName);
            \Log::info('url:'.$url);

            \Log::info('楽曲追加処理　終了');
            if ($actorCd != '000000') {
                return redirect()->route('getAddMusicPage', ['actorCd' => $actorCd, 'cdCd' => $cdCd]);
            } else {
                return redirect()->route('getAddMusicPage', ['unitCd' => $unitCd, 'cdCd' => $cdCd]);
            }
        } catch (\Exception $e) {
            \Log::error('CD情報追加処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //アニメ登録ページ表示処理
    public function getAnimeAddpage()
    {
        \Log::info('アニメ登録ページ表示処理　開始');
        \Log::info('アニメ登録ページ表示処理　終了');

        return view('modmaster.addAnimePage');
    }

    //アニメ情報登録処理
    public function addAnime()
    {
        try {
            \Log::info('アニメ登録処理　開始');
            $animeName = \Request::input('animeName');
            $startDate = str_replace('-', '/', \Request::input('startDate'));
            $endDate = str_replace('-', '/', \Request::input('endDate'));
            $comment = \Request::input('comment');
            $animeMap = array(
                'anime_name' => $animeName,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'comment' => $comment,
            );
            \Log::info('アニメ名:'.$animeName);
            \Log::info('開始日:'.$startDate);
            \Log::info('終了日:'.$endDate);
            \Log::info('概要:'.$comment);

            \Dao::insertMAnime($animeMap);

            return redirect()->route('getAnimeAddpage');

            \Log::info('アニメ登録処理　終了');
        } catch (\Exception $e) {
            \Log::error('アニメ登録処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //アニメリスト取得処理
    public function getAnimePageLst()
    {
        try {
            \Log::info('アニメリスト取得処理　開始');
            $animeName = \Request::input('searchAnimeName');
            $animeLst = \Dao::selectMAnimebyAnimeName($animeName);

            \Log::info('アニメ名:'.$animeName);
            \Log::info('アニメリスト取得処理　終了');

            return view('modmaster.getAnimeLst')->with('animeLst', $animeLst);
        } catch (\Exception $e) {
            \Log::error('アニメリスト取得処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //アニメキャスト情報の追加ページ表示
    public function getAddAnimeCastPage()
    {
        try {
            \Log::info('アニメキャスト情報追加ページ表示処理　開始');
            $animeCd = \Request::input('animeCd');
            $anime = \Dao::selectMAnimeByAnimeCd($animeCd);
            $animeCastLst = \Dao::selectMAnimeCastByAnimeCd($animeCd);
            $actorLst = \Dao::selectMVoiceActorAll();

            \Log::info('アニメコード:'.$animeCd);
            \Log::info('アニメキャスト情報追加ページ表示処理　終了');

            return view('modmaster.addAnimeDetailInfo')->with('anime', $anime)->with('animeCastLst', $animeCastLst)->with('actorLst', $actorLst);
        } catch (\Exception $e) {
            \Log::error('アニメリスト取得処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //アニメキャスト登録処理
    public function addAnimeCast()
    {
        try {
            \Log::info('アニメキャスト登録処理　開始');
            $animeCd = \Request::input('animeCd');
            $actorName = \Request::input('actorName');
            $charaName = \Request::input('charaName');
            $actor = \Dao::selectMVoiceActorByActorName($actorName);
            $actorCd = $actor->actor_cd;
            $animeCastMap = array(
                'anime_cd' => $animeCd,
                'actor_cd' => $actorCd,
                'chara_name' => $charaName,
            );
            \Dao::insertMAnimeCast($animeCastMap);
            \Log::info('アニメコード:'.$animeCd);
            \Log::info('アニメキャスト登録処理　終了');

            return redirect()->route('getAddAnimeCastPage', ['animeCd' => $animeCd]);
        } catch (\Exception $e) {
            \Log::error('アニメキャスト登録処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //会場登録ページ表示処理
    public function getAriaAddpage()
    {
        \Log::info('会場登録ページ表示処理　開始');
        $prefectureLst = \Dao::selectMPrefecture();
        \Log::info('会場登録ページ表示処理　終了');

        return view('modmaster.addAria')->with('prefectureLst', $prefectureLst);
    }

    //会場登録処理
    public function addAria()
    {
        try {
            \Log::info('会場登録処理　開始');
            $prefectureCd = \Request::input('prefectureCd');
            $ariaName = \Request::input('ariaName');
            $adress = \Request::input('adress');
            $latitude = \Request::input('lat');
            $langitude = \Request::input('lng');
            $ariaMap = array(
                'prefecture_cd' => $prefectureCd,
                'aria_name' => $ariaName,
                'regstration_kbn' => '01',
                'latitude' => $latitude,
                'longitude' => $langitude,
                'adress' => $adress,
            );
            \Dao::insertMPosition($ariaMap);
            \Log::info('県コード:'.$prefectureCd);
            \Log::info('会場名:'.$ariaName);
            \Log::info('住所:'.$adress);
            \Log::info('緯度:'.$latitude);
            \Log::info('経度:'.$langitude);

            \Log::info('会場登録処理　終了');

            return redirect()->route('getAriaAddpage');
        } catch (\Exception $e) {
            \Log::error('会場登録処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ニュース登録処理
    public function addNews()
    {
        try {
            \Log::info('ニュース登録処理　開始');
            $actorCd = \Request::input('newsActorCd', '000000');
            $unitCd = \Request::input('newsUnitCd', '000000');
            $newsurl = \Request::input('newsurl');
            $newstitle = \Request::input('newstitle');
            $newsmemo = \Request::input('newsmemo');
            $newsMap = array(
                'actor_cd' => $actorCd,
                'unit_cd' => $unitCd,
                'news_title' => $newstitle,
                'url' => $newsurl,
                'memo' => $newsmemo,
            );

            \Dao::insertTNews($newsMap);
            \Log::info('ニュース登録処理　終了');

            //声優コードが初期値の場合は声優の詳細ページに移動
            if ($actorCd != '000000') {
                return redirect()->route('getAddActorDetailInfo', ['actorCd' => $actorCd]);
            } else {
                return redirect()->route('getAddUnitDetailInfo', ['unitCd' => $unitCd]);
            }
        } catch (\Exception $e) {
            \Log::error('ニュース登録処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }
}
