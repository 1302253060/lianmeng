<p><a href="/admin/anno/add">》添加</a></p>
<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th style="width: 100px;">状态</th>
        <th style="width: 120px;">创建时间</th>
        <th style="width: 120px;">更新时间</th>
        <th style="width: 100px;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($aList as $Item): ?>
        <tr>
            <td><?=$Item['id']?></td>
            <td><?=$Item['title']?></td>
            <td><?php
                switch ($Item['status']) {
                    case 0:
                        echo '<span style="color: red; text-decoration: line-through">隐藏</span>';
                        break;
                    case 1:
                        echo '<span style="color: #00008b">普通</span>';
                        break;
                    case 2:
                        echo '<span style="color: green">最新</span>';
                        break;
                }
            ?></td>
            <td><?=$Item['create_time']?></td>
            <td><?=$Item['update_time']?></td>
            <td>
                <a href="/admin/anno/edit?id=<?=$Item['id']?>">编辑</a> |
                <form action="delete" method="post" class="form-inline" style="display: inline">
                    <input type="hidden" name="id" value="<?=$Item['id']?>">
                    <a href="/admin/anno/delete?id=<?=$Item['id']?>" onclick="if (confirm('确定删除吗?')){$(this).parent('form').submit(); return false;} else {return false;}">删除</a>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="page">
    <?=$sPagination?>
</div>
