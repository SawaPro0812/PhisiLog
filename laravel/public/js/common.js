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
