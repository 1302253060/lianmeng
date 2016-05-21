<div class="main-content-body soft-list layout" style="min-height: 500px; height: auto;">
    <div class="help-left">
        <div class="location">
            当前位置：<a href="/Home/help/">帮助中心</a>>
            <a href="/Home/help/detail?id=<?=$aData['id']?>"><?=$aData['title']?></a>
        </div>

        <div class="help-left-header">
            <h2><?=$aData['title']?></h2>
        </div>

        <div class="help-left-text">
            <?=$aData['content']?>

        </div>

    </div>
    <div class="help-right">
        <div class="help-right-question">
            <h2>热门问题</h2>
            <ul>
                <?php foreach ($aRec as $aVal) { ?>
                    <li><a href="/Home/help/detail?id=<?=$aVal['id']?>"><?=$aVal['title']?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
