<?php
$config['administrator'] = array(
    'name' => '后台用户管理权限',
    'perm' => array(
        '普通用户---------------------------------------------',
//        'edit_self_password'               => '修改自己的密码',
//        'edit_self_info'                   => '修改自己的信息',

        '用户管理权限------------------------------------------',
        'view_user_info'                   => '查看所有用户信息',
        'edit_user_info'                   => '修改所有用户信息',
//        'change_user_password'             => '修改所有用户密码',
//        'change_user_perm'                 => '修改所有用户权限',
        'add_new_user'                     => '创建新用户',
//        'shield_user'                      => '屏蔽用户',
//        'liftshield_user'                  => '解除屏蔽用户',
//        'delete_user'                      => '删除用户',

        'KV配置-------------------------',
        'sup_kv_default'         => '配置列表',
        'sup_kv_add'             => '添加通用配置',
    ),
);

$config['index']    = array(
    'name'  => '管理首页',
    'perm'  => array(
        'index'                            => '总览',
        'soft_install'                     => '软件安装曲线',
    ),
);

$config['datas']    = array(
    'name'  => '数据查询',
    'perm'  => array(
        'user_data_table'               => '每日安装数据',
        'user_data_one_table'           => '一级渠道汇总数据',
        '返量计费数据------------------------------',
        'user_point_default'            => '用户流水记录',
        'user_daily_data_point'         => '用户账户牛币',
    ),
);


$config['yy_tools'] = array
(
    'name' => '营运工具',
    'perm' => array
    (

        '用户信息权限-------------------------',
        'user_manager_list'         => '用户信息列表',
        'user_company_list'         => '用户公司信息管理',
        'user_manager_change'       => '冻结解冻操作',

        '工资管理权限-------------------------',
        'salary_list'         => '渠道工资列表',
        'salary_pay'          => '工资发放管理',
        'salary_apply'        => '渠道提款申请',

        '流量管理权限--------------------------',
        'point_flow_add'       => '添加/扣除流量',

        '渠道包管理权限--------------------------',
        'apply_package'        => '渠道包申请列表',


        '其他管理权限---------------------------',
        'soft_list'                 => '软件列表',
        'soft_update'               => '软件更新',
        'anno'                      => '公告管理',
        'help_page'                 => '帮助中心',
        'send_message'              => '发送站内信',
        'message_index'             => '站内信列表',

    ),
);



return $config;