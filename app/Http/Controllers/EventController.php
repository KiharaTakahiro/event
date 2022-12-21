<?php

namespace App\Http\Controllers;

/**
 * イベント用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　イベント用のクラス
 */
class EventController extends Controller
{
    //イベント検索ページ表示
    public function getSearchPage()
    {
        try {
            \Log::info('イベント検索ページ表示処理　開始');
            $actorLst = \Dao::selectMVoiceActorAll();
            $nowDate = date('Y-m-d');
            \Log::info('現在日付:'.$nowDate);
            \Log::info('イベント検索ページ表示処理　終了');

            return view('event.search')->with('actorLst', $actorLst)->with('nowDate', $nowDate);
        } catch (\Exception $e) {
            \Log::error('イベント検索ページ表示処理');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //イベント検索処理
    public function getSearchEvent()
    {
        try {
            \Log::info('イベント検索ページ処理　開始');
            //声優名
            $actorName = \Request::input('actorName');
            //ユニット名
            $unitName = \Request::input('unitName');
            //From日付
            $fromDate = str_replace('-', '/', \Request::input('fromDate'));
            //to日付
            $toDate = str_replace('-', '/', \Request::input('toDate'));

            \Log::info('声優名:'.$actorName);
            \Log::info('ユニット名:'.$unitName);
            \Log::info('From日付:'.$fromDate);
            \Log::info('To日付:'.$toDate);

            //声優名から声優の情報を取得
            $eventLst = \Dao::selectTEvetnActorbyParam($actorName, $unitName, $fromDate, $toDate);
            \Log::info('イベント検索ページ処理　終了');

            return view('event.searchlst')->with('eventLst', $eventLst);
        } catch (\Exception $e) {
            \Log::error('イベント検索ページ処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //イベント作成ページ表示処理
    public function getCreatePage()
    {
        try {
            \Log::info('イベント作成ページ表示処理　開始');
            $ariaLst = \Dao::selectMPositionAll();
            \Log::info('イベント作成ページ表示処理　終了');

            return view('event.create')
                    ->with('ariaLst', $ariaLst);
        } catch (\Exception $e) {
            \Log::error('イベント作成ページ表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //イベント作成処理
    public function createEvent()
    {
        try {
            \Log::info('イベント作成ページ処理　開始');
            //イベント名
            $eventName = \Request::input('eventName');
            //日付
            $date = str_replace('-', '/', \Request::input('date'));
            //開演時間
            $startTime = \Request::input('startTime');
            //場所名
            $ariaCd = \Request::input('aria');
            //公式ホームページ
            $url = \Request::input('eventUrl');
            //概要
            $memo = \Request::input('eventMemo');
            //チケット当落
            $ticketTourakuDate = \Request::input('ticketTourakuDate');
            //チケット価格
            $ticketPrice = \Request::input('ticketPrice');

            $eventMap = array(
                'aria_cd' => $ariaCd,
                'event_name' => $eventName,
                'event_date' => $date,
                'event_start_time' => $startTime,
                'event_url' => $url,
                'event_comment' => $memo,
                'ticket_touraku_date' => $ticketTourakuDate,
                'price' => $ticketPrice,
            );

            $addEvent = \Dao::insertTEvent($eventMap);

            $actorLst = \Dao::selectMVoiceActorAll();
            $unitLst = \Dao::selectMUnitAll();
            $eventActor = \Dao::setlecTeventActorByEventCd($addEvent->event_cd);
            $productLst = \Dao::getTProductSales($addEvent->event_cd);

            \Log::info('イベント名：'.$eventName);
            \Log::info('日付:'.$date);
            \Log::info('開演時間：'.$startTime);
            \Log::info('場所名:'.$ariaCd);
            \Log::info('公式ホームページ:'.$url);
            \Log::info('概要:'.$memo);
            \Log::info('チケット当落:'.$ticketTourakuDate);
            \Log::info('チケット価格:'.$ticketPrice);
            \Log::info('イベント作成ページ処理　終了');

            return redirect()->route('getDetailAddPage', ['eventCd' => $addEvent->event_cd]);
        } catch (\Exception $e) {
            \Log::error('イベントページ作成処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //イベント更新処理
    public function updateEvent()
    {
        try {
            \Log::info('イベント更新処理　開始');
            //イベントコード
            $eventCd = \Request::input('eventCd');
            //イベント名
            $eventName = \Request::input('eventName');
            //日付
            $date = str_replace('-', '/', \Request::input('date'));
            //開演時間
            $startTime = \Request::input('startTime');
            //場所コード
            $ariaCd = \Request::input('aria');
            //公式ホームページ
            $url = \Request::input('eventUrl');
            //概要
            $memo = \Request::input('eventMemo');
            //チケット当落
            $ticketTourakuDate = \Request::input('ticketTourakuDate');
            //チケット価格
            $ticketPrice = \Request::input('ticketPrice');

            \Log::info('イベントコード：'.$eventCd);
            \Log::info('イベント名：'.$eventName);
            \Log::info('日付：'.$date);
            \Log::info('開演時間：'.$startTime);
            \Log::info('場所コード：'.$ariaCd);
            \Log::info('公式ホームページ：'.$url);
            \Log::info('概要：'.$memo);
            \Log::info('チケット当落：'.$ticketTourakuDate);
            \Log::info('チケット価格：'.$ticketPrice);

            $eventMap = array(
                'event_cd' => $eventCd,
                'aria_cd' => $ariaCd,
                'event_name' => $eventName,
                'event_date' => $date,
                'event_start_time' => $startTime,
                'event_url' => $url,
                'event_comment' => $memo,
                'ticket_touraku_date' => $ticketTourakuDate,
                'price' => $ticketPrice,
            );
            \Dao::updateTEvent($eventMap);

            return redirect()->route('getDetailAddPage', ['eventCd' => $eventCd]);
            \Log::info('イベント更新処理　終了');
        } catch (\Exception $e) {
            \Log::error('イベントページ更新処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //声優追加ページ取得
    public function getEventActorAddPage()
    {
        try {
            \Log::info('声優追加ページ処理　開始');
            $eventCd = \Request::input('eventCd', '');
            $event = \Dao::selectByTEventByEventCd($eventCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            $unitLst = \Dao::selectMUnitAll();
            $eventActor = \Dao::setlecTeventActorByEventCd($eventCd);
            $productLst = \Dao::getTProductSales($eventCd);
            $musicLst = \Dao::selectMusicInfoByEventCd($eventCd);
            $setLst = \Dao::selectTSetListByEventCd($eventCd);
            $ariaLst = \Dao::selectMPositionAll();

            \Log::info('イベントコード：'.$eventCd);
            \Log::info('声優追加ページ処理　終了');

            return view('event.detailadd')
            ->with('actorLst', $actorLst)
            ->with('unitLst', $unitLst)
            ->with('productLst', $productLst)
            ->with('event', $event)
            ->with('ariaLst', $ariaLst)
            ->with('musicLst', $musicLst)
            ->with('setLst', $setLst)
            ->with('eventActor', $eventActor);
        } catch (\Exception $e) {
            \Log::error('声優追加ページ処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //声優情報追加処理
    public function addActor()
    {
        try {
            \Log::info('声優追加処理　開始');

            $eventCd = \Request::input('eventCd');
            $actorCd = \Request::input('actorCd');

            $eventActorMap = array(
                    'event_cd' => $eventCd,
                    'actor_cd' => $actorCd,
                    'unit_cd' => '000000',
                    'regstration_kbn' => '01',
                );
            \Dao::insertTEventActor($eventActorMap);
            $event = \Dao::selectByTEventByEventCd($eventCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            $unitLst = \Dao::selectMUnitAll();
            $eventActor = \Dao::setlecTeventActorByEventCd($eventCd);
            $productLst = \Dao::getTProductSales($eventCd);
            \Log::info('イベントコード：'.$eventCd);
            \Log::info('声優コード:'.$actorCd);

            \Log::info('声優追加処理　終了');

            return redirect()->route('getDetailAddPage', ['eventCd' => $eventCd]);
        } catch (\Exception $e) {
            \Log::error('声優追加処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユニット情報追加処理
    public function addUnit()
    {
        try {
            \Log::info('ユニット追加処理　開始');

            $eventCd = \Request::input('eventCd');
            $unitCd = \Request::input('unitCd');

            $eventActorMap = array(
                    'event_cd' => $eventCd,
                    'actor_cd' => '000000',
                    'unit_cd' => $unitCd,
                    'regstration_kbn' => '02',
                );
            \Dao::insertTEventActor($eventActorMap);
            $event = \Dao::selectByTEventByEventCd($eventCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            $unitLst = \Dao::selectMUnitAll();
            $eventActor = \Dao::setlecTeventActorByEventCd($eventCd);
            $productLst = \Dao::getTProductSales($eventCd);
            \Log::info('イベントコード:'.$eventCd);
            \Log::info('ユニット名:'.$unitCd);

            \Log::info('ユニット追加処理　終了');

            return redirect()->route('getDetailAddPage', ['eventCd' => $eventCd]);
        } catch (\Exception $e) {
            \Log::error('ユニット追加処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //イベント詳細画面表示
    public function getDetailPage()
    {
        try {
            \Log::info('イベント詳細画面表示処理　開始');
            $eventCd = \Request::input('eventCd', '');
            $event = \Dao::selectByTEventByEventCd($eventCd);
            $eventActor = \Dao::setlecTeventActorByEventCd($eventCd);
            $productLst = \Dao::getTProductSales($eventCd);
            $setLst = \Dao::selectTSetListByEventCd($eventCd);
            $aria = \Dao::selectMPositionByAriaCd($event->aria_cd);

            \Log::info('イベントコード:'.$eventCd);
            \Log::info('イベント詳細画面表示処理　終了');

            return view('event.detail')
                ->with('event', $event)
                ->with('productLst', $productLst)
                ->with('setLst', $setLst)
                ->with('aria', $aria)
                ->with('eventActor', $eventActor);
        } catch (\Exception $e) {
            \Log::error('ユニット詳細画面表示処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //物販情報登録
    public function addProduct()
    {
        try {
            \Log::info('物販情報登録　開始');

            $salesName = \Request::input('salesName');
            $price = \Request::input('price');
            $eventCd = \Request::input('eventCd');
            $file = \Input::file('image');
            $image;
            $fileName = '';
            try {
                if ($file != null) {
                    $image = \Image::make(file_get_contents($file));
                    if (!file_exists(public_path().'/images/'.$eventCd)) {
                        mkdir(public_path().'/images/'.$eventCd, 0777);
                    }
                    $image->save(public_path().'/images/'.$eventCd.'/'.$file->hashName());
                    $fileName = $file->hashName();
                }
            } catch (\Exception $e) {
            }
            $productMap = array(
                'event_cd' => $eventCd,
                'sales_name' => $salesName,
                'price' => $price,
                'file_name' => $fileName,
            );
            \Dao::insertTProductSales($productMap);
            $event = \Dao::selectByTEventByEventCd($eventCd);
            $actorLst = \Dao::selectMVoiceActorAll();
            $unitLst = \Dao::selectMUnitAll();
            $eventActor = \Dao::setlecTeventActorByEventCd($eventCd);
            $productLst = \Dao::getTProductSales($eventCd);

            \Log::info('商品名:'.$salesName);
            \Log::info('価格:'.$price);
            \Log::info('イベントコード:'.$eventCd);

            \Log::info('物販情報登録　終了');

            return redirect()->route('getDetailAddPage', ['eventCd' => $eventCd]);
        } catch (\Exception $e) {
            \Log::error('物販情報登録処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //セットリスト追加処理
    public function addSetList()
    {
        try {
            \Log::info('セットリスト追加処理　開始');
            $eventCd = \Request::input('eventCd');
            $musicKbn = \Request::input('musicKbn');
            $musicCd = \Request::input('musicName', '');
            $musicName = '';
            if ($musicKbn == '01') {
                $musicName = \Dao::selectMMusicByMusicCd($musicCd)->music_name;
            } else {
                $musicCd = '000000';
                $musicName = \Request::input('musicNameByCover');
            }

            $setLstMap = array(
                'event_cd' => $eventCd,
                'music_cd' => $musicCd,
                'music_kbn' => $musicKbn,
                'song_title' => $musicName,
            );
            \Dao::insertTSetList($setLstMap);

            \Log::info('イベントコード:'.$eventCd);
            \Log::info('楽曲区分:'.$musicKbn);
            \Log::info('曲名:'.$musicName);

            \Log::info('セットリスト追加処理　終了');

            return redirect()->route('getDetailAddPage', ['eventCd' => $eventCd]);
        } catch (\Exception $e) {
            \Log::error('セットリスト追加処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //完売処理
    public function soldOut()
    {
        try {
            \Log::info('完売処理 開始');

            $eventCd = \Request::input('eventCd');
            $salesCd = \Request::input('salesCd');
            \Log::info('イベントコード：'.$eventCd);
            \Log::info('商品コード：'.$salesCd);
            \Dao::updateTProductSale($eventCd, $salesCd, 1);
            \Log::info('完売処理 終了');
        } catch (\Exception $e) {
            \Log::error('完売処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }

    //取消処理
    public function cansel()
    {
        try {
            \Log::info('取消処理　開始');
            $eventCd = \Request::input('eventCd');
            $salesCd = \Request::input('salesCd');
            \Log::info('イベントコード：'.$eventCd);
            \Log::info('商品コード：'.$salesCd);
            \Dao::updateTProductSale($eventCd, $salesCd, 0);
            \Log::info('取消処理　終了');
        } catch (\Exception $e) {
            \Log::error('取消処理　失敗');
            \Log::error('エラーメッセージ：'.$e->getMessage());
        }
    }
}
