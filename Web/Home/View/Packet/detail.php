<div class="main-content-body soft-detail layout">
    <div class="bread-crumb"></div>

    <div class="saw-box">
        <div class="saw-box-head"></div>
        <div class="saw-box-body">
            <img class="soft-img" src="<?= $aSoft['logo'] ?>" style="width: 64px; height: 64px;"/>
            <div>
                <?= $aSoft['name']; ?>
                &nbsp;
                &nbsp;
                <?php /*
                <a class="btn btn-medium one-packet" href="javascript: void(0);" data-href="<?=\Common\Helper\Constant::CDN_URL . \Admin\Model\SoftModel::generateDownloadName($IT_Soft->package_zujian, $IT_Soft->id, $User->id);?>" data-softid="<?=$IT_Soft->id?>">立即下载</a>
                <?php */?>
            </div>
            <p class="margin-top-15">
                价格：<?= $aSoft['price'] * \Common\Helper\Constant::NIUBI_RANK ?>流量／有效安装
                &nbsp;
                版本编号：<?=$aSoft['version'] ?>
                &nbsp;
                大小：<?= round($aSoft['filesize']/1024/1024, 2) ?>MB
                &nbsp;
                更新日期：<?= date('Y-m-d', strtotime($aSoft['update_time'])) ?>
            </p>
        </div>
        <div class="saw-box-foot"></div>
    </div>


    <?=$aSoft['content'] ?>

</div>