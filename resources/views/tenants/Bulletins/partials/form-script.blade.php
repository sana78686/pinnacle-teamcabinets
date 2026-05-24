<script>
    document.addEventListener('DOMContentLoaded', function() {
        const option = document.getElementById('select_user_send_option');
        const roleWrap = document.querySelector('.user-type-wrap');
        const roleSelect = document.getElementById('target_role');

        function syncRoleField() {
            const show = option && option.value === 'specific_user';
            if (roleWrap) {
                roleWrap.style.display = show ? '' : 'none';
            }
            if (roleSelect) {
                roleSelect.required = show;
                if (!show) {
                    roleSelect.value = '';
                }
            }
        }

        option?.addEventListener('change', syncRoleField);
        syncRoleField();
    });
</script>
