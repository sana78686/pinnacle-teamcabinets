<?php

return [

    /** Default rows per page on tenant panel list screens */
    'list_per_page' => (int) env('TENANT_LIST_PER_PAGE', 15),

    /** Bell icon poll interval (milliseconds) */
    'notifications_poll_ms' => (int) env('TENANT_NOTIFICATIONS_POLL_MS', 15000),

];
