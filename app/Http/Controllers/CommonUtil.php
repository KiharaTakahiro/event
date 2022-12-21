<?php

namespace App\Http\Controllers;

/**
 * 共通編集用クラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　共通編集用のクラス
 */
class CommonUtilController extends Controller
{
    //要素の空チェック
    public static function isEmpty($value)
    {
        if ($value == null || $value == '') {
            return true;
        } else {
            return false;
        }
    }
}
