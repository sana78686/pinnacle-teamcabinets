@php
    $selectedRole = $selectedRole ?? null;
    $showByDefault = ($showByDefault ?? false) || old('user_option', $selectedRole ? 'specific_user' : '') === 'specific_user';
@endphp
<div class="col-md-6 col-lg-4 user-type-wrap" style="{{ $showByDefault ? '' : 'display:none;' }}">
    <label class="form-label" for="target_role">User type<span class="text-danger"> *</span></label>
    <select name="target_role" id="target_role" class="form-select">
        <option value="">Select user type</option>
        @foreach (\App\Support\BulletinAudience::targetRoleOptions() as $value => $label)
            <option value="{{ $value }}" @selected(
                old('target_role')
                    ? old('target_role') === $value
                    : \App\Support\BulletinAudience::optionMatchesStored($selectedRole, $value)
            )>{{ $label }}</option>
        @endforeach
    </select>
</div>
