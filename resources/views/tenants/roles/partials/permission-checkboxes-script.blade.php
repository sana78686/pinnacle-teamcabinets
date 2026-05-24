<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-all-checkbox').forEach(function (master) {
            master.addEventListener('change', function () {
                const module = this.dataset.module;
                document.querySelectorAll('.permission-checkbox[data-module="' + module + '"]').forEach(function (box) {
                    box.checked = master.checked;
                });
            });
        });
    });
</script>
