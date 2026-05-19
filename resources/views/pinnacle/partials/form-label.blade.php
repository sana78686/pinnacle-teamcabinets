<label class="pn-label" for="{{ $for }}">
    {{ $label }}
    @if (!empty($required))<span class="pn-req">*</span>@endif
    @if (!empty($tip))
        <span class="pn-tip" data-tip="{{ $tip }}" tabindex="0" role="button" aria-label="{{ $tip }}"><i>i</i></span>
    @endif
</label>
