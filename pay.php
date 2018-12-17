<?php

/**
 *  +----------------------------------------------------------------------
 *  | 草帽支付系统 [ WE CAN DO IT JUST THINK ]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2018 http://www.iredcap.cn All rights reserved.
 *  +----------------------------------------------------------------------
 *  | Licensed ( https://www.apache.org/licenses/LICENSE-2.0 )
 *  +----------------------------------------------------------------------
 *  | Author: Brian Waring <BrianWaring98@gmail.com>
 *  +----------------------------------------------------------------------
 */

include_once 'vendor/autoload.php';
require_once "config.php" ;

define('CRET_PATH',__DIR__."/cret/");

use IredCap\Pay\Http\HttpRequest;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();




class Payment
{
    /**
     * Pay constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        //1.设置配置参数
        HttpRequest::setBaseUrl('http://api.caomao.com/');         // 设置 API请求根 https://api.pay.iredcap.cn/  http://api.caomao.com/
        HttpRequest::setMchId($config['mch_id']);         // 设置 MCH ID
        HttpRequest::setSecretKey($config['mch_key']);  // 设置 MCH KEY
        HttpRequest::setNotifyUrl($config['notify_url']); // 设置 NOTIFY URL
        HttpRequest::setReturnUrl($config['return_url']); // 设置 RETURN URL
        HttpRequest::setPrivateKey($config['private_key']); // 设置商户数据私钥
        HttpRequest::setPayPublicKey($config['cm_public_key']); // 设置支付平台公钥
    }

    /**
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $param
     *
     * @return mixed|string
     * @throws \IredCap\Pay\Exception\InvalidParameterException
     * @throws \IredCap\Pay\Exception\InvalidRequestException
     */
    public function pay($param){

        //2.支付主体 构建请求参数
        $payload = [
            "out_trade_no" =>  $param['order_no'],
            "subject" => $param['body'],
            "body" => $param['body'],
            "amount" => $param['sum'],
            "currency" =>'USD',
            "channel" => strtolower($param['channel']), //支付方式小写
            "extparam" => [
                "nocestr" => $this->getRandChar()
            ], //支付附加参数

        ];
        //提交支付
        $order = \IredCap\Pay\Charge::create($payload);
        return $order;
    }

    /**
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param $param
     *
     * @return mixed|string
     * @throws \IredCap\Pay\Exception\InvalidParameterException
     * @throws \IredCap\Pay\Exception\InvalidRequestException
     */
    public function query($param){
        //2.查询主体 构建请求参数
        $payload = [
            "out_trade_no" =>  $param['order_no'], //商户订单号
            "channel" => strtolower($param['type']), //支付方式 小写
        ];
        //提交支付
        $order = \IredCap\Pay\Charge::query($payload);
        return $order;
    }

    /**
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     *
     * @return bool
     * @throws \IredCap\Pay\Exception\InvalidResponseException
     */
    public function callback(){
        //提交支付
        return \IredCap\Pay\Charge::verify();
    }


    /**
     *
     * @author 勇敢的小笨羊 <brianwaring98@gmail.com>
     *
     * @param int $length 长度
     *
     * @return null|string
     */
    private function getRandChar($length = 32){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }
}