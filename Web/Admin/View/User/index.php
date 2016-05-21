<?php
if ($list)
{
    ?>
    <table class="mainTable">
        <tr>
            <th width="40">ID</th>
            <th>用户名（昵称）</th>
            <th width="30">超管</th>
            <th width="30">禁止登录</th>
            <th width="30">最后登录时间</th>
            <th width="190">操作</th>
        </tr>
        <?php
        echo "<pre>";
        if ($list) foreach ($list as $item)
        {
            ?>
            <tr align="center">
                <td class="td1"><?php echo $item['id'];?></td>
                <td class="td2"><?php echo $item['username'];?></td>
                <td class="td2"><?php echo $item['is_super_admin']?'<font style="color:red">是</font>':'<font style="color:blue">否</font>';?></td>
                <td class="td2"><?php echo $item['shielded']?'<font style="color:red">是</font>':'<font style="color:green">否</font>';?></td>
                <td class="td2"><?php echo $item['last_login_time'];?></td>
                <td class="td2">
                    <input type="button" value="改设置" onclick="<?= "goto('/admin/user/edit/id/" . $item['id'] . "')"?>" />
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td class="td1" colspan="5"> </td>
            <td class="td1" align="center">
                <input type="button" class="submit" value="创建新用户" onclick="goto('<?php '/admin/add';?>')" />
            </td>
        </tr>
    </table>

    <center>
        <?php echo $pagehtml;?>
    </center>
<?php
}
else
{
    ?>
    <table class="mainTalbe">
        <tr>
            <td class="td1" align="center" height="60">没有指定的数据</td>
        </tr>
    </table>
<?php
}
?>
