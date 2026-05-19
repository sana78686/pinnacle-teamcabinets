<?php

namespace App\Mail;

use App\Mail\Concerns\BuildsCiTenantEmail;
use App\Models\ManageEmailsContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockCheckAdminMail extends Mailable
{
    use BuildsCiTenantEmail, Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $contentHtml,
    ) {}

    public function build(): static
    {
        return $this->buildCiTenantEmail(ManageEmailsContent::SLUG_STOCK_ADMIN, [
            'USERNAME' => $this->userName,
            'CONTENT' => $this->contentHtml,
        ]);
    }
}
