<?php

namespace App\Constants;

class StatusConstants
{
    const ACTIVE = "Active";
    const INACTIVE = "Inactive";
    const CREATED = "Created";
    const STARTED = "Started";
    const APPROVED = "Approved";
    const SUSPENDED = "Suspended";
    const PENDING = "Pending";
    const COMPLETED = "Completed";
    const PROCESSING = "Processing";
    const CANCELLED = "Cancelled";
    const DECLINED = "Declined";
    const ENDED = "Ended";
    const DELETED = "Deleted";


    // STOCK STATUS
    const AVAILABLE = "Available";
    const UNAVAILABLE = "Unavailable";
    const TO_BE_ANNOUNCED = "To Be Announced";



    const ACTIVE_OPTIONS = [
        self::ACTIVE => "Active",
        self::INACTIVE => "Inactive",
    ];

    const PUBLISH_OPTIONS = [
        self::ACTIVE => "Active",
        self::INACTIVE => "Inactive",
    ];

    const STOCK_STATUS = [
        self::AVAILABLE => "Available",
        self::UNAVAILABLE => "Unavailable",
    self::TO_BE_ANNOUNCED => "To Be Announced",

    ];

    const BOOL_OPTIONS = [
        1 => "Yes",
        0 => "No",
    ];


    const WITHDRAWAL_OPTIONS = [
        self::PENDING => "Pending",
        self::PROCESSING => "Processing",
        self::COMPLETED => "Completed",
        self::DECLINED => "Declined",
    ];

    const TRANSACTION_OPTIONS = [
        self::PENDING => "Pending",
        self::COMPLETED => "Completed",
        self::DECLINED => "Declined",
    ];
}
