<?php

require_once "pay.php";

if(isPost()) {
    $data = [
        "order_no" => date('Ydmhis') . time(),
        "body" => '测试',
        "sum" => '0.66',
        "channel" => strtolower('pswxpay') //渠道  官方的official
    ];

    $pay = new Payment($config);
    $result = $pay->pay($data);  // ->pay(); ->callback();

    exit(json_encode($result));
}

/**
 * 是否是POST提交
 * @return int
 */
function isPost() {
    return ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? 1 : 0;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <title>聚合支付 · 收银台</title>
    <link href="https://pay.iredcap.cn/favicon.ico" rel="shortcut icon" />
    <link href="../static/cashier/css/reset.css?ver=201801291037" rel="stylesheet">
    <link href="../static/cashier/css/main.css?ver=201801291037" rel="stylesheet">
    <script src="../static/cashier/js/jquery-1.9.1.js" type="text/javascript">
    </script>
</head>

<body>
<div class="container">
    <div class=hd>
        <div class="hd-main">
            <div class="ep-hd-info">
                <div class="ep-logo">
                    <img src="https://pay.iredcap.cn/static/logo-color.png" alt="CmPay">
                </div>
                <div class="ep-order-status">
                    <h1>聚合支付 · 收银台</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="bd">
        <div class="bd-main">
            <div class="ep-wrapper">
                <div class="ep-pay-step ep-step-channel bd-main-container" style="display: block;">
                    <div class="ep-order-detail">
                        <div>
                            <div class="ep-order-tit">
                                <dl>
                                    <dt>商品订单：</dt><dd><?php echo date('Ydmhis') . time() ;?></dd>
                                </dl>
                            </div>
                            <div class="ep-order-tit">
                                <span>支付金额：<em class="rmb"><i>¥</i>10.00</em></span>
                            </div>
                            <div class="ep-order-con">
                                <dl>
                                    <dt>商品名称：</dt>
                                    <dd class="val">账号110000-VIP充值</dd>
                                </dl>
                                <dl>
                                    <dt>支付订单：</dt>
                                    <dd class="val">E-<?php echo time() . rand() ;?></dd>
                                </dl>
                                <dl>
                                    <dt>应付金额：</dt>
                                    <dd><i>￥</i><span class="rmb val">10.00</span></dd>
                                </dl>
                                <dl>
                                    <dt>购买时间：</dt><dd class="val"><?php echo date('Y-m-d H:i:s');?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="ep-pay-method ep-pay-methods">
                        <dl>
                            <dt>支付方式：</dt>
                            <dd class="pay-channel">
                                <div id="pay-channel-list" class="ep-pay-method-list-tit">
                                    <ul>
                                        <li class="selected" data-type="wxpay" title="微信支付">
                                            <span class="ep-icon ep-icon-wxpay"></span>
                                            <span class="ep-pay-method-name">微信支付</span>
                                            <!---->
                                            <i class="ep-icon ep-icon-selected">
                                            </i>
                                        </li>
                                        <li class="" data-type="qqpay" title="QQ钱包支付">
                                            <span class="ep-icon ep-icon-qqpay"></span>
                                            <span class="ep-pay-method-name"> QQ钱包支付</span>
                                            <!---->
                                        </li>
                                        <li class="" data-type="alipay" title="支付宝支付">
                                            <span class="ep-icon ep-icon-alipay"></span>
                                            <span class="ep-pay-method-name"> 支付宝支付</span>
                                            <!---->
                                        </li>
                                        <li class="" data-type="paypal" title="Paypal支付">
                                            <span class="ep-icon ep-icon-alipay"></span>
                                            <span class="ep-pay-method-name"> Paypal支付</span>
                                            <!---->
                                        </li>
                                    </ul>
                                </div>
                                <div class="ep-pay-method-list-con">
                                    <div class="con channel-wechat">
                                        <div class="clearfix">
                                            <div class="fl">
                                                <div class="ep-qrcode-loading">
                                                    <img src="//midas.gtimg.cn/enterprise/images/loading.gif" width="80" height="80">
                                                </div>
                                                <div class="ep-wxpay-qrcode-wrap hide">
                                                    <img src="" height="200" width="200" class="ep-wxpay-qrcode">
                                                </div>
                                                <div class="ep-wxpay-qrcode-notice">
                                                    请打开手机微信，扫一扫完成支付
                                                </div>
                                            </div>
                                            <div class="fl ep-wxpay-qrcode-tip">
                                                <img src="//midas.gtimg.cn/enterprise/images/ep_sys_wx_tip.jpg">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="con channel-qqwallet ">
                                        <div class="clearfix">
                                            <div class="fl">
                                                <div class="ep-qrcode-loading">
                                                    <img src="//midas.gtimg.cn/enterprise/images/loading.gif" width="80" height="80">
                                                </div>
                                                <div class="ep-wxpay-qrcode-wrap hide">
                                                    <img src="" height="200" width="200" class="ep-qqpay-qrcode">
                                                </div>
                                                <div class="ep-qqpay-qrcode-notice">
                                                    请打开手机QQ，扫一扫完成支付
                                                </div>
                                            </div>
                                            <div class="fl ep-wxpay-qrcode-tip">
                                                <img src="//midas.gtimg.cn/enterprise/images/ep_sys_qq_tip.jpg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ep-pay-method-submit">
                                    <a href="javascript:void(0);" title="提交支付" class="ep-btn ep-btn-submit ep-btn-blue" data-active="submit">提交支付</a>
                                </div>
                                <div class="ep-qrcode-error-tip"  style="display: none;">
                                    <span class="ep_icon_warning_tip"></span>
                                    <span class="ep_warning_text">
                                        对不起，系统繁忙，请稍后再试
                                    </span>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="ep-pay-step ep-step-pending">
                </div>
                <div class="ep-pay-step ep-step-success"  style="display: none;">
                    <div class="ep-wp-hd">
                        <h2 class="ep-status ep-status-success mod-it">
                            <span class="ep-icon ep-icon-success mod-it-icon"></span>
                            <span class="mod-it-text">支付成功！</span>
                        </h2>
                    </div>
                    <div class="ep-wp-bd">
                        <div class="ep-dl-list">
                            <dl>
                                <dt>商品订单：</dt>
                                <dd> <?php echo date('Ydmhis') . time() ;?></dd>
                            </dl>
                            <dl>
                                <dt>支付金额：</dt>
                                <dd>¥2.00</dd>
                            </dl>
                        </div>
                        <div class="ep-order-con success-expend">
                            <dl>
                                <dt>商品名称：</dt>
                                <dd>账号110000-VIP充值</dd>
                            </dl>
                            <dl>
                                <dt>支付订单：</dt>
                                <dd>E-<?php echo time() . rand() ;?></dd>
                            </dl>
                            <dl>
                                <dt>应付金额：</dt>
                                <dd>
                                    <span class="rmb"><i>￥</i>10.00</span>
                                </dd>
                            </dl>
                            <dl>
                                <dt>支付方式：</dt>
                                <dd>微信支付</dd>
                            </dl>
                            <dl>
                                <dt>购买时间：</dt>
                                <dd><?php echo date('Y-m-d H:i:s');?></dd>
                            </dl>
                        </div>
                        <div class="ep-question">
                            <p>若有疑问请与客服联系，我们将尽快为您提供服务。</p>
                            <p>客服QQ：702154416</p>
                        </div>
                        <div>
                            <a href="javascript:localhost.reload();" title="返回" class="ep-btn ep-btn-blue" data-active="back">返回</a>
                        </div>
                    </div>
                </div>
                <div class="ep-pay-step ep-step-fail">
                </div>
            </div>
        </div>
    </div>
    <div class=ft>
        <div class=ft-main>
            <div class=copyright>
                <p>
                    Copyright © 2018 Iredcap. All Rights Reserved 小红帽科技 版权所有
                </p>
                <p>
                    本服务由CmPay聚合支付（CmPay）提供&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;服务条款
                </p>
            </div>
        </div>
    </div>
</div>
<script src="../static/cashier/js/separate_1.0.72e563f0.js" type="text/javascript"></script>
<script>
    var UUID = function(e, t) {
        var a, n = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),
            i = n,
            s = [];
        if (t = t || i.length, e)
            for (a = 0; a < e; a++) s[a] = i[0 | Math.random() * t];
        else {
            var r;
            for (s[8] = s[13] = s[18] = s[23] = "-", s[14] = "4", a = 0; a < 36; a++) s[a] || (r = 0 | 16 * Math.random(), s[a] = i[19 == a ? 3 & r | 8 : r])
        }
        return s.join("")
    };

    var order = new Object();
        order.method = 'wxpay';

    var charge;

    var timer, minutes, seconds, ci, qi;

    //选择支付方式
    $(".ep-pay-method-list-tit li").click(function(){
        order.method = $(this).data("type");
        //清除其他
        var channellist = $(".ep-pay-method-list-tit li");
        for(var i=0;i < channellist.length; i++){
            $(channellist[i]).removeClass("selected");
            $(channellist[i]).children('.ep-icon-selected').remove()
        }
        //选中状态
        $(this).addClass("selected");
        $(this).append("<i class=\"ep-icon ep-icon-selected\"></i>");
    });

    //提交支付
    $(".ep-btn-submit").click(function () {
        if (isUndefined(order)){
            showError('请求订单为空！');
            return;
        }
        var i = 0,keys = ['subject','order_no','amount'];
        $('.val').each(function(key,value){
            order[keys[i]] = $(value).html();
            i++;
        });
        //提交
        $.post("index.php?" + UUID(), order,function(resp){
            console.log(resp);
            //有错
            if (resp.error_code !== undefined) {
                showError(resp.error_msg);
                return;
            }else {
                charge = resp.charge;
                //显示支付区域
                $('.channel-wechat').show();
                //隐藏加载码
                $('.ep-qrcode-loading').hide();
                //显示支付码
                $('.ep-wxpay-qrcode-wrap').show();
                //加载支付码
                $('.ep-wxpay-qrcode').attr('src','https://www.kuaizhan.com/common/encode-png?large=true&data=' + charge.credential.order_qr);
                //订单查询
                checkOrderStatus();
                //
                runOrderTimes();
            }
        },"json");
    });
    //展示错误
    function showError(msg) {
        $('.ep-qrcode-error-tip').show().delay(5000).hide(0);
        $('.ep-qrcode-error-tip .ep_warning_text').html(msg);
    }
    //判断数值是否为空
    function isUndefined(value){
        return value==undefined || $.trim(value).length==0;
    }

    var runOrderTimes = function () {
        timer = parseInt(300) - 1;
        ci = setInterval(function () {
            if (--timer < 0) {
                showError('订单超时');
                //隐藏支付区域
                $('.channel-wechat').hide();
                clearInterval(ci);
                clearInterval(qi);
            }
        }, 1000);
    };
    //定时查询订单状态
    var checkOrderStatus = function () {
        clearTimeout(qi);
        $.ajax({
            url: 'query.php?orderid=' + charge.out_trade_no + '&channel=' + charge.channel,
            dataType : 'json',
            success: function (ret) {
                console.log(ret)
                if (ret.code == '200' && ret.msg == 'SUCCESS') {
                    clearTimeout(ci);
                    //隐藏支付区域
                    $('.ep-step-channel').hide();
                    //显示成功区域
                    $('.ep-step-success').show();
                } else {
                    qi = setTimeout(function () {
                        checkOrderStatus();
                    }, 3000);
                }
            },
            error: function () {
                qi = setTimeout(function () {
                    checkOrderStatus();
                }, 3000);
            }
        })

    };

</script>
</body>
</html>