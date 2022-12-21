<?php

namespace App\Http\Controllers;

/**
 * トップページ表示用のクラス.
 *
 * @author kihara Takahiro
 * @copyright 2018 Kihara. All Rights Reserved
 *
 * @category　トップページ表示用のクラス
 */
class TopController extends Controller
{
    public function getTopPage()
    {
        return view('top.top');
    }
}
