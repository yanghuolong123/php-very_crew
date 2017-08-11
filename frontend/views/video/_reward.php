<?php 
use yii\helpers\Url;
?>

<style>
    .font-red{
        color: red;
    } 
    img.reward_weixin {
        height: 25px;
        margin: 0 30px 0 5px;
        vertical-align: middle;
    }
    span.wx_pay_amount {
        color: #f5a623;
    }
</style>

<?php $this->beginBlock('video-reward-Js') ?> 

$(function(){
    $('[data-toggle="popover"]').popover();

    $("#reward_amount").blur(function(){
        var amount = $(this).val();
        var reg = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
        if(reg.test(amount)) {
            $(".error_reward").text("");            
        } else {
            $(".error_reward").text("输入金额错误");
        }
        
    });

    $(".btn-reward").click(function(){
        var amount = $("#reward_amount").val();
        var reg = /^([1-9][\d]{0,7}|0)(\.[\d]{1,2})?$/;
        if(reg.test(amount)) {
            $(".error_reward").text("");            
        } else {
            $(".error_reward").text("输入金额错误");
            return false;
        }
        
        if(amount == 0) {
            $(".error_reward").text("金额必须大于0");
            return false;
        }
        
        var msg = $("#reward_message").val();
        var videoId = $("#reward_video_id").val();
        var payType = $("#reward_paytype").val();
        
        var imgUrl, orderId;
        $.ajax({
        	url:"<?= Url::to(['video/reward']) ?>",
        	async:false,
        	type: "POST",
        	data: {videoId:videoId, amount:amount, payType:payType, msg:msg},
        	success: function(e){
                    if(e.success == false) {           
                        alerting({title:"消息提示",msg:e.msg});
                        return;
                    }
                    //alert(e.data);
                    imgUrl = e.data.qrcode;
                    orderId = e.data.OrderId;
        	}
        });
        $(this).attr("data-content","<span class=\"text-center\"><img height=\"150px\" width=\"150px\" src='"+imgUrl+"' /></span><br/><span class=\"text-center\">打赏金额:<span class=\"wx_pay_amount\">￥"+amount+"</span></span>");
        $(this).popover("show");
        $(this).unbind("click");
        $("#reward_amount").attr("disabled","disabled");
        
        timer=setInterval(function(){
            $.post("<?= Url::to(['order/ispay']) ?>", {orderId: orderId}, function(e) {
                if(e.success == false) {
                    return false;
                }
            });
        },3000);
        //clearInteval(timer);
        
    });
});

<?php $this->endBlock() ?> 
<?php $this->registerJs($this->blocks['video-reward-Js'], \yii\web\View::POS_END); ?>

<!-- Modal -->
<div class="modal fade" id="myRewardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">如果你觉得作品不错，请随意打赏。您的支持将鼓励我继续创作！ </h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
              <label for="reward_amount" class="col-sm-2 control-label"><span class="font-red">*</span> 金额(元) </label>
              <div class="col-sm-6">
                  <input type="input" class="form-control" id="reward_amount" name="reward_amount" value="2.00" >
              </div>
              <div class="col-sm-4 font-red error_reward"></div>
            </div>
            <div class="form-group">
              <label for="reward_message" class="col-sm-2 control-label">留言 </label>
              <div class="col-sm-10">
                <textarea placeholder="你想对TA说" rows="3" cols="30" class="form-control" id="reward_message" name="reward_message" maxlength="100"></textarea>
              </div>
            </div>
            <div class="form-group">
                <label for="reward_paytype" class="col-sm-2 control-label"><span class="font-red">*</span> 支付类型</label>
                <div class="col-sm-4"> 
                    <input type="radio" id="reward_paytype" name="reward_paytype" value="1" checked="checked">
                    <img src="/image/webchart.png" class="reward_weixin">                                    
                </div>
            </div> 
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" id="reward_video_id" name="reward_video_id" value="<?= $model->id ?>">
                <button type="button" class="btn btn-warning btn-reward" role="button" data-placement="top" data-html="true" data-toggle="popover" data-trigger="focus" title="微信扫码支付" data-content="<span style='color:red;'>加载中，请等候...<img src='/image/loading.gif'/></span>">打赏</button>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>