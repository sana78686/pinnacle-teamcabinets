@extends($inSettings ? 'layouts.tenant.settings' : tenant_panel_layout())

@section('title', 'Profile')

@section('breadcrumb-title')
    <h2>Profile</h2>
@endsection

@section('breadcrumb-items')
    @if ($inSettings)
        <li class="breadcrumb-item">Settings</li>
    @endif
    <li class="breadcrumb-item active">My Profile</li>
@endsection

@section($inSettings ? 'setting_content' : 'content')
@if (! $inSettings)
    @include('partial.message')
@endif
<div class="tc-profile-page">
    <p class="tc-profile-page__lead">Manage your account details and password.</p>

    <div class="tc-profile-layout">
        <aside class="tc-profile-card tc-profile-card--summary">
            <div class="tc-profile-avatar-wrap">
                @if ($user->logo && file_exists(public_path($user->logo)))
                    <img src="{{ tenant_media_url($user->logo) }}" alt="" class="tc-profile-avatar-img">
                @else
                    <div class="tc-profile-avatar" aria-hidden="true">{{ $user->initials }}</div>
                @endif
            </div>
            <h3 class="tc-profile-name">{{ $user->name }}</h3>
            <span class="tc-profile-role-badge">
                <i data-feather="shield" aria-hidden="true"></i>
                {{ $roleLabel }}
            </span>

            <ul class="tc-profile-meta">
                <li>
                    <span class="tc-profile-meta__icon"><i data-feather="mail" aria-hidden="true"></i></span>
                    <span class="tc-profile-meta__body">
                        <span class="tc-profile-meta__label">Email</span>
                        <span class="tc-profile-meta__value">{{ $user->email }}</span>
                    </span>
                </li>
                <li>
                    <span class="tc-profile-meta__icon"><i data-feather="calendar" aria-hidden="true"></i></span>
                    <span class="tc-profile-meta__body">
                        <span class="tc-profile-meta__label">Joined</span>
                        <span class="tc-profile-meta__value">{{ $user->created_at?->format('F j, Y') ?? '—' }}</span>
                    </span>
                </li>
                @if ($user->phone)
                    <li>
                        <span class="tc-profile-meta__icon"><i data-feather="phone" aria-hidden="true"></i></span>
                        <span class="tc-profile-meta__body">
                            <span class="tc-profile-meta__label">Phone</span>
                            <span class="tc-profile-meta__value">{{ $user->phone }}</span>
                        </span>
                    </li>
                @endif
            </ul>
        </aside>

        <div class="tc-profile-main">
            <section class="tc-profile-card">
                <div class="tc-profile-card__head">
                    <span class="tc-profile-card__icon"><i data-feather="user" aria-hidden="true"></i></span>
                    <div>
                        <h4 class="tc-profile-card__title">Personal information</h4>
                        <p class="tc-profile-card__subtitle">Update your name, contact details, and registration information.</p>
                    </div>
                </div>

                <form class="tc-profile-form" method="POST" action="{{ $profileUpdateRoute }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            @include('layouts.tenant.partials.image-upload-field', [
                                'name' => 'logo',
                                'id' => 'profile_logo',
                                'label' => 'Profile photo',
                                'currentPath' => $user->logo ?? null,
                                'wrapperClass' => '',
                                'hint' => 'Optional. '.\App\Support\MediaUpload::hint(),
                            ])
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_role">Role</label>
                            <input type="text" class="form-control" id="profile_role" value="{{ $roleLabel }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="profile_username" name="username"
                                value="{{ old('username', $user->username) }}" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_full_name">Full name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="profile_full_name" name="full_name"
                                value="{{ old('full_name', $user->name) }}" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_email">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="profile_email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_phone">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="profile_phone" name="phone"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_company">Company name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="profile_company" name="company_name"
                                value="{{ old('company_name', $user->company_name) }}">
                            @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_country">Country</label>
                            <select class="form-select @error('country_id') is-invalid @enderror" id="profile_country" name="country_id">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @selected(old('country_id', $user->country_id) == $country->id)>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_state">State</label>
                            <select class="form-select @error('state_id') is-invalid @enderror" id="profile_state" name="state_id">
                                <option value="">Select state</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @selected(old('state_id', $user->state_id) == $state->id)>{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('state_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_city">City</label>
                            <input type="text" class="form-control @error('city_name') is-invalid @enderror" id="profile_city" name="city_name"
                                value="{{ old('city_name', $user->city_name) }}">
                            @error('city_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="profile_zip">Zip code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="profile_zip" name="zip_code"
                                value="{{ old('zip_code', $user->zip_code) }}">
                            @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="profile_address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="profile_address" name="address"
                                value="{{ old('address', $user->address) }}">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="tc-profile-form__actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" aria-hidden="true"></i>
                            Save changes
                        </button>
                    </div>
                </form>
            </section>

            <section class="tc-profile-card">
                <div class="tc-profile-card__head">
                    <span class="tc-profile-card__icon"><i data-feather="lock" aria-hidden="true"></i></span>
                    <div>
                        <h4 class="tc-profile-card__title">Change password</h4>
                        <p class="tc-profile-card__subtitle">Keep your account secure with a strong password.</p>
                    </div>
                </div>

                <form class="tc-profile-form" method="POST" action="{{ $passwordUpdateRoute }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="old_password">Current password</label>
                            <div class="tc-password-field">
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" required autocomplete="current-password">
                                <button type="button" class="tc-password-toggle" data-target="old_password" aria-label="Show password">
                                    <i data-feather="eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('old_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="new_password">New password</label>
                            <div class="tc-password-field">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required minlength="8" autocomplete="new-password" placeholder="Min. 8 characters">
                                <button type="button" class="tc-password-toggle" data-target="new_password" aria-label="Show password">
                                    <i data-feather="eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('new_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="confirm_password">Confirm new password</label>
                            <div class="tc-password-field">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" required autocomplete="new-password" placeholder="Re-enter new password">
                                <button type="button" class="tc-password-toggle" data-target="confirm_password" aria-label="Show password">
                                    <i data-feather="eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('confirm_password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="tc-profile-form__actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="lock" aria-hidden="true"></i>
                            Update password
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

@section($inSettings ? 'setting_script' : 'script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.feather) feather.replace();

    document.querySelectorAll('.tc-password-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) return;
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            var icon = btn.querySelector('[data-feather]');
            if (icon) icon.setAttribute('data-feather', show ? 'eye-off' : 'eye');
            if (window.feather) feather.replace();
        });
    });
});
</script>
@endsection
