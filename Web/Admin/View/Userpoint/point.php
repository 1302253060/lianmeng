<form>
    用户ID：<?=\Common\Helper\Form::input('user_id', isset($_GET['user_id']) ? $_GET['user_id'] : '')?>
    <input type="submit" value="查询">
</form>
<hr>

<?php if ($aList) :?>
    <table class="table">
        <thead>
            <tr>
                <th>序号</th>
                <th>用户ID</th>
                <th>当前剩余流量</th>
                <th>已提流量</th>
                <th>更新时间</th>
            </tr>
        </thead>
        <?php $i=0; foreach ($aList as $aValue) : $i++;?>
            <tr>
                <td><?=$i?></td>
                <td><?=$iUserId = $aValue['user_id']?></td>
                <td><?=number_format($aValue['point'], 0, ',', ',')?></td>
                <td><?=number_format($aValue['order_point'], 0, ',', ',')?></td>
                <td><?=$aValue['update_time']?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <div class="page"><?=$sPagination?></div>
<?php else : if($_GET) echo '暂无相关数据'; endif;?>