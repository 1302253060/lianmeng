<form>
    开始日期：<?=\Common\Helper\Form::input_date('start_date', $sStartDate)?>
    至
    <?=\Common\Helper\Form::input_date('end_date', $sEndDate)?>
    用户ID：<?=\Common\Helper\Form::textarea('find_value', $param['find_value'], array('placeholder' => '一行一条记录,仅ID查询有效', 'class' => 'input-small', 'style' => 'height : 2em; width: 200px;',))?>
    牛币得失：<?=\Common\Helper\Form::select('is_sub', $aIsSub, $iIsSub)?>
    类型：<?=\Common\Helper\Form::select('type', array('' => '全部') + $aAllType, $iType)?>
    <input type="submit" value="查询">
</form>
<hr>

<?php if ($aList) :?>
    <table class="table">
        <thead>
            <tr>
                <th>序号</th>
                <th>用户ID</th>
                <th>到账日期</th>
                <th>牛币得失</th>
                <th>类型</th>
                <th>牛币</th>
                <th style="width: 20%;">详情</th>
                <th>添加时间</th>
            </tr>
        </thead>
        <?php $i=0; foreach ($aList as $aValue) : $i++;?>
            <tr>
                <td><?=$i?></td>
                <td><?=$aValue['user_id']?></td>
                <td><?=$aValue['date']?></td>
                <td><?=$aValue['is_sub'] == \Admin\Model\PointFlowModel::IS_SUB_YES ? '<span style="color: red; font-size: 20px;">-</span>' : '<span style="color: blue; font-size: 20px;">+</span>'?></td>
                <td><?=\Admin\Model\PointFlowModel::$aAllType[$aValue['type']]?></td>
                <td><?=$aValue['point']?></td>
                <td><?php $aTypeDetail = unserialize($aValue['type_detail']); echo $aTypeDetail['detail']?></td>
                <td><?=$aValue['create_time']?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <div class="page"><?=$sPagination?></div>
<?php else : if($_GET) echo '暂无相关数据'; endif;?>