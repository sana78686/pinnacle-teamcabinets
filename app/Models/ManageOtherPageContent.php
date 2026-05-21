<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ManageOtherPageContent extends Model
{
    use BelongsToTenant;

    protected $table = 'manage_other_page_contents';

    protected $fillable = [
        'tenant_id',
        'slug',
        'title',
        'page_content',
    ];
}
