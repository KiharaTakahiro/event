<?php

namespace App\Http\Controllers;

/**
 * 声優検索用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　声優検索用のクラス
 */
class SearchActorController extends Controller
{
    public function searchActorInfoTop()
    {
        try {
            \Log::info('声優情報トップ表示処理　開始');

            $actorLst = \Dao::selectMVoiceActorAll();
            \Log::info('声優情報トップ表示処理　終了');

            return view('actorInfo.search')->with('actorLst', $actorLst);
        } catch (\Exception $e) {
            \Log::error('声優情報トップ表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    public function getActorPageLst()
    {
        try {
            \Log::info('声優情報取得処理　開始');

            $actorName = \Request::input('actorName');
            $actorLst = \Dao::selectMVoiceActorLstByActorName($actorName);
            \Log::info('声優名:'.$actorName);

            \Log::info('声優情報取得処理　開始');

            return view('actorInfo.searchlst')->with('actorLst', $actorLst);
        } catch (\Exception $e) {
            \Log::error('声優情報取得処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    public function getDetailActorInfo()
    {
        try {
            \Log::info('声優情報詳細表示処理　開始');

            $actorCd = \Request::input('actorCd');
            $newsLst = \Dao::selectTNewsByActorCd($actorCd);
            $actor = \Dao::selectMVoiceActorByActorCd($actorCd);
            $eventLst = \Dao::selectTeventByActorCd($actorCd);
            $animeLst = \Dao::selectMAnimeCastbyActorCd($actorCd);
            $cdLst = \Dao::selectMCdbyActorCd($actorCd);
            \Log::info('声優コード:'.$actorCd);

            \Log::info('声優情報詳細表示処理　終了');

            return view('actorInfo.actorDetailInfo')
                    ->with('actor', $actor)
                    ->with('newsLst', $newsLst)
                    ->with('eventLst', $eventLst)
                    ->with('animeLst', $animeLst)
                    ->with('cdLst', $cdLst);
        } catch (\Exception $e) {
            \Log::error('声優情報詳細表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    public function getMusicInfo()
    {
        try {
            \Log::info('楽曲情報取得処理　開始');

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
            \Log::info('CDコード:'.$cdCd);

            \Log::info('楽曲情報取得処理　終了');
            if ($actorCd != '000000') {
            }

            return view('actorInfo.getMusicPage')->with('actor', $actor)->with('cd', $cd)->with('musicLst', $music);
        } catch (\Exception $e) {
            \Log::error('楽曲情報取得処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユニット情報リスト取得
    public function getUnitPageLst()
    {
        try {
            \Log::info('ユニット情報リスト取得処理　開始');

            $unitName = \Request::input('unitName');
            $unitLst = \Dao::selectMUnitLstByUnitName($unitName);
            \Log::info('ユニット名:'.$unitName);

            \Log::info('ユニット情報リスト取得処理　終了');

            return view('actorInfo.getUnitLst')
                    ->with('unitLst', $unitLst);
        } catch (\Exception $e) {
            \Log::error('ユニット情報リスト取得処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //ユニット情報表示ページ
    public function getDetailUnitInfo()
    {
        try {
            \Log::info('ユニット情報表示処理　開始');
            $unitCd = \Request::input('unitCd');
            $unit = \Dao::selectMUnitByUnitCd($unitCd);
            $eventLst = \Dao::selectTeventByUnitCd($unitCd);
            $cdLst = \Dao::selectMCdbyUnitCd($unitCd);
            $memberLst = \Dao::selectMUnitMember($unitCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            $newsLst = \Dao::selectTNewsByUnitCd($unitCd);
            \Log::info('ユニットコード:'.$unitCd);
            \Log::info('ユニット情報表示処理　終了');

            return view('actorInfo.unitDetailInfo')
                    ->with('actorLst', $actorLst)
                    ->with('unit', $unit)
                    ->with('eventLst', $eventLst)
                    ->with('newsLst', $newsLst)
                    ->with('memberLst', $memberLst)
                    ->with('cdLst', $cdLst);
        } catch (\Exception $e) {
            \Log::error('ユニット情報表示処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }
}
