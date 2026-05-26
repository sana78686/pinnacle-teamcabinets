@php
    /** @var \App\Models\Bulletin $bulletin */
    $fileUrl = $bulletin->attachmentUrl();
@endphp

<div class="tc-role-dashboard__bulletin">
    @if ($fileUrl)
        <div class="tc-role-dashboard__viewer-actions mb-2">
            <a href="{{ $fileUrl }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">
                @if ($bulletin->isPdfAttachment())
                    Open PDF
                @else
                    Open attachment
                @endif
            </a>
        </div>
        <div class="tc-role-dashboard__viewer mb-2">
            @if ($bulletin->isImageAttachment())
                <img src="{{ $fileUrl }}" alt="{{ $bulletin->bulletin_title }}" class="tc-role-dashboard__viewer-img">
            @elseif ($bulletin->isPdfAttachment())
                <object data="{{ $fileUrl }}#toolbar=1" type="application/pdf" class="tc-role-dashboard__viewer-object">
                    <p class="tc-role-dashboard__viewer-fallback mb-0">
                        No preview available.
                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener">Open PDF</a>
                    </p>
                </object>
            @else
                <div class="tc-role-dashboard__viewer-fallback">
                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener">Download attachment</a>
                </div>
            @endif
        </div>
    @else
        <div class="tc-role-dashboard__viewer tc-role-dashboard__viewer--empty mb-2">
            <span>No preview available</span>
        </div>
    @endif

    @if (filled($bulletin->bulletin_description))
        <div class="tc-role-dashboard__bulletin-body-text">
            {!! nl2br(e($bulletin->bulletin_description)) !!}
        </div>
    @endif
</div>
