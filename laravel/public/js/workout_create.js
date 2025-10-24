$(function(){
    // セット追加
    $("#addSet").on("click", function() {
        addSet();
    });

    // セット削除
    $("#removeSet").on("click", function() {
        removeSet();
    });
});

function addSet() {
    const list = $('#set-list');
    const count = list.children().length + 1;

    const div = $(`
        <div class="set-row">
            <label class="set-label">セット ${count}</label>
            <input type="number" name="sets[${count - 1}][weight]" class="input-weight" placeholder="重量" required> kg
            <input type="number" name="sets[${count - 1}][reps]" class="input-reps" placeholder="回数" required> 回
        </div>
    `);

    list.append(div);
}

function removeSet() {
    const list = $('#set-list');
    if (list.children().length > 1) {
        list.children().last().remove();
    }
}