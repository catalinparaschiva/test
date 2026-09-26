<?php

class WI_Subscriber_Service_Config
{
    const SERVICE_METHOD_COUNT = 'count';
    const SERVICE_METHOD_COUNT_UNSUBSCRIBERS = 'count_unsubscribers';
    const SERVICE_METHOD_DIRECT_SAVE = 'direct_save';
    const SERVICE_METHOD_SAVE = 'save';
    const SERVICE_METHOD_SELECT = 'select';
    const SERVICE_METHOD_SELECT_ONE = 'select_one';
    const SERVICE_METHOD_UPDATE = 'update';
    const SERVICE_METHOD_APPEND = 'append';
    const SERVICE_METHOD_UNSUBSCRIBE = 'unsubscribe';
    const SERVICE_METHOD_RESUBSCRIBE = 'resubscribe';
    const SERVICE_METHOD_MOBILE_SAVE = 'mobile_save';
    // NETLINX BEGIN
    const SERVICE_METHOD_ANONYMIZE = 'anonymize';
    const SERVICE_METHOD_TRIGGER_LINK = 'trigger_link';
    // NETLINX END
    const SERVICE_METHOD_CREATE_SEGMENT = 'create_segment';
    const SERVICE_METHOD_REPORT_BY_SEGMENT = 'report_by_segment';
    const SERVICE_METHOD_REPORT_BY_LIST = 'report_by_list';

    const SERVICE_RETURN_DATA_TYPE_JSON = 1;
    const SERVICE_RETURN_DATA_TYPE_JSONP = 2;
    const SERVICE_RETURN_DATA_TYPE_APPLICATION_JSON = 3;
}