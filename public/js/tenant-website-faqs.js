(function () {
    var list = document.getElementById('tc-faq-list');
    var addBtn = document.getElementById('tc-faq-add');

    if (!list || !addBtn) {
        return;
    }

    function renumber() {
        list.querySelectorAll('.tc-faq-row').forEach(function (row, index) {
            var label = row.querySelector('strong');
            if (label) {
                label.textContent = 'FAQ #' + (index + 1);
            }
        });
    }

    function bindRemove(btn) {
        btn.addEventListener('click', function () {
            var row = btn.closest('.tc-faq-row');
            if (row) {
                row.remove();
                renumber();
            }
        });
    }

    function createRow() {
        var index = list.querySelectorAll('.tc-faq-row').length + 1;
        var wrap = document.createElement('div');
        wrap.className = 'tc-faq-row card mb-2';
        wrap.innerHTML =
            '<div class="card-body">' +
            '<div class="d-flex justify-content-between align-items-start mb-2">' +
            '<strong class="f-14">FAQ #' +
            index +
            '</strong>' +
            '<button type="button" class="btn btn-outline-danger btn-sm tc-faq-remove" aria-label="Remove FAQ">Remove</button>' +
            '</div>' +
            '<div class="tc-field mb-2"><label>Question</label>' +
            '<input type="text" name="faq_question[]" class="form-control" maxlength="500" placeholder="e.g. What does RTA mean?"></div>' +
            '<div class="tc-field mb-0"><label>Answer</label>' +
            '<textarea name="faq_answer[]" class="form-control" rows="3" maxlength="5000" placeholder="Answer shown on your website"></textarea></div>' +
            '</div>';
        list.appendChild(wrap);
        bindRemove(wrap.querySelector('.tc-faq-remove'));
    }

    list.querySelectorAll('.tc-faq-remove').forEach(bindRemove);

    addBtn.addEventListener('click', function () {
        createRow();
        renumber();
    });
})();
