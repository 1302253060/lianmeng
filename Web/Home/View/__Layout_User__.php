<!DOCTYPE html>
<html>
<include file="./Web/Home/View/__Widget__/Head.php" />
<body>
<div id="page">
    <include file="./Web/Home/View/__Widget__/Top.php" />

    <?php
        unset($head_nav['User']);
        if (!in_array($SITE_HEADNAV, array_keys($head_nav))) {
    ?>
        <div class="main-body main-body-<?=$SITE_SIDEBAR?> has-sidebar">
            <div class="layout clearfix">
                <?php require_once "./Web/Home/View/__Widget__/Sidebar_" . $SIDEBAR . ".php"; ?>
                <div class="main-content">
                    <?php require_once $sMainTPL; ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
    <div class="main-body">
        <?php require_once $sMainTPL; ?>
    </div>
    <?php } ?>

    <include file="./Web/Home/View/__Widget__/Foot.php" />
</div>
</body>
</html>