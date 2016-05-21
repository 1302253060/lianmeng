<div class="main-content-body soft-list layout" style="">
    <div class="help-left">
        <div class="help-right-search">
            <form action="" method="get" id="helpSearchForm">
                <div class="help-right-search-input">
                    <input class="input-text help-right-input-search" placeholder="请输入搜索内容" name="search" value="<?=I("get.search", '')?>">
                </div>
                <a class="btn btn-search" style="margin-left: 10px;" >搜索</a>
            </form>
        </div>


        <div class="help-content-list">
            <h2><?=isset($aType[$type]) ? $aType[$type] : '搜索结果'?></h2>
            <ul>
                <?php if (!empty($aList)) foreach ($aList as $Item) {?>
                    <li><a href="/Home/help/detail?id=<?=$Item['id']?>"><?=$Item['title']?></a></li>
                <?php } ?>
                <div class="pagination">
                    <?=$sPagination?>
                </div>
            </ul>

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
<script type="text/javascript">
    $('body').on('click', '.btn-search', function(){
        $('body form').submit();
    });
</script>