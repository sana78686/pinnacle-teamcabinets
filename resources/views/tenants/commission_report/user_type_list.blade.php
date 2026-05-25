@extends('layouts.tenant.master')
@section('title', 'User Type Commissions')
@section('breadcrumb-title')
    <h2>Commission <span>By User Type</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_commission_report_index') }}">Commission Report</a></li>
    <li class="breadcrumb-item active">User Type</li>
@endsection
@section('content')
    <div class="card tc-dash-card">
        <div class="card-body border-bottom">
            <form method="get" action="{{ route('tenant_commission_report_user_types') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label" for="user_type">Select user type</label>
                    <select name="user_type" id="user_type" class="form-select" required>
                        <option value="">Select type</option>
                        @foreach ($userTypes as $value => $label)
                            <option value="{{ $value }}" @selected($selectedType === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Show</button>
                </div>
            </form>
        </div>

        @if ($selectedType)
            <div class="card-body p-0">
                <div class="table-responsive table-sm">
                    <table class="table table-striped table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Point Factor</th>
                                <th>Gross Sales</th>
                                <th>Commission Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    <td>{{ $row['name'] }}</td>
                                    <td>{{ $row['point_factor'] }}</td>
                                    <td>${{ number_format((float) $row['gross_sales'], 2) }}</td>
                                    <td>${{ number_format((float) $row['commission_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No approved users found for this type.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                
                </div>
            </div>
        @endif
    </div>
@endsection
