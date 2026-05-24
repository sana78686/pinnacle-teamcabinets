@php
    $lines = $lines ?? [];
    $totalWeight = (float) ($sub_total_weight ?? 0);
    if ($totalWeight <= 0) {
        $totalWeight = collect($lines)->sum(fn ($line) => ((float) ($line['weight'] ?? 0)) * ((int) ($line['quantity'] ?? 1)));
    }
@endphp
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 20px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #cccccc; border-top:3px solid #398ebd; border-collapse: collapse;">
                <tr>
                    <td bgcolor="#ffffff" style="padding: 20px; color: #333; font-family: Arial, sans-serif; font-size: 13px; line-height: 20px;">
                        <div style="font-size: 22px; font-weight: bold; padding-bottom: 15px;">STOCK CHECK REQUEST</div>
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr style="background:#dedfde;">
                                <td><b>Double Check Work</b></td>
                                <td><b>Product</b></td>
                                <td><b>Description</b></td>
                                <td align="right"><b>Quantity</b></td>
                                <td align="right"><b>Unit Weight</b></td>
                                <td align="right"><b>Total Weight</b></td>
                                <td align="right"><b>Item Line</b></td>
                            </tr>
                            @forelse ($lines as $line)
                                @php
                                    $qty = max(1, (int) ($line['quantity'] ?? 1));
                                    $unitWeight = (float) ($line['weight'] ?? 0);
                                    $lineWeight = $unitWeight * $qty;
                                    $yellow = ! empty($line['check_yellow']) ? 'Y' : '-';
                                    $green = ! empty($line['check_green']) ? 'G' : '-';
                                @endphp
                                <tr>
                                    <td>{{ $yellow }} / {{ $green }}</td>
                                    <td>{{ ($line['sku'] ?? '') . ($line['cabinet_name'] ? ' - '.$line['cabinet_name'] : '') }}</td>
                                    <td>{{ $line['description'] ?? '' }}</td>
                                    <td align="right">{{ $qty }}</td>
                                    <td align="right">{{ number_format($unitWeight, 2) }} lbs</td>
                                    <td align="right">{{ number_format($lineWeight, 2) }} lbs</td>
                                    <td align="right">{{ $line['note'] ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No line items found.</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="5"></td>
                                <td align="right"><b>TOTAL WEIGHT</b></td>
                                <td align="right"><b>{{ number_format($totalWeight, 2) }} lbs</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
