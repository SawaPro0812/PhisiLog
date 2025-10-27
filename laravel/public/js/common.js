/**
 * ============================================================
 * AJAX通信共通関数（async/await対応版）
 * ------------------------------------------------------------
 * await ajaxGet(url, data)
 * await ajaxPost(url, data)
 * ============================================================
 */

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

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
        console.error(`[POST ERROR] ${url}`, error);
        throw error;
    }
}
