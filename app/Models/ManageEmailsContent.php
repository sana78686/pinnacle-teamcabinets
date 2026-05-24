<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageEmailsContent extends Model
{
    use SoftDeletes;

    protected $table = 'manage_emails_content';

    protected $fillable = [
        'email_slug',
        'email_type',
        'email_subject',
        'email_content',
        'macro',
        'email_from',
    ];

    public const SLUG_REGISTER_ADMIN = 'register_admin';

    public const SLUG_REGISTER_USER = 'register_user';

    public const SLUG_FORGOT_PASSWORD = 'forgot_password_user';

    public const SLUG_RESET_PASSWORD_LINK = 'reset_password_link';

    public const SLUG_USER_STATUS = 'user_status';

    public const SLUG_LOGIN_OTP = 'login_otp';

    public const SLUG_ORDER_USER = 'order_email_to_user';

    public const SLUG_ORDER_ADMIN = 'order_email_to_admin';

    public const SLUG_ORDER_WAREHOUSE = 'order_email_to_warehouse';

    public const SLUG_ORDER_REP = 'order_email_to_rep';

    public const SLUG_ORDER_STATUS = 'order_status_to_user';

    public const SLUG_CLAIM_ADMIN = 'claim_email_to_admin';

    public const SLUG_CLAIM_USER = 'claim_email_to_user';

    public const SLUG_AFFILIATE_REGISTER = 'affiliate_register_to_user';

    public const SLUG_USER_REG_BY_ADMIN = 'user_reg_by_admin';

    public const SLUG_CONTACT_US = 'contact_us';

    public const SLUG_USER_QUERY = 'user_query_to_admin';

    public const SLUG_SHIPPING_ADMIN = 'shipping_quote_req_to_admin';

    public const SLUG_SHIPPING_USER = 'shipping_quote_req_to_user';

    public const SLUG_STOCK_ADMIN = 'stock_check_req_to_admin';

    public const SLUG_STOCK_USER = 'stock_check_req_to_user';

    public const SLUG_STOCK_WAREHOUSE = 'stock_check_req_to_warehouse';

    public const SLUG_STOCK_UPDATE_ADMIN = 'update_stock_check_req_to_admin';

    public static function findBySlug(string $slug): ?self
    {
        return static::query()->where('email_slug', $slug)->first();
    }
}
