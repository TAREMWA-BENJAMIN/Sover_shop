<?php

namespace App\Constants;

class Status{

    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    CONST TICKET_OPEN   = 0;
    CONST TICKET_ANSWER = 1;
    CONST TICKET_REPLY  = 2;
    CONST TICKET_CLOSE  = 3;

    CONST PRIORITY_LOW    = 1;
    CONST PRIORITY_MEDIUM = 2;
    CONST PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    const ORDER_PENDING    = 0 ;
    const ORDER_COMPLETED  = 1 ;
    const ORDER_PROCESSING = 2 ;
    const ORDER_CANCELLED  = 3 ;


    const PAY_PENDING = 0;
    const PAY_PAID    = 1;

    const INSIDE_CITY  = 1;
    const OUTSIDE_CITY = 2;

    const PAYMENT_TYPE_DIRECT           = 1;
    const PAYMENT_TYPE_CASH_ON_DELIVERY = 2;

    const HOT_DEAL_ADD = 1;
    const HOT_DEAL_REMOVE = 0;
    

}
