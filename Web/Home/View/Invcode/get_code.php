<div class="main-content-body get-code">
    <div class="main-content-head">
        <div class="dt-tabs">
            <a class="dt-tab chosen" href="/Home/invcode/get_code">领取</a>
            <a class="dt-tab" href="/Home/invcode/activity">已激活</a>
        </div>
    </div>

    <div class="saw-box has-title get-code-area">
        <div class="saw-box-head"></div>
        <div class="saw-box-title padding-left-20">
            说明
        </div>
        <div class="saw-box-body">
            <p>1. 邀请码仅针对邀请的个人使用。</p>
            <p>2. 每日仅限领取<?=$iMaxCount?>个邀请码。</p>
            <p>3. 邀请码有效期为<?=$iExpireDay?>天（自领取时开始计算），过期失效。</p>
            <div class="text-center margin-top-20">
                <?php if (!$bGetInvcode): ?>
                    <a class="btn btn-big" href="#" id="a_get_invcode">获取邀请码</a>
                <?php else:?>
                    <a class="btn btn-big btn-disabled">已经领取邀请码</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="saw-box-foot"></div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>邀请码</th>
            <th>领取时间</th>
            <th>失效时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($aList as $list): ?>
            <tr>
                <td><?=$list['code']?></td>
                <td><?=$list['fetch_time']?></td>
                <td><?=date('Y-m-d H:i:s' , strtotime("+{$iExpireDay} day",strtotime($list['fetch_time'])))?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class="pagination">
        <?=$sPagination?>
    </div>
</div>
<script>
    !function(){

        $('#a_get_invcode').on('click', function(event){
            $.ajax({
                url: '/Home/invcode/get_code_post',
                type: 'post',
                dataType: 'json'
            }).done(function(data){
                if (data.errCode == 0) {
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
            }).fail(function(){
                alert('系统繁忙，请稍后再试！');
            });
        });

    }();
</script>