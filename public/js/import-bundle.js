/*
 * BPO・新人研修管理 V1.0 release1
 *
 * -----------------------------------------------------------------------------
 * ソース名 ：import-bundle.js
 * 機能概要 ：Common jQuery functions
 * -----------------------------------------------------------------------------
 * 改版履歴
 * -----------------------------------------------------------------------------
 * バージョン     日付          変更者                コメント
 * -----------------------------------------------------------------------------
 * 1.0        2019-06-21    ABV) Phong           新規作成
 * -----------------------------------------------------------------------------
 *
 * Copyright 2019 FUJITSU LEARNING MEDIA LIMITED
 *
 */

/**
 * [機能]<br />
 * フォームを送信する
 *
 * [解説]<br />
 * フォームを送信する
 *
 * @param string url URLを送信
 * @return void
 *
 */
function submitForm(url)
{
    document.forms[0].action = url;
    document.forms[0].submit();
}

/**
 * [機能]<br />
 * 対象エレメントをidで特定し、値をセットする
 *
 * [解説]<br />
 * 対象エレメントをidで特定し、値をセットする
 *
 * @param string elementId
 * @param string value
 * @return void
 *
 */
function setElementValueById(elementId, value)
{
    $('#' + elementId).val(value);
}