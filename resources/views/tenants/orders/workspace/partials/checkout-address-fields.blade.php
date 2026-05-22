@php
    $p = $prefix;
    $nameKey = $p === 'bill' ? 'bill_to_name' : 'ship_to_name';
    $addrKey = $p === 'bill' ? 'bill_to_address' : 'ship_to_address';
    $cityKey = $p === 'bill' ? 'bill_to_city' : 'ship_city';
    $stateKey = $p === 'bill' ? 'bill_to_state' : 'ship_state';
    $countyKey = $p === 'bill' ? 'bill_to_county' : 'ship_county';
    $countryKey = $p === 'bill' ? 'bill_to_country' : 'ship_country';
    $zipKey = $p === 'bill' ? 'bill_to_zip' : 'ship_zip';
    $emailKey = $p === 'bill' ? 'bill_to_email' : 'ship_to_email';
    $phoneKey = $p === 'bill' ? 'bill_to_phone' : 'ship_to_phone';
@endphp

<div class="form-group">
    <label>Name <span class="tc-req">*</span></label>
    <input type="text" name="{{ $nameKey }}" class="form-control form-control-sm" value="{{ old($nameKey, $data[$nameKey] ?? '') }}" required>
    <div class="field-error err_{{ $nameKey }}"></div>
</div>
<div class="form-group">
    <label>Address <span class="tc-req">*</span></label>
    <textarea name="{{ $addrKey }}" class="form-control form-control-sm" rows="2" required>{{ old($addrKey, $data[$addrKey] ?? '') }}</textarea>
    <div class="field-error err_{{ $addrKey }}"></div>
</div>
<div class="form-group">
    <label>City <span class="tc-req">*</span></label>
    <input type="text" name="{{ $cityKey }}" class="form-control form-control-sm" value="{{ old($cityKey, $data[$cityKey] ?? $data['ship_to_city'] ?? '') }}" required>
    <div class="field-error err_{{ $cityKey }}"></div>
</div>
<div class="form-group">
    <label>State <span class="tc-req">*</span></label>
    @if (! empty($isShip) && ! empty($states))
        <select name="{{ $stateKey }}" id="ship_state" class="form-control form-control-sm" required>
            @foreach ($states as $stateName)
                <option value="{{ $stateName }}" @selected(old($stateKey, $shipState ?? '') === $stateName)>{{ $stateName }}</option>
            @endforeach
        </select>
    @else
        <input type="text" name="{{ $stateKey }}" class="form-control form-control-sm" value="{{ old($stateKey, $data[$stateKey] ?? $data['bill_to_state'] ?? '') }}" required>
    @endif
    <div class="field-error err_{{ $stateKey }}"></div>
</div>
<div class="form-group">
    <label>County <span class="tc-req">*</span></label>
    @if (! empty($isShip))
        <div id="ow-ship-county-wrap">
            @if (! empty($isFlShip) && ! empty($floridaCounties))
                <select name="ship_county" id="ship_county" class="form-control form-control-sm" required>
                    @foreach ($floridaCounties as $countyName)
                        <option value="{{ $countyName }}" @selected(old('ship_county', $shipCounty ?? '') === $countyName)>{{ $countyName }}</option>
                    @endforeach
                </select>
            @else
                <input type="text" name="ship_county" id="ship_county" class="form-control form-control-sm" value="{{ old('ship_county', $shipCounty ?? '') }}" required>
            @endif
        </div>
    @else
        <input type="text" name="{{ $countyKey }}" class="form-control form-control-sm" value="{{ old($countyKey, $data[$countyKey] ?? $data['bill_to_county'] ?? '') }}" required>
    @endif
    <div class="field-error err_{{ $countyKey }}"></div>
</div>
<div class="form-group">
    <label>Country <span class="tc-req">*</span></label>
    <input type="text" name="{{ $countryKey }}" class="form-control form-control-sm" value="{{ old($countryKey, $data[$countryKey] ?? $data['bill_to_country'] ?? 'USA') }}" required>
    <div class="field-error err_{{ $countryKey }}"></div>
</div>
<div class="form-group">
    <label>Zip <span class="tc-req">*</span></label>
    <input type="text" name="{{ $zipKey }}" class="form-control form-control-sm" value="{{ old($zipKey, $data[$zipKey] ?? $data['ship_to_zipcode'] ?? $data['bill_to_zipcode'] ?? '') }}" required>
    <div class="field-error err_{{ $zipKey }}"></div>
</div>
<div class="form-group">
    <label>Email <span class="tc-req">*</span></label>
    <input type="email" name="{{ $emailKey }}" class="form-control form-control-sm" value="{{ old($emailKey, $data[$emailKey] ?? '') }}" required>
    <div class="field-error err_{{ $emailKey }}"></div>
</div>
<div class="form-group mb-0">
    <label>Phone <span class="tc-req">*</span></label>
    <input type="text" name="{{ $phoneKey }}" class="form-control form-control-sm" value="{{ old($phoneKey, $data[$phoneKey] ?? '') }}" required>
    <div class="field-error err_{{ $phoneKey }}"></div>
</div>
