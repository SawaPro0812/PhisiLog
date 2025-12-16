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

        // 月移動時はURL選択を無効化（ボタン操作を優先）
        selectedDateFromUrl = null;

        createCalendar(currentYear, currentMonth);
        selectDefaultDateForCurrentMonth(); // 1日 or 今日（自動）
    });

    // 次月ボタン
    $("#next-month").on("click", function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }

        // 月移動時はURL選択を無効化（ボタン操作を優先）
        selectedDateFromUrl = null;

        createCalendar(currentYear, currentMonth);
        selectDefaultDateForCurrentMonth(); // 1日 or 今日（自動）
    });

    // カレンダー日付クリック（イベント委譲）
    $(document).on("click", ".calendar td", function() {
        const $cell = $(this);

        // 空セルは無視
        if (!$cell.text()) return;

        // 前月/翌月セルはクリック不可
        if ($cell.hasClass("prev-month") || $cell.hasClass("next-month")) return;

        // ✅ ユーザー操作として扱う
        showWorkOut($cell, { userAction: true });
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

    const startDate = new Date(year, month - 1, 1);
    const endDate   = new Date(year, month, 0);
    const endDayCount = endDate.getDate();

    const lastMonthEndDate = new Date(year, month - 1, 0);
    const lastMonthEndDayCount = lastMonthEndDate.getDate();

    const startDay = startDate.getDay();

    let dayCount = 1;
    let nextMonthDayCount = 1;

    $(".calendar tbody td").text("").removeClass("today prev-month next-month");
    $(".month-header h2").text(`${year}年${month}月`);

    for (let i = 0; i < 6; i++) {
        for (let j = 0; j < 7; j++) {
            const $cell = $(".calendar tbody tr").eq(i).find("td").eq(j);

            if (i === 0 && j < startDay) {
                const prevDay = lastMonthEndDayCount - startDay + 1 + j;
                $cell.text(prevDay).addClass("prev-month");
                continue;
            }

            if (dayCount > endDayCount) {
                $cell.text(nextMonthDayCount).addClass("next-month");
                nextMonthDayCount++;
            } else {
                $cell.text(dayCount);

                const thisDate = `${year}/${String(month).padStart(2,"0")}/${String(dayCount).padStart(2,"0")}`;

                // ✅ URL指定があればその日を選択（自動選択なのでURLは消さない）
                if (selectedDateFromUrl && normalizeDate(selectedDateFromUrl) === normalizeDate(thisDate)) {
                    showWorkOut($cell, { userAction: false });
                    $cell.addClass("today");
                }
                // ✅ URL指定がない場合のみ今日をハイライト
                else if (
                    !selectedDateFromUrl &&
                    dayCount === today.getDate() &&
                    month === today.getMonth() + 1 &&
                    year === today.getFullYear()
                ) {
                    showWorkOut($cell, { userAction: false });
                    $cell.addClass("today");
                }

                dayCount++;
            }
        }
    }
}

// ===============================================
// 月変更時に選択するデフォルト日付
// ===============================================
function selectDefaultDateForCurrentMonth() {
    const today = new Date();
    const isThisMonth =
        currentYear === today.getFullYear() &&
        currentMonth === (today.getMonth() + 1);

    const targetDay = isThisMonth ? today.getDate() : 1;
    selectDayInCurrentMonth(targetDay);
}

function selectDayInCurrentMonth(day) {
    const $target = $(".calendar td:not(.prev-month):not(.next-month)").filter(function() {
        return parseInt($(this).text(), 10) === day;
    }).first();

    if ($target.length) {
        // ✅ 自動選択扱い
        showWorkOut($target, { userAction: false });
    }
}

// ===============================================
// カレンダー日付クリック → トレーニング記録表示変更
// ===============================================
async function showWorkOut($cell, options = { userAction: false }) {
    // ✅ ユーザー操作のときだけURL指定を解除
    if (options.userAction) {
        selectedDateFromUrl = null;
    }

    const day = $($cell).text();
    const selectedDate = `${currentYear}/${String(currentMonth).padStart(2, "0")}/${String(day).padStart(2, "0")}`;
    $("#work-date").val(selectedDate);

    $(".calendar tbody td").removeClass("today");
    $cell.addClass("today");

    const workDate = String(currentMonth).padStart(2, "0") + "月" + String(day).padStart(2, "0") + "日の記録";
    $("#work-date-h3").text(workDate);

    try {
        const res = await ajaxGet("/workouts/by-date", { date: selectedDate });
        updateWorkoutTable(res);
    } catch (e) {
        alert("トレーニング履歴の取得に失敗しました。");
    }
}

function showModal() {
    $("#exerciseModal").modal("show");
}

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

function transionEdit($row) {
    const date = $("#work-date").val();
    const exerciseId = $row.find('input[type="hidden"]').val();
    if (exerciseId) {
        const url = `/workouts/edit?date=${encodeURIComponent(date)}&exercise_id=${encodeURIComponent(exerciseId)}`;
        window.location.href = url;
    }
}

function normalizeDate(str) {
    return str.replace(/-/g, "/");
}

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
