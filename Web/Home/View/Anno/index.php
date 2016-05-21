<div class="main-content-body soft-list layout">
    <div class="anno-content">
        <h2>公告</h2>
        <ul>
            <?php if (!empty($aList)) foreach ($aList as $aItem) { ?>
                <li>
                    <span><?=$aItem['create_time']?></span><a href="/Home/anno/detail?id=<?=$aItem['id']?>"><?=$aItem['title']?>
                        <?php if ($aItem['status'] == 2) { ?>
                        【最新】
                        <?php } ?>
                    </a></li>
            <?php } ?>

        </ul>
    </div>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>
