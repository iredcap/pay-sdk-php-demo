<?php

require_once "pay.php";


$data = [
    "order_no" => date('Ydmhis') . time(),
    "body" => 'VIP充值 - 100001',
    "sum" => '0.66',
    "channel" => strtolower('qq_native'), //渠道  官方的official
    "extra" => [
        "openid"  => 'oWbNY5LQY2E_U0BH06v_4XGWy_I0'
    ]
];

$pay = new Payment($config);
$result = $pay->pay($data);  // ->pay(); ->callback();

exit(json_encode($result));



