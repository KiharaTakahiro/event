<?php

namespace App\Http\Controllers;

/**
 * 個人ページ用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　個人ページ用のクラス
 */
class PrivateController extends Controller
{
    //topページの表示
    public function getTopPage()
    {
        try {
            \Log::info('個人ページ表示処理　開始');
            if (!\Session::has('user')) {
                return view('private.loginUser');
            } else {
                $actorLst = \Dao::selectMVoiceActorAll();
                $rankLst = \Dao::selectMCodeByCdKind('001');
                $unitLst = \Dao::selectMUnitAll();
                $faboliteLst = \Dao::selectTFaboliteByUserCd(\Session::get('user'));
                $faboliteActorLst = \Dao::selectTFaboliteActorByUserCd(\Session::get('user'));
                $faboliteUnitLst = \Dao::selectTFaboliteUnitByUserCd(\Session::get('user'));
                \Log::info('個人ページ表示処理　終了');

                return view('private.top')
                    ->with('userCd', \Session::get('user'))
                    ->with('actorLst', $actorLst)
                    ->with('unitLst', $unitLst)
                    ->with('rankLst', $rankLst)
                    ->with('faboliteLst', $faboliteLst)
                    ->with('faboliteActorLst', $faboliteActorLst)
                    ->with('faboliteUnitLst', $faboliteUnitLst)
                    ;
            }
        } catch (\Exception $e) {
            \Log::error('個人ページ表示処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユーザ作成ページの表示
    public function getAddUserPage()
    {
        \Log::info('個人ページ表示処理　開始');
        $message = \Request::input('message');
        \Log::info('メッセージ：'.$message);
        \Log::info('個人ページ表示処理　終了');

        return view('private.createUser')->with('message', $message);
    }

    //お気に入り声優の登録処理
    public function matchActor()
    {
        try {
            \Log::info('お気に入り声優登録処理　開始');

            $actorCd = \Request::input('actorCd', '000000');
            $unitCd = \Request::input('unitCd', '000000');
            $userCd = \Request::input('userCd');
            $rank = \Request::input('rank');

            \Log::info('声優コード：'.$actorCd);
            \Log::info('ユニットコード：'.$unitCd);
            \Log::info('ユーザコード：'.$userCd);
            \Log::info('ランク：'.$rank);

            $fboliteMap = array(
                'actor_cd' => $actorCd,
                'unit_cd' => $unitCd,
                'user_cd' => $userCd,
                'rank' => $rank,
            );

            \Dao::insertTFaboliteActor($fboliteMap);
            \Log::info('お気に入り声優登録処理　終了');

            return redirect()->route('getTopPage');
        } catch (\Exception $e) {
            \Log::error('お気に入り声優登録処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ログアウト処理
    public function logout()
    {
        \Log::info('ログアウト処理　開始');

        \Session::flush();
        \Log::info('ログアウト処理　終了');

        return redirect()->route('getTopPage');
    }

    //ユーザ作成ページの表示
    public function login()
    {
        try {
            \Log::info('ユーザ作成ページ表示処理　開始');
            $userCd = \Request::input('userCd');
            $password = \Request::input('password');
            $user = \Dao::selectMUser($userCd);
            if ($user == null || decrypt($user->password) != $password) {
                return view('private.loginUser');
            } else {
                \Session::put('user', $userCd);
                \Log::info(decrypt($user->password));

                return redirect()->route('getTopPage');
            }
        } catch (\Exception $e) {
            \Log::error('ユーザ作成ページ表示処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }

    //ユーザ登録
    public function addUser()
    {
        try {
            \Log::info('ユーザ登録処理　開始');
            $userCd = \Request::input('userCd');
            $password = \Request::input('password');
            $isErrorAll = false;
            $isErrorUserCd = false;
            $isErrorPassword = false;
            \Log::info('ユーザコード'.$userCd);
            \Log::info('パスワード'.$password);
            $message = array();
            //ユーザコードチェック処理
            //ユーザコード文字数チェック
            if (empty($userCd)) {
                $message += array(
                'userCd' => 'ユーザコードが空です。',
            );
                \Log::info('ユーザコードが空で登録された');
                $isErrorAll = true;
                $isErrorUserCd = true;
            }
            //ユーザコード半角英数字チェック
            if (!$isErrorUserCd && !preg_match('/^[a-zA-Z0-9]+$/', $userCd)) {
                $message += array(
                'userCd' => 'ユーザコードはすべて半角英数字で入力してください',
            );
                \Log::info('ユーザコードが半角英数字以外で登録された');

                $isErrorAll = true;
                $isErrorUserCd = true;
            }
            //ユーザコード文字数チェック
            if (!$isErrorUserCd && strlen($userCd) > 20) {
                $message += array(
                'userCd' => 'ユーザコードは20文字以下で入力してください',
            );
                \Log::info(strlen($userCd).'文字での入力がありました。');
                \Log::info('ユーザコードが20文字以上で登録された');

                $isErrorAll = true;
                $isErrorUserCd = true;
            }
            $user = \Dao::selectMUser($userCd);
            //ユーザコード重複チェック
            if (!$isErrorUserCd && $user != null) {
                $message += array(
                'userCd' => '他のユーザとユーザコードが重複しています。別のユーザコードを入力してください',
            );
                $isErrorAll = true;
                $isErrorUserCd = true;
            }

            //パスワードチェック処理
            //ユーザコード半角英数字チェック
            if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
                $message += array(
                'password' => 'パスワードはすべて半角英数字で入力してください',
            );
                \Log::info('パスワードが半角英数字以外で登録された');
                $isErrorAll = true;
                $isErrorPassword = true;
            }

            if ($isErrorAll) {
                return view('private.createUser')->with('message', $message);
            }

            //ユーザを登録する
            $userMap = array(
            'user_cd' => $userCd,
            'password' => $password,
            );
            \Dao::insertMUser($userMap);

            return redirect()->route('getTopPage');
        } catch (\Exception $e) {
            \Log::error('ユーザ登録処理　失敗');

            \Log::error('エラーメッセージ：'.$e->getMessage());

            return view('errors.error');
        }
    }
}
