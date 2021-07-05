<?php


namespace App\Helpers;


class Constant
{
    const NOTIFICATION_TYPE = [
        'General'=>1,
        'Ticket'=>2,
        'Order'=>3,
        'Message' => 4
    ];
    const VERIFICATION_TYPE = [
        'Email'=>1,
        'Mobile'=>2
    ];
    const VERIFICATION_TYPE_RULES = '1,2';
    const TICKETS_STATUS = [
        'Open'=>1,
        'Closed'=>2
    ];
    const SENDER_TYPE = [
        'User'=>1,
        'Admin'=>2,
    ];
    const PAYMENT_METHOD = [
        'BankTransfer'=>1,
        'Cash'=>2,
    ];
    const PAYMENT_TYPES = [
        'Credit Card'=>1,
        'Mada'=>2,
        'Apple Pay'=>3,
    ];
    const PAYMENT_TYPES_RULES = '1,2,3';
    const PAYMENT_METHOD_RULES = '1,2';
    const TRANSACTION_STATUS = [
        'Pending'=>1,
        'Paid'=>2,
    ];
    const TRANSACTION_TYPES = [
        'Deposit'=>1,
        'Withdraw'=>2,
        'Holding'=>3,
    ];
    const SETTING_TYPE = [
        'Page'=>1,
        'Notification'=>2,
        'Values'=>3,
    ];
    const DISCOUNT_PAYMENT = [
        'Pending'=>0,
        'Done'=>1,
        'Cancel'=>2,
    ];
    const CATEGORY_USER_TYPE = [
        'All'=>0,
        'Customer'=>1,
        'Freelancer'=>2,
    ];
    const USER_TYPE=[
        'Customer'=>1,
        'Freelancer'=>2
    ];
    const PROVIDER_TYPE=[
        'Individual'=>1,
        'Company'=>2
    ];
    const PROVIDER_TYPE_RULES = '1,2';
    const USER_GENDER=[
        'Male'=>1,
        'Female'=>2
    ];
    const USER_TYPE_RULES = '1,2';
    const PORTFOLIO_MEDIA_TYPE=[
        'Image'=>1,
        'Youtube'=>2
    ];
    const PORTFOLIO_MEDIA_TYPE_RULES = '1,2';
    const PRODUCT_TYPE=[
        'Service'=>1,
        'Product'=>2
    ];
    const PRODUCT_TYPE_RULES = '1,2';
    const MEDIA_TYPES = [
        'Product'=>1,
        'Portfolio_Image' => 2,
        'Portfolio_video' => 3
    ];
    const ORDER_STATUSES = [
        'New' => 1,
        'Accept' => 2,
        'Rejected' => 3,
        'Canceled' => 4,
        'Payed' =>5,
        'InProgress' => 6,
        'Delivered' => 7,
        'Received' => 8,
        'NotDelivered' => 9,
        'NotReceived' => 10,
        'ReceivedByAdmin' => 11,
        'NotReceivedByAdmin' => 12,
    ];
    const COMPLETED_ORDER_STATUSES = [self::ORDER_STATUSES['Rejected'],self::ORDER_STATUSES['Canceled'],self::ORDER_STATUSES['Received'],self::ORDER_STATUSES['ReceivedByAdmin'],self::ORDER_STATUSES['NotReceivedByAdmin']];
    const ORDER_STATUSES_RULES = '1,2,3,4,5,6,7,8,9,10,11,12';
    const CHAT_MESSAGE_TYPE = [
        'Text'=>1,
        'Audio' => 2,
        'Image' => 3,
        'File' => 4,
    ];
    const CHAT_MESSAGE_TYPE_RULES = '1,2,3,4';
}
