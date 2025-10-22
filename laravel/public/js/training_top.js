// ===============================================
// グローバル変数として現在の年月を保持
// ===============================================
let currentYear = new Date().getFullYear();
let currentMonth = new Date().getMonth() + 1;

$(function(){
    createCalendar(currentYear, currentMonth);

    // 前月ボタン
    $("#prev-month").on("click", function() {
        currentMonth--;
        if (currentMonth < 1) {
            currentMonth = 12;
            currentYear--;
        }
        createCalendar(currentYear, currentMonth);
    });

    // 次月ボタン（必要なら）
    $("#next-month").on("click", function() {
        currentMonth++;
        if (currentMonth > 12) {
            currentMonth = 1;
            currentYear++;
        }
        createCalendar(currentYear, currentMonth);
    });
});

// ===============================================
// カレンダー表示
// ===============================================
function createCalendar(year, month) {
    const date = new Date(year, month - 1);
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

                // 今日の場合のみクラス追加
                if (
                    dayCount === today.getDate() &&
                    month === today.getMonth() + 1 &&
                    year === today.getFullYear()
                ) {
                    $cell.addClass("today");
                }
                dayCount++;
            }
        }
    }
}
