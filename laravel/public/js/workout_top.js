// ===============================================
// グローバル変数として現在の年月を保持
// ===============================================
let currentYear = new Date().getFullYear();
let currentMonth = new Date().getMonth() + 1;

// URLパラメータから選択日を取得
const params = new URLSearchParams(window.location.search);
let selectedDateFromUrl = params.get("date");

$(function(){
    // カレンダー初期表示
    createCalendar(currentYear, currentMonth);

    // 前月ボタン
    $("#prev-month").on("click", function() {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }

        // ✅ 月移動時はURL選択を無効化（ボタン操作を優先）
        selectedDateFromUrl = null;

        createCalendar(currentYear, currentMonth);
        selectDefaultDateForCurrentMonth(); // ✅ 1日 or 今日
    });

    // 次月ボタン
    $("#next-month").on("click", function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }

        // ✅ 月移動時はURL選択を無効化（ボタン操作を優先）
        selectedDateFromUrl = null;

        createCalendar(currentYear, currentMonth);
        selectDefaultDateForCurrentMonth(); // ✅ 1日 or 今日
    });

    // ✅ カレンダー日付クリック（イベント委譲で不具合修正）
    // prev-month / next-month はクリック無効のまま
    $(document).on("click", ".calendar td", function() {
        const $cell = $(this);

        // 空セルは無視
        if (!$cell.text()) return;

        // 前月/翌月セルはクリック不可
        if ($cell.hasClass("prev-month") || $cell.hasClass("next-month")) return;

        showWorkOut($cell);
    });

    // モーダル表示
    $(".add-btn").on("click", function() {
        showModal($(this));
    });

    // 登録画面へ遷移
    $(document).on("click", "#nextButton", function() {
        transionInsert();
    });

    // ワークアウト編集
    $(document).on("click", ".record-table tbody tr", function() {
        transionEdit($(this));
    });
});

// ===============================================
// カレンダー表示
// ===============================================
function createCalendar(year, month) {
    const today = new Date();

    // 月の最初と最後の日を取得
    const startDate = new Date(year, month - 1, 1);
    const endDate = new Date(year, month,  0);
    const endDayCount = endDate.getDate();

    // 前月の末日
    const lastMonthEndDate = new Date(year, month - 1, 0);
    const lastMonthEndDayCount = lastMonthEndDate.getDate();

    // 月の最初の日の曜日を取得
    const startDay = startDate.getDay();

    let dayCount = 1;
    let nextMonthDayCount = 1;

    // セル初期化
    $(".calendar tbody td").text("").removeClass("today prev-month next-month");

    // ヘッダ更新（例：2025年10月）
    $(".month-header h2").text(`${year}年${month}月`);

    // カレンダーの行の数繰り返す
    for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 7; j++) {
            const $cell = $(".calendar tbody tr").eq(i).find("td").eq(j);

            if (i === 0 && j < startDay) {
                // 前月部分
                const prevDay = lastMonthEndDayCount - startDay + 1 + j;
                $cell.text(prevDay).addClass("prev-month");
                continue;
            }

            if (dayCount > endDayCount) {
                // 翌月部分
                $cell.text(nextMonthDayCount).addClass("next-month");
                nextMonthDayCount++;
            } else {
                // 当月部分
                $cell.text(dayCount);

                // ✅ 初期表示時のみ：URL指定があればその日を選択して表示
                const thisDate = `${year}/${String(month).padStart(2,"0")}/${String(dayCount).padStart(2,"0")}`;
                if (selectedDateFromUrl && normalizeDate(selectedDateFromUrl) === normalizeDate(thisDate)) {
                    showWorkOut($cell);
                    $cell.addClass("today");
                }
                // ✅ URL指定がない場合のみ：今日をハイライト（初期表示用）
                else if (
                    !selectedDateFromUrl &&
                    dayCount === today.getDate() &&
                    month === today.getMonth() + 1 &&
                    year === today.getFullYear()
                ) {
                    showWorkOut($cell);
                    $cell.addClass("today");
                }

                dayCount++;
            }
        }
    }
}

// ===============================================
// ✅ 月変更時に選択するデフォルト日付
// - 当月（今日の年月）なら「今日」
// - それ以外なら「1日」
// ===============================================
function selectDefaultDateForCurrentMonth() {
    const today = new Date();
    const isThisMonth =
        currentYear === today.getFullYear() &&
        currentMonth === (today.getMonth() + 1);

    const targetDay = isThisMonth ? today.getDate() : 1;
    selectDayInCurrentMonth(targetDay);
}

// ===============================================
// ✅ 現在表示中の当月セルから「day」を探して選択する
// （なければ何もしない）
// ===============================================
function selectDayInCurrentMonth(day) {
    const $target = $(".calendar td:not(.prev-month):not(.next-month)").filter(function() {
        return parseInt($(this).text(), 10) === day;
    }).first();

    if ($target.length) {
        showWorkOut($target);
    }
}

// ===============================================
// カレンダー日付クリック → トレーニング記録表示変更
// ===============================================
async function showWorkOut($cell) {
    // ✅ ユーザーが操作したらURL指定は解除（以後の自動選択を防ぐ）
    selectedDateFromUrl = null;

    // 日付を取得
    const day = $($cell).text();
    const selectedDate = `${currentYear}/${String(currentMonth).padStart(2, "0")}/${String(day).padStart(2, "0")}`;
    $("#work-date").val(selectedDate);

    $(".calendar tbody td").removeClass("today");
    $cell.addClass("today");

    const workDate = String(currentMonth).padStart(2, "0") + "月" + String(day).padStart(2, "0") + "日の記録";
    $("#work-date-h3").text(workDate);

    // ワークアウト履歴取得
    try {
        const res = await ajaxGet("/workouts/by-date", { date: selectedDate });
        updateWorkoutTable(res);
    } catch (e) {
        alert("トレーニング履歴の取得に失敗しました。");
    }
}

// ===============================================
// モーダル表示
// ===============================================
function showModal() {
    $("#exerciseModal").modal("show");
}

// ===============================================
// 「追加」ボタン → 詳細登録画面へ遷移
// ===============================================
function transionInsert() {
    const date = $("#work-date").val();
    const exerciseId = $("#exercise").val();

    if (!exerciseId) {
        alert("種目を選択してください。");
        return;
    }

    const url = `/workouts/create?date=${encodeURIComponent(date)}&exercise_id=${encodeURIComponent(exerciseId)}`;
    window.location.href = url;
}

// ===============================================
// トレーニング履歴行 → 編集画面へ遷移
// ===============================================
function transionEdit($row) {
    const date = $("#work-date").val();
    const exerciseId = $row.find('input[type="hidden"]').val();
    const url = `/workouts/edit?date=${encodeURIComponent(date)}&exercise_id=${encodeURIComponent(exerciseId)}`;
    window.location.href = url;
}

// ===============================================
//  日付フォーマット統一用関数（2025-10-24 → 2025/10/24）
// ===============================================
function normalizeDate(str) {
    return str.replace(/-/g, "/");
}

// ===============================================
//  ワークアウト履歴表示更新
// ===============================================
function updateWorkoutTable(data) {
    const $tbody = $(".record-table tbody");
    $tbody.empty();

    if (!data.length) {
        $tbody.append(`<tr><td colspan="4">この日の記録はありません</td></tr>`);
        return;
    }

    data.forEach((w) => {
        const exerciseName = w.exercise_name ? w.exercise_name : "不明な種目";
        $tbody.append(`
            <tr>
                <td>${exerciseName}</td>
                <td>${w.sets.toLocaleString()} セット</td>
                <td>${w.total_weight.toLocaleString()} kg</td>
                <td>></td>
                <input type="hidden" value=${w.exercise_id}>
            </tr>
        `);
    });
}
