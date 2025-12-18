$(function () {
    // 初期表示時に一度だけ整形
    formatAllWeights();

    // セット追加
    $("#addSet").on("click", function () {
        addSet();
    });

    // セット削除
    $("#removeSet").on("click", function () {
        removeSet();
    });
});

/**
 * 単一重量フォーマット
 * 10.00 → 10
 * 10.10 → 10.1
 * 10.25 → 10.25
 */
function formatWeight(value) {
    if (value === '' || value === null || value === undefined) return '';

    const num = Number(value);
    if (Number.isNaN(num)) return value;

    // Number化 → toString で不要な .00 を落とす
    return num.toString();
}

/**
 * 画面内のすべての weight を整形（初期表示用）
 */
function formatAllWeights(context = document) {
    $(context).find('.input-weight').each(function () {
        const val = $(this).val();
        $(this).val(formatWeight(val));
    });
}

function addSet() {
    const list = $('#set-list');
    const count = list.children().length + 1;

    const div = $(`
        <div class="set-row">
            <label class="set-label">セット ${count}</label>
            <input
                type="number"
                name="sets[${count - 1}][weight]"
                class="input-weight"
                placeholder="重量"
                step="0.01"
                inputmode="decimal"
                pattern="[0-9]*"
                value="0"
                required
            > kg
            <input
                type="number"
                name="sets[${count - 1}][reps]"
                class="input-reps"
                placeholder="回数"
                inputmode="decimal"
                pattern="[0-9]*"
                value="0"
                required
            > 回
        </div>
    `);

    list.append(div);

    // 追加直後にその要素だけ整形
    formatAllWeights(div);
}

function removeSet() {
    const list = $('#set-list');
    if (list.children().length > 1) {
        list.children().last().remove();
    }
}
