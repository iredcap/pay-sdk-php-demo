<?php

require_once "pay.php";

$data = [
    "order_no" => $_GET['orderid'],
    "type" => strtolower($_GET['channel'])
];

$pay = new Payment($config);
$result = $pay->query($data);  // ->pay(); ->callback();

//{"result_code":"OK","result_msg":"SUCCESS","charge":{"trade_no":"A20181205154544C05960","out_trade_no":"E-1543995942287097266","subject":"\u8d26\u53f7110000-VIP\u5145\u503c","body":"\u8d26\u53f7110000-VIP\u5145\u503c","extra":"{\"nocestr\":\"kbxkXb45KpHEzTwYjCo8khKvCy0WRD0C\"}","amount":"0.10","channel":"wx.scan","currency":"CNY","client_ip":"117.181.161.176","status":"WAIT"}}

$retArr['code'] = 200;
$retArr['msg'] = 'FAIL';
if (!empty($result['result_msg']) && $result['result_msg'] == 'SUCCESS'){
        $retArr['msg'] = $result['charge']['status'];
}

exit(json_encode($retArr));