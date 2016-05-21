<?php
$pre = '/admin';
$admin_menu = array();
$admin_menu['index'] = array
(
    'innerHTML' => '管理首页',
    'id' => 'top_menu_channel_div',
    'icon' => 'home_64.png',
    'huizong' => array(
        'innerHTML' => '平台近况',
        'index' => array
        (
            'href'      => $pre . '/',
            'innerHTML' => '总览',
            'perm'      => 'index.index',
        ),
        'soft_install' => array
        (
            'innerHTML' => '软件安装曲线',
            'href'      => $pre . '/index/soft_install',
            'perm'      => 'index.soft_install',
        ),
    ),
);

$admin_menu['datas'] = array
(
    'innerHTML' => '数据查询',
    'icon' => 'datas_64.png',
    'huizong'     => array(
        'innerHTML' => '统计数据汇总',
        'user_data_table' => array(
            'innerHTML' => '每日安装数据',
            'href'      => $pre . '/userdata/',
            'perm'      => 'datas.user_data_table',
        ),
        'user_data_one_table' => array(
            'innerHTML' => '一级渠道汇总数据',
            'href'      => $pre . '/userdata/one',
            'perm'      => 'datas.user_data_one_table',
        ),
    ),
    'point_manage' => array(
        'innerHTML' => '返量计费数据',
        'user_point' => array(
            'innerHTML' => '用户流水记录',
            'href'      => $pre . '/userpoint/',
            'perm'      => 'datas.user_point_default',
        ),
        'user_daily_data_point' => array(
            'innerHTML' => '用户账户流量',
            'href'      => $pre . '/userpoint/point',
            'perm'      => 'datas.user_daily_data_point',
        ),
    ),

);

$admin_menu['yy_tools'] = array
(
    'innerHTML' => '运营工具',
    'id' => 'top_menu_channel_div',
    'icon' => 'yytools_64.png',
    'manager_user' => array(
        'innerHTML' => '用户管理',
        'user_manager_list' => array(
            'innerHTML' => '用户信息列表',
            'href'      => $pre . '/usermanager/',
            'perm'      => 'yy_tools.user_manager_list',
        ),
        'user_manager_edit' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/usermanager/',
            'href'      => $pre . '/usermanager/edit',
            'perm'      => 'yy_tools.user_manager_list',
        ),
        'user_manager_edit_post' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/usermanager/',
            'href'      => $pre . '/usermanager/edit_post',
            'perm'      => 'yy_tools.user_manager_list',
        ),
        'user_company_list' => array(
            'innerHTML' => '用户公司信息管理',
            'href'      => $pre . '/usercompany/',
            'perm'      => 'yy_tools.user_company_list',
        ),
        'user_company_edit' => array(
            'innerHTML' => '',
            'href'      => $pre . '/usercompany/edit',
            'direct'    => $pre . '/usercompany/',
            'perm'      => 'yy_tools.user_company_list',
        ),
        'user_company_edit_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/usercompany/edit_post',
            'direct'    => $pre . '/usercompany/',
            'perm'      => 'yy_tools.user_company_list',
        ),
        'user_manager_change' => array(
            'innerHTML' => '冻结解冻操作',
            'href'      => $pre . '/usermanager/change',
            'perm'      => 'yy_tools.user_manager_change',
        ),
    ),


    'manager_salary' => array(
        'innerHTML' => '工资管理',
        'salary_list' => array(
            'innerHTML' => '渠道工资列表',
            'href'      => $pre . '/salary/',
            'perm'      => 'yy_tools.salary_list',
        ),
        'salary_channel' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/salary/',
            'href'      => $pre . '/salary/channel',
            'perm'      => 'yy_tools.salary_list',
        ),
        'salary_update_price' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/salary/',
            'href'      => $pre . '/salary/update_price',
            'perm'      => 'yy_tools.salary_list',
        ),
        'salary_pay' => array(
            'innerHTML' => '工资发放管理',
            'href'      => $pre . '/salary/pay',
            'perm'      => 'yy_tools.salary_pay',
        ),
        'salary_pay_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/salary/pay_post',
            'direct'    => $pre . '/salary/pay',
            'perm'      => 'yy_tools.salary_pay',
        ),
        'salary_apply' => array(
            'innerHTML' => '渠道提款申请',
            'href'      => $pre . '/salary/apply',
            'perm'      => 'yy_tools.salary_apply',
        ),
        'salary_apply_agree' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/salary/pay',
            'href'      => $pre . '/salary/apply_agree',
            'perm'      => 'yy_tools.salary_apply',
        ),
        'salary_apply_reject' => array(
            'innerHTML' => '',
            'direct'    => $pre . '/salary/pay',
            'href'      => $pre . '/salary/apply_reject',
            'perm'      => 'yy_tools.salary_apply',
        ),
//        'user_manager_edit_post' => array(
//            'innerHTML' => '',
//            'direct'    => $pre . '/usermanager/',
//            'href'      => $pre . '/usermanager/edit_post',
//            'perm'      => 'yy_tools.user_manager_list',
//        ),
    ),

    'manager_liuliang' => array(
        'innerHTML' => '流量管理',
        'point_flow_add' => array(
            'innerHTML'  => '添加/扣除流量',
            'href'       => $pre . '/pointflow/add',
            'perm'       => 'yy_tools.point_flow_add',
        ),
        'point_flow_add_post' => array(
            'innerHTML'  => '',
            'direct'     => $pre . '/pointflow/add',
            'href'       => $pre . '/pointflow/add_post',
            'perm'       => 'yy_tools.point_flow_add',
        ),
    ),


    'manager_apply_package' => array(
        'innerHTML' => '渠道包管理',
        'apply_package' => array(
            'innerHTML'  => '渠道包申请列表',
            'href'       => $pre . '/apply/',
            'perm'       => 'yy_tools.apply_package',
        ),
        'apply_package_edit' => array(
            'innerHTML'  => '',
            'href'       => $pre . '/apply/edit',
            'direct'     => $pre . '/apply/',
            'perm'       => 'yy_tools.apply_package',
        ),
        'apply_package_edit_post' => array(
            'innerHTML'  => '',
            'href'       => $pre . '/apply/edit_post',
            'direct'     => $pre . '/apply/',
            'perm'       => 'yy_tools.apply_package',
        ),
    ),



    'manager_other' => array(
        'innerHTML' => '其他管理',
        'soft_list' => array(
            'innerHTML' => '软件管理',
            'href'      => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_list',
        ),
        'soft_add' => array(
            'innerHTML' => '',
            'href'      => $pre . '/soft/add',
            'direct'    => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_update',
        ),
        'soft_add_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/soft/add_post',
            'direct'    => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_update',
        ),
        'soft_edit' => array(
            'innerHTML' => '',
            'href'      => $pre . '/soft/edit',
            'direct'    => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_update',
        ),
        'soft_edit_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/soft/edit_post',
            'direct'    => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_update',
        ),
        'soft_update_order' => array(
            'innerHTML' => '',
            'href'      => $pre . '/soft/update_order',
            'direct'    => $pre . '/soft/',
            'perm'      => 'yy_tools.soft_update',
        ),


        'anno' => array(
            'innerHTML' => '公告管理',
            'href'      => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'anno_add' => array(
            'innerHTML' => '',
            'href'      => $pre . '/anno/add',
            'direct'    => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'anno_add_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/anno/add_post',
            'direct'    => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'anno_edit' => array(
            'innerHTML' => '',
            'href'      => $pre . '/anno/edit',
            'direct'    => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'anno_edit_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/anno/edit_post',
            'direct'    => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'anno_delete' => array(
            'innerHTML' => '',
            'href'      => $pre . '/anno/delete',
            'direct'    => $pre . '/anno/',
            'perm'      => 'yy_tools.anno',
        ),
        'help_page' => array(
            'innerHTML' => '帮助中心配置',
            'href'      => $pre . '/help/',
            'perm'      => 'yy_tools.help_page',
        ),
        'help_page_edit' => array(
            'innerHTML' => '',
            'href'      => $pre . '/help/edit',
            'perm'      => 'yy_tools.help_page',
        ),
        'help_page_edit_post' => array(
            'innerHTML' => '',
            'href'      => $pre . '/help/edit_post',
            'perm'      => 'yy_tools.help_page',
        ),
    ),
    'message' => array(
        'innerHTML' => '发送站内信',
        'send_message' => array(
            'innerHTML' => '发送站内信',
            'href'      => $pre . '/message/add',
            'perm'      => 'yy_tools.send_message',
        ),
        'send_message_add' => array(
            'innerHTML' => '',
            'href'      => $pre . '/message/add_post',
            'direct'    => $pre . '/message/add',
            'perm'      => 'yy_tools.send_message',
        ),
        'message_index' => array(
            'innerHTML' => '站内信列表',
            'href'      => $pre . '/message/',
            'perm'      => 'yy_tools.message_index',
        ),
    ),
);


$admin_menu['member'] = array
(
    'innerHTML' => '员工管理',
    'icon'      => 'member_64.png',
    'admin' => array
    (
        'innerHTML' => '员工管理',
        'list' => array
        (
            'innerHTML' => '员工列表',
            'href'      => $pre . '/user/index',
            'perm'      => 'administrator.view_user_info',
        ),
        'edit' => array
        (
            'innerHTML' => '',
            'direct'    => $pre . '/user/index',
            'href'      => $pre . '/user/edit',
            'perm'      => 'administrator.edit_user_info',
        ),
        'edit_post' => array
        (
            'innerHTML' => '',
            'direct'    => $pre . '/user/index',
            'href'      => $pre . '/user/edit_post',
            'perm'      => 'administrator.edit_user_info',
        ),
        'add' => array
        (
            'innerHTML' => '添加员工',
            'href'      => $pre . '/user/add',
            'perm'      => 'administrator.add_new_user',
        ),

    ),


    'kv' => array
    (
        'innerHTML' => 'KV配置',
        'default' => array
        (
            'innerHTML' => '通用配置列表',
            'href'      => $pre . '/kv/',
            'perm'      => 'sup.sup_kv_default',
        ),
        'add' => array
        (
            'innerHTML' => '添加通用配置',
            'href'      => $pre . '/kv/add',
            'perm'      => 'sup.sup_kv_add',
        ),
        'add_post' => array
        (
            'innerHTML' => '',
            'href'      => $pre . '/kv/add_post',
            'perm'      => 'sup.sup_kv_add',
        ),
    ),
);


return $admin_menu;