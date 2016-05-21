<div class="main-content-body soft-list layout">
    <ul class="packet-soft-list-top">
        <li><a class="packet-soft-list-top-padding <?php if ($type == 'app') { echo "packet-soft-list-top-active"; }?>" href="/Home/packet/?type=app">移动端推广软件</a></li>
        <li><a class="packet-soft-list-top-padding <?php if ($type == 'pc') { echo "packet-soft-list-top-active"; }?>" href="/Home/packet/?type=pc">PC端推广软件</a></li>
    </ul>
    <table class="table">
        <thead>
        <tr>
            <th class="soft-name">推广软件</th>
            <th class="soft-price">结算价格（100流量=1元）</th>
            <th class="soft-effect-rule" align="left">有效安装规则</th>
            <th class="soft-operation">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($aSoft)) foreach ($aSoft as $aItem) { ?>
            <tr>
                <td class="soft-name size-medium">
                    <img src="<?= $aItem['logo'] ?>" width="48" height="48"/>
                    &nbsp;
                    <?= $aItem['name'] ?>
                </td>
                <td><span class="size-big color-blue-b">
                    <?= $aItem['price'] * \Common\Helper\Constant::NIUBI_RANK ?></span> 流量
                </td>
                <td class="soft-effect-rule">
                    <?= !empty($aItem['index_intro']) ? $aItem['index_intro'] : '-' ?>
                </td>
                <td><a href="/Home/packet/detail?id=<?= $aItem['id'] ?>">详情</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
