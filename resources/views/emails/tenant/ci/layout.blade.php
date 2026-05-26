@include('emails.layouts.professional', [
    'bodyHtml' => $bodyHtml ?? '',
    'title' => $title ?? null,
    'preheader' => $preheader ?? null,
    'branding' => $branding ?? null,
    'simpleHeader' => false,
])
