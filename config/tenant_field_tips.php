<?php

/**
 * Default help text for tenant form fields (by input name or id).
 * Used by public/js/tenant-tooltips.js when a field has no title/data-tip.
 */
return [
    // Auth
    'login' => 'Sign in with your registered email address or username.',
    'password' => 'Your account password. Use at least 8 characters with letters and numbers.',
    'password_confirmation' => 'Re-enter your password exactly as above.',
    'remember' => 'Keep you signed in on this device until you log out.',
    'otp' => 'Enter the one-time code sent to your email.',
    'token' => 'Paste the reset token from your email if prompted.',

    // Registration / users
    'role' => 'Choose the account type that defines permissions for this user.',
    'role_id' => 'Select the role that controls what this user can access.',
    'username' => 'A unique login name. Letters, numbers, and underscores are typical.',
    'full_name' => 'The person\'s full legal or display name.',
    'name' => 'Full name or title for this record, as shown in the system.',
    'email' => 'A valid email used for login, notifications, and password recovery.',
    'phone' => 'Primary contact number, including area code.',
    'country_id' => 'Country where the user or business is located.',
    'state_id' => 'State or province for shipping and tax rules.',
    'city_name' => 'City name for the address on file.',
    'city_id' => 'Select the city from the list for this state.',
    'county_name' => 'County name when required for local tax or delivery.',
    'county_id' => 'Select the county associated with this address.',
    'zip_code' => 'Postal or ZIP code for delivery and tax calculation.',
    'address' => 'Street address including number and street name.',
    'note' => 'Internal notes visible to staff; not shown to customers.',
    'is_taxable_user' => 'Check if this account is exempt from sales tax.',
    'business_name' => 'Registered or trading name of the dealer business.',
    'company_name' => 'Legal company name shown on documents and emails.',
    'dealer_code' => 'Your assigned dealer or account code, if applicable.',
    'commission_rate' => 'Percentage commission applied to qualifying orders.',
    'status' => 'Active users can sign in; inactive accounts are blocked.',

    // Products & catalog
    'catalog_id' => 'Product catalog this item belongs to (pricing and visibility).',
    'section_id' => 'Cabinet category or section within the catalog.',
    'door_color_id' => 'Door style / color variant for this product.',
    'label' => 'Display name shown in quotes, orders, and product lists.',
    'sku' => 'Stock keeping unit — unique product identifier.',
    'weight' => 'Shipping weight in pounds (decimals allowed).',
    'price' => 'Base unit price before discounts or factors.',
    'cost' => 'Product price in US dollars (decimals allowed).',
    'description' => 'Detailed product description for staff and customers.',
    'image' => 'Upload a product image (JPG or PNG recommended).',
    'product_label' => 'Label shown for this door style or variant.',
    'assemble_price' => 'Default assembly cost for products in this cabinet section (optional).',
    'product_catalog_id' => 'Product catalog this door style belongs to.',
    'pdf' => 'Upload a PDF catalog file or paste a direct https:// link.',
    'assemble_cost' => 'Optional assembly labor cost added to the product.',
    'qty' => 'Default quantity per unit (usually 1).',
    'factor' => 'Point or pricing factor applied for this catalog and door style.',

    // Orders & quotes
    'order_number' => 'System or customer reference number for this order.',
    'quote_number' => 'Reference number for this shipping or product quote.',
    'customer_id' => 'Customer or dealer account linked to this record.',
    'shipping_address' => 'Full delivery address for freight or courier.',
    'quantity' => 'Number of units ordered or quoted.',
    'total' => 'Line or order total after factors and adjustments.',
    'comments' => 'Additional instructions or notes for this order or quote.',

    // Settings & CMS
    'logo' => 'Company logo displayed in the tenant portal header.',
    'contactus_phone' => 'Phone number shown on the public Contact Us page.',
    'contactus_email' => 'Email address for Contact Us form submissions.',
    'newuser_phone' => 'Phone for new user registration inquiries.',
    'newuser_email' => 'Email for new dealer registration requests.',
    'host' => 'SMTP server hostname (e.g. smtp.gmail.com).',
    'port' => 'SMTP port (587 for TLS, 465 for SSL).',
    'encryption' => 'Mail encryption: tls, ssl, or none.',
    'username' => 'SMTP login username or email.',
    'password' => 'SMTP password or app-specific password.',
    'from_address' => 'Default sender email address for outgoing mail.',
    'from_name' => 'Display name shown as the email sender.',
    'facebook' => 'Full URL to your Facebook business page.',
    'twitter' => 'Full URL to your X (Twitter) profile.',
    'youtube' => 'Full URL to your YouTube channel.',
    'title' => 'Page or section title shown in the browser and listings.',
    'content' => 'Main body content for this page or email template.',
    'meta_title' => 'SEO title tag for search engines (keep under 60 characters).',
    'meta_description' => 'Short SEO description for search result snippets.',
    'slug' => 'URL-friendly path segment (lowercase, hyphens only).',
    'sort_order' => 'Lower numbers appear first in lists.',
    'instagram' => 'Full URL to your Instagram profile.',

    // Home page settings
    'banner_image' => 'Hero banner image or video for the public home page.',
    'benner_title' => 'Main headline shown on the home page banner.',
    'benner_description' => [
        'text' => 'Supporting text under the banner headline. Use the editor for bold, links, and lists.',
        'placement' => 'top',
    ],
    'aboutus_image' => 'Image displayed in the About Us section.',
    'aboutus_title' => 'Title for the About Us section.',
    'aboutus_description' => 'Description text for the About Us section.',
    'card_one_title' => 'Title for the first feature card on the home page.',
    'card_one_description' => ['text' => 'Description for the first feature card.', 'placement' => 'bottom'],
    'card_two_title' => 'Title for the second feature card.',
    'card_two_description' => ['text' => 'Description for the second feature card.', 'placement' => 'right'],
    'card_three_title' => 'Title for the third feature card.',
    'card_three_description' => ['text' => 'Description for the third feature card.', 'placement' => 'left'],

    // CMS / pages
    'parent_id' => 'Parent page in the site menu hierarchy (optional).',
    'show_in_menu' => 'Show this page in the public website navigation menu.',
    'order_no' => 'Sort order in menus; lower numbers appear first.',
    'status' => 'Draft pages are hidden from the public site; published pages are live.',

    // Email / documentation / legal
    'message' => 'Message body or main text content for this section.',
    'body' => 'Full text content for this document or template.',
    'subject' => 'Email subject line sent to recipients.',
    'template' => 'Email or message template identifier.',
    'type' => 'Category or type for this settings record.',

    // Roles & bulletins
    'permissions' => 'Capabilities granted to users with this role.',
    'bulletin_title' => 'Headline shown on the bulletin board.',
    'bulletin_body' => 'Message body visible to selected user roles.',
    'published_at' => 'Date and time when this bulletin becomes visible.',
    'expires_at' => 'Optional date when this bulletin is hidden automatically.',

    // Stock check & claims
    'stock_quantity' => 'Counted quantity on hand at time of check.',
    'claim_reason' => 'Brief reason for this warranty or damage claim.',
    'claim_amount' => 'Requested credit or reimbursement amount.',

    // Billing
    'card_name' => 'Name as it appears on the payment card.',
    'coupon' => 'Promotional or trial coupon code, if you have one.',
];
