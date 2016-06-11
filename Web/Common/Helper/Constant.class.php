<?php
namespace Common\Helper;

class Constant
{
    const LOCK_THIRD_IMPORT = 'LianMeng::cli::lock.third_import';
    const LOCK_HAS_USER = 'LianMeng::cli::lock.has_user';

    const REDIS_DAILY_UPDATE_DATE = "LianMeng::dailycount::update_date";

    const LOCK_COUNT_DATA = 'LianMeng::cli::lock.count_data';
    const REDIS_COUNT_DATA_QUEUE = "LianMeng::count_data::queue";


    const LOCK_DATA_IMPORT  = 'LianMeng::cli::lock.data_import';
    const LOCK_POINT_FLOW   = 'LianMeng::cli::lock.point_flow';
    const LOCK_DAILY_RANK   = 'LianMeng::cli::lock.daily_rank';

    const LOCK_VirtualMachine   = 'LianMeng::cli::lock.VirtualMachine';

    const LOCK_CHECK_ORDER  = 'LianMeng::cli::lock.check_order';

    const LOCK_CHANNEL_BASE_DATA = 'LianMeng::cli::lock.statistic';

    const REDIS_CLI_RUN_RECORD = 'LianMeng::cli::run_record';

    const NIUBI_RANK        = 100;
    const RMB2NB            = 100;
    const DAYS_AGO_CAL_POINT = 8; //计算几天前的积分流水

    const DB_POINT_FLOW_ADD_EFFECT  = 0;
    const DB_POINT_FLOW_ADD_EX_BACK = 1;
    const DB_POINT_FLOW_SUB_ORDER   = -1;


    const CDN_URL    = 'http://download.d2gf.com/'; #CDN url
    const IMAGE_URL  = 'http://d2gf.com/'; #CDN url
    const UPLOAD_DIR = './Public/Uploads/'; #CDN url



    const FLUSHAPCU_EXPIRES = 86400;

    const DAY_GET_INV_CODE_NUM = 50;



}
