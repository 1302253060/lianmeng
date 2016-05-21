<form id="search_export_form">
    <input type="hidden" value="0" name="export" id="export">
    类型 <?=\Common\Helper\Form::select('type', $aQueryType, I('get.type'))?>
    <?=\Common\Helper\Form::input('value', I('get.value'))?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <?=\Common\Helper\Form::submit('', '查询', array('onclick' => "$('#export').val(0);$('#search_export_form').submit();return false;"))?>
<!--    <button class="search-export btn btn-small btn-warning export">导出</button>-->
</form>
<hr>
<table class="mainTable">
    <thead>
    <tr>
        <th>用户</th>
        <th>姓名</th>
        <th>身份</th>
        <th>所属渠道</th>
        <th>状态</th>
        <th>手机号</th>
        <th>QQ</th>
        <th>身份证认证</th>
        <th>地址</th>
        <th>注册时间</th>
        <th>是否禁止登录</th>
        <th style="width:80px;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($aList)) { foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['id'] ?></td>
            <td><?=$Item['name'] ?></td>
            <td><?=\Admin\Model\UserModel::getLevelName($Item['level']) ?></td>
            <td><?=\Admin\Model\UserModel::getParent($Item['parent_id'])['name'] ?></td>
            <td><?=\Admin\Model\UserModel::isFreeze($Item['status']) ? '<span style="color: #ff0000;">冻结</span>' : '正常' ?></td>
            <td><?=$Item['mobile']?></td>
            <td><?=$Item['qq']?></td>
            <td><?=\Admin\Model\UserModel::isIdcardOk($Item['idcard_ok']) ? '是' : '<span style="color: #ff0000;">否</span>' ?></td>
            <td><?=$Item['province'] . $Item['city'] . $Item['county'] . $Item['address'] ?></td>
            <td><?=$Item['create_time'] ?></td>
            <td><?=\Admin\Model\UserModel::isAllowLogin($Item['hidden']) ? '否' : '<span style="color: #ff0000;">是</span>'?></td>
            <td>
                <a href="/admin/usermanager/edit?id=<?=$Item['id']?>">编辑</a>
                <form action="edit" method="post" class="form-inline" style="display: inline">
                    <input type="hidden" name="id" value="<?=$Item->id?>">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php } else { ?>
        <tr>
            <td colspan="13" class="center">对不起，暂无相应数据</td>
        </tr>
    <?php }?>
    </tbody>
</table>
<div class="page"><?=$sPagination?></div>


<script type="text/javascript" src="/Public/statics/assets/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/plugin/bd.dlg.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/admin/user_manager.js"></script>
<script type="text/javascript" src="/Public/statics/zeroclipboard/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/Public/statics/assets/js/jquery.table-fixed-sides.js"></script>


