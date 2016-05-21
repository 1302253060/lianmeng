<div>
    <table>
        <tr>
            <td>一级渠道: <span id="total_new_channel"><?=$aTotal['aNewUser']['one']?></span> 人</td>
            <td>二级渠道: <span id="total_new_tec"><?=$aTotal['aNewUser']['two']?></span> 人</td>
            <td>自提用户: <span id="total_selfhelp_user_num"><?=$aTotal['aSelfHelp']['user_num']?></span> 人</td>
            <td>自提总金额: ￥<span id="total_selfhelp_point"><?=$aTotal['aSelfHelp']['point']?></span></td>
        </tr>
    </table>
</div>

<div style="clear : both;"></div>
<div>
    <h3>昨日返量数据入库情况</h3>
    <table class="maintable" style="text-align: center;">
        <tr>
            <th style="width: 125px;"></th>
            <?php foreach($aAllSoft as $iSoftId => $aValue) :?>
                <th><?=$aValue['name'] . '<br>' . "({$iSoftId})"?></th>
            <?php endforeach;?>
        </tr>
        <tr>
            <td><?=date('Y-m-d', time() - 86400)?></td>
            <?php
            foreach($aAllSoft as $iSoftId => $aValue) {
                echo "<td>" . (isset($aDataImportFinished[$iSoftId]) ? '✓' : '<span style="color: red; font-weight: bold; font-size: 20px;">✕</span>') . "</td>";
            }
            ?>
        </tr>
    </table>
</div>

<div>
    <div style="width: 50%; display: inline-block; overflow: auto;">
        <h3>历史返量数据未入库情况</h3>
        <table class="maintable" style="text-align: center;">
            <tr>
                <th style="width: 125px;"></th>
                <?php foreach($aDataImportMiss['soft'] as $iSoftId) :?>
                    <th><?=$aAllSoft[$iSoftId]['name'] . '<br>' . "({$iSoftId})"?></th>
                <?php endforeach;?>
            </tr>
            <?php foreach($aDataImportMiss['data'] as $sDate => $aSoftId):?>
            <tr>
                <td><?=$sDate?></td>
                <?php foreach($aDataImportMiss['soft'] as $iSoftId):?>
                <td><?=isset($aSoftId[$iSoftId]) ? '✕' : '';?></td>
                <?php endforeach;?>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
