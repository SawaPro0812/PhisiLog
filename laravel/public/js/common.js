/**
 * ============================================================
 * AJAX通信共通関数（async/await対応版）
 * ------------------------------------------------------------
 * await ajaxGet(url, data)
 * await ajaxPost(url, data)
 * ============================================================
 */

const csrfToken = $('meta[name="csrf-token"]').attr("content");
if (csrfToken) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": csrfToken
        }
    });
}

/**
 * Laravelバリデーションエラー（422）のメッセージを取り出す
 */
function extractValidationMessage(jqXHR) {
    const json = jqXHR?.responseJSON;

    // Laravel標準: { message: "...", errors: { field: ["msg"] } }
    if (json?.errors) {
        const firstKey = Object.keys(json.errors)[0];
        const firstMsg = json.errors[firstKey]?.[0];
        if (firstMsg) return firstMsg;
    }

    if (json?.message) return json.message;

    return "入力内容を確認してください。";
}

/**
 * 共通エラーハンドリング（必要なものだけアラート）
 * - 422: 入力エラー
 * - 419: CSRF/セッション切れ
 */
function handleAjaxError(jqXHR) {
    if (!jqXHR) return;

    if (jqXHR.status === 422) {
        alert(extractValidationMessage(jqXHR));
        return;
    }

    if (jqXHR.status === 419) {
        alert("セッションが切れました。再読み込みしてください。");
        return;
    }
}

/**
 * GET通信（Promiseを返す）
 */
async function ajaxGet(url, data = {}) {
    try {
        const res = await $.ajax({
            url: url,
            type: "GET",
            data: data,
            dataType: "json"
        });
        return res;
    } catch (error) {
        handleAjaxError(error);
        console.error(`[GET ERROR] ${url}`, error);
        throw error;
    }
}

/**
 * POST通信（Promiseを返す）
 */
async function ajaxPost(url, data = {}) {
    try {
        const res = await $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json"
        });
        return res;
    } catch (error) {
        handleAjaxError(error);
        console.error(`[POST ERROR] ${url}`, error);
        throw error;
    }
}
