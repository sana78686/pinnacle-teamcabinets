<?php

return [

    /** Default rows per page on tenant panel list screens */
    'list_per_page' => (int) env('TENANT_LIST_PER_PAGE', 15),

    /** Bell icon poll interval (milliseconds) */
    'notifications_poll_ms' => (int) env('TENANT_NOTIFICATIONS_POLL_MS', 15000),

    /** Support chat message poll interval (milliseconds) */
    'support_chat_poll_ms' => (int) env('TENANT_SUPPORT_CHAT_POLL_MS', 4000),

];
