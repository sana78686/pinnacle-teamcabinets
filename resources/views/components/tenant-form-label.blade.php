@props(['for' => null, 'label' => '', 'required' => false, 'tip' => null])

<label @if($for) for="{{ $for }}" @endif {{ $attributes }}>
    {{ $label }}
    @if ($required)<span class="txt-danger">*</span>@endif
    @if ($tip)
        <span class="tc-tip" data-tip="{{ $tip }}" tabindex="0" role="button" aria-label="{{ $tip }}"><i>i</i></span>
    @endif
</label>
