<div>
    <a href="/admin/kv/add">
        <?=\Common\Helper\Form::input('add', '添加配置', array('type' => 'button', 'style' => 'float: right; margin-bottom: 20px;'))?>
    </a>
</div>
<div style="clear: both;"></div>
<pre>
<table class="mainTable">
    <tr>
        <th style="width: 15%;">配置名</th>
        <th style="width: 15%;">配置key</th>
        <th>详细配置</th>
        <th style="width: 5%;">是否有效</th>
    </tr>
    <?php foreach ($aData as $aValue) : $aNoteInfo = unserialize($aValue['note_info']);?>
        <tr>
            <td><?=$aValue['key_name']?></td>
            <td><a href="/admin/kv/add?key=<?=$aValue['key']?>"><?=$aValue['key']?></a></td>
            <td><div class="" style="max-height: 5em; overflow: auto;"><?=print_r($aValue['value'], true)?></div></td>
            <td><?=$aValue['online'] ? '✓' : '<span style="color: red; font-weight: bold; font-size: 20px;">✕</span>'?></td>
        </tr>
    <?php endforeach;?>
</table>
</pre>