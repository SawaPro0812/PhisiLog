// =============================================================
// グローバル状態
// =============================================================
let exerciseMode = 'create';       // create | edit
let editingExerciseItem = null;    // 編集対象の li DOM


// =============================================================
// 初期化処理（イベントハンドラ）
// =============================================================
$(function () {

    // ===== DOMキャッシュ =====
    const $tabs               = $('.exercise-tab');
    const $addButton          = $('.exercise-add-btn');
    const $exerciseModal      = $('#exerciseModal');
    const $exerciseSubmitBtn  = $('#exerciseSubmitButton');

    // =========================================================
    // カテゴリタブクリック
    // =========================================================
    $tabs.on('click', function () {
        const $clicked = $(this);

        $tabs.removeClass('is-active');
        $clicked.addClass('is-active');

        filterByCategory($clicked.data('category'));
    });

    // 初期表示（is-active or 先頭）
    const $initialTab = $tabs.filter('.is-active').first().length
        ? $tabs.filter('.is-active').first()
        : $tabs.first();

    if ($initialTab.length) {
        filterByCategory($initialTab.data('category'));
    }

    // =========================================================
    // ＋ボタン → 新規登録モーダル
    // =========================================================
    $addButton.on('click', function () {
        exerciseMode = 'create';
        editingExerciseItem = null;

        resetModalForm();
        $('#exerciseSubmitButton').text('追加');

        const modal = bootstrap.Modal.getOrCreateInstance($exerciseModal[0]);
        modal.show();
    });

    // =========================================================
    // 行クリック → 編集モーダル
    // =========================================================
    $(document).on('click', '.exercise-item:not(.exercise-item-empty)', function () {
        openEditModal($(this));
    });

    // =========================================================
    // 追加 / 更新 実行
    // =========================================================
    $exerciseSubmitBtn.on('click', function () {
        const param = {
            name: $("#exercise-name-input").val(),
            category: $("#exercise-category-select").val(),
            id: $("#exercise-id-select").val()
        };

        if (!param.name || !param.category) {
            alert('種目名とカテゴリを入力してください');
            return;
        }

        if (exerciseMode === 'edit' && editingExerciseItem) {
            updateExercise(param);
        } else {
            storeExercise(param);
        }

        const modal = bootstrap.Modal.getInstance($exerciseModal[0]);
        if (modal) modal.hide();
    });

    $(document).on('click', '#exerciseDeleteButton', function () {
        if (!editingExerciseItem) return;

        if (!confirm('この種目を削除しますか？')) return;

        deleteExercise();
    });
});


// =============================================================
// 新規登録（AJAX）
// =============================================================
async function storeExercise(param) {
    try {
        const res = await ajaxPost("/exercises/store", param);

        if (res.status === "success" && res.exercise) {
            appendExercise(res.exercise);
        }
    } catch (e) {
        console.error(e);
        alert("種目登録に失敗しました。");
    }
}


// =============================================================
// 更新
// =============================================================
async function updateExercise(param) {
    if (!editingExerciseItem) return;

    try {
        const res = await ajaxPost("/exercises/update", param);
        console.log(res);
        if (res.status === "success" && res.exercise) {

            const ex = res.exercise;

            // ===============================
            // ① DOMを更新
            // ===============================
            editingExerciseItem
                .find('.exercise-name')
                .text(ex.name);

            editingExerciseItem
                .attr('data-category', ex.category)
                .data('category', ex.category);

            // ===============================
            // ② 表示制御
            // ===============================
            const $activeTab = $('.exercise-tab.is-active');
            const activeCategory = $activeTab.data('category');

            if (activeCategory === ex.category) {
                editingExerciseItem.css('display', 'flex');
            } else {
                editingExerciseItem.hide();
            }

            // ===============================
            // ③ 「種目がありません」再判定
            // ===============================
            filterByCategory(activeCategory);
        }

    } catch (e) {
        console.error(e);
        alert("種目更新に失敗しました。");
    }
}



// =============================================================
// 種目をリストに追加（表示制御込み）
// =============================================================
function appendExercise(ex) {
    const $emptyItem = $('.exercise-item-empty');

    const $newItem = $(`
        <li class="exercise-item" data-category="${ex.category}">
            <span class="exercise-color-bar"></span>
            <span class="exercise-name">${ex.name}</span>
        </li>
    `);

    const $activeTab = $('.exercise-tab.is-active');
    const activeCategory = $activeTab.data('category');

    if (activeCategory === ex.category) {
        $newItem.css('display', 'flex');
        $emptyItem.hide();
    } else {
        $newItem.hide();
    }

    $emptyItem.before($newItem);
}


// =============================================================
// カテゴリフィルタ
// =============================================================
function filterByCategory(category) {
    const $items     = $('.exercise-item').not('.exercise-item-empty');
    const $emptyItem = $('.exercise-item-empty');

    let visibleCount = 0;

    $items.each(function () {
        const $item = $(this);
        if ($item.data('category') === category) {
            $item.css('display', 'flex');
            visibleCount++;
        } else {
            $item.hide();
        }
    });

    if (visibleCount === 0) {
        $emptyItem.show();
    } else {
        $emptyItem.hide();
    }
}


// =============================================================
// 編集モーダル表示
// =============================================================
function openEditModal($item) {
    exerciseMode = 'edit';
    editingExerciseItem = $item;

    $("#exercise-name-input").val(
        $item.find('.exercise-name').text().trim()
    );
    $("#exercise-category-select").val(
        $item.data('category')
    );
    $("#exercise-id-select").val(
        $item.find('.exercise-id').val()
    );

    $('#exerciseSubmitButton').text('更新');
    $('#exerciseDeleteButton').show();   // ← ここ

    const modal = bootstrap.Modal.getOrCreateInstance($('#exerciseModal')[0]);
    modal.show();
}


// =============================================================
// モーダル初期化
// =============================================================
function resetModalForm() {
    $("#exercise-name-input").val('');
    $("#exercise-category-select").val('');

    $('#exerciseSubmitButton').text('追加');
    $('#exerciseDeleteButton').hide();   // ← 新規時は非表示

    editingExerciseItem = null;
}

async function deleteExercise() {
    try {
        const param = {
            id: $("#exercise-id-select").val()
        };

        const res = await ajaxPost('/exercises/delete', param);
        console.log(res);
        if (res.status === 'success') {
            // DOM削除
            editingExerciseItem.remove();

            // 表示再評価
            const $activeTab = $('.exercise-tab.is-active');
            if ($activeTab.length) {
                filterByCategory($activeTab.data('category'));
            }

            // モーダル閉じる
            const modal = bootstrap.Modal.getInstance($('#exerciseModal')[0]);
            if (modal) modal.hide();
        }
    } catch (e) {
        console.error(e);
        alert('削除に失敗しました');
    }
}
