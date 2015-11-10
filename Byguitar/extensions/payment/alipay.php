<?php


class alipay extends CApplicationComponent
{
    public $payment = '';
    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function __construct()
    {
      $this->payment = array(
  	  'alipay_partner'       => '2088002153908688',
  	  'alipay_key'           => '9r2qf0251siuwtpord5q1znnig556j4z',
      'alipay_account'       => 'cejunyi@163.com',
      'private_key_path'     => dirname(__FILE__).'/keys/alipay_rsa_private_key.pem'
  	  );
    }

    /**
     * 生成支付代码
     * @param   array   $order    订单信息
     * @param   array   $class    按钮样式
     */
    function get_code($order,$class = '') {
     
        $payment = $this->payment;

        //参与加密的参数
        $parameter = array(
            //基本参数 不需要更改
            'service'           => 'create_partner_trade_by_buyer',//指定为即时到帐 
            '_input_charset'    => 'utf-8',
            'payment_type'      => 1,
            //账户信息
            'partner'           => $payment['alipay_partner'],
            //'seller_id'         => $payment['alipay_partner'],
            'seller_email'      => $payment['alipay_account'],
            //url信息
            'notify_url'        => 'http://'.$_SERVER['HTTP_HOST'].'/shop/pay/alipayNotify', //务器异步通知页面路径
            'return_url'        => 'http://'.$_SERVER['HTTP_HOST'].'/shop/pay/alipay', //跳转同步通知页面路径
            'show_url'          => 'http://'.$_SERVER['HTTP_HOST'].'/shop/user/order/orderSn/'.$order['order_sn'], //商品展示地址,需以http://开头的完整路径，如：http://www.商户网站.com/myorder.html

            //订单信息
            'subject'           => $order['order_sn'],
			'body'              => '彼岸吉他订单',
            "price"             => $order['pay_amount'], //付款金额
            "quantity"          => 1,

            "logistics_fee"     => 0.00, //必填，即运费
            "logistics_type"    => 'EXPRESS',//必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
            "logistics_payment" => 'SELLER_PAY',//必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费） 

            'out_trade_no'      => $order['order_sn'],
            'total_fee'         => $order['pay_amount'],
            //'it_b_pay'          => $order['limit_time'].'m',//交易限制时间
            "receive_name"      => $order['receive_name'],
            "receive_address"   => $order['receive_address'],
            "receive_mobile"    => $order['receive_mobile'],
        );

        //支付宝快捷登录 和 一淘登录需要传递token参数
        // if(isset($_COOKIE['AP_TOKEN']) && $_COOKIE['AP_TOKEN'] != ''){
        // 	$parameter['token'] = $_COOKIE['AP_TOKEN'];
        // }

        ksort($parameter);
        $param = '';
        $sign  = '';
        foreach ($parameter AS $key => $val) {
            $param .= "$key=" .urlencode($val). "&";
            $sign  .= "$key=$val&";
        }
        
        $param = substr($param, 0, -1);
        $sign  = substr($sign, 0, -1). $payment['alipay_key'];
        
        //使用链接返回支付code
        $url = 'https://mapi.alipay.com/gateway.do?'.($param). '&sign='.md5($sign).'&sign_type=MD5';
        return $url;
    }

    /**
     * 生成WAP支付代码,返回订单交易接口
     * @param   array   $order    订单信息
     */
    function get_code_wap($order)
    {
        //import('@.Util.Payment.alipay');

        $payment = $this->payment;

        //接口网关
        $alipay_gateway_new = 'http://wappaygw.alipay.com/service/rest.htm?';
        //SSL证书地址
        $alipay_cacert = dirname(__FILE__).'/alipay_cacert.pem';

        //服务器异步通知页面路径
        $notify_url = 'http://'.$_SERVER['HTTP_HOST'].'/notify/alipaywap';
        //页面跳转同步通知页面路径
        $call_back_url = 'http://'.$_SERVER['HTTP_HOST'].'/pay/alipaywap';
        //操作中断返回地址
        $merchant_url = 'http://'.$_SERVER['HTTP_HOST'].'/notify/null';
        //卖家支付宝帐户
        $seller_email = 'cejunyi@163.com';//待修改
        //商户订单号
        $out_trade_no = $order['ordersn'];
        //订单名称
        $subject = $order['ordersn'];
        //付款金额
        $total_fee =  $order['payamount'];
        //过期时间
        $pay_expire = $order['limittime'];

        $v='2.0';
        $sec_id='MD5';
        $req_id=date('Ymdhis');
        $format='xml';
        $charset='utf-8';

        //请求业务参数详细
        $req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url><pay_expire>'.$pay_expire.'</pay_expire></direct_trade_create_req>';
        $para_token = array(
            "service" => "alipay.wap.trade.create.direct",
            "partner" => $payment['alipay_partner'],
            "sec_id" => $sec_id,
            "format"	=> $format,
            "v"	=> $v,
            "req_id"	=> $req_id,
            "req_data"	=> $req_data,
            "_input_charset"	=> $charset
        );

        //调用授权接口获取token
        $post=$this->_buildRequestData($para_token);
        $curl=new my_curl();
        $response=$curl->getHttpResponsePOST($alipay_gateway_new,$alipay_cacert,$post,'urf-8');
        $response=urldecode($response);
        $response_array=$this->_parseResponse($response);
        $request_token=$response_array['request_token'];

        //构造交易接口
        $req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
        $parameter = array(
            "service" => "alipay.wap.auth.authAndExecute",
            "partner" => $payment['alipay_partner'],
            "sec_id" => $sec_id,
            "format"	=> $format,
            "v"	=> $v,
            "req_id"	=> $req_id,
            "req_data"	=> $req_data,
            "_input_charset"	=> $charset
        );

        $post=$this->_buildRequestData($parameter);
        $url=$alipay_gateway_new.$this->_buildLinkString($post);
        return $url;
    }

    /**
     * 构造请求的数据
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    protected function _buildRequestData($para) {
        // 过滤数组中的空值
        $request_data = array();
        foreach ($para as $key => $val) {
            if($key != "sign" && $key != "sign_type" && $val != ""){
                $request_data[$key] = $val;
            }
        }
        ksort($request_data);
        $preStr=$this->_buildLinkString($request_data);
        // 签名
        $request_data['sign']=md5($preStr.$this->payment['alipay_key']);
        return $request_data;
    }

    protected function _buildLinkString($para){
        // 构造待签名字串
        $para_sign=array();
        foreach ($para as $k => $v)
            $para_sign[$k]=$k.'='.$v;
        return implode('&',$para_sign);
    }

    /**
     * 解析远程模拟提交后返回的信息
     * @param $str_text 要解析的字符串
     * @return 解析结果
     */
    protected function _parseResponse($str_text) {
        //以“&”字符切割字符串
        $para_split = explode('&',$str_text);
        //把切割后的字符串数组变成变量与数值组合的数组
        foreach ($para_split as $item) {
            //获得第一个=字符的位置
            $nPos = strpos($item,'=');
            //获得字符串长度
            $nLen = strlen($item);
            //获得变量名
            $key = substr($item,0,$nPos);
            //获得数值
            $value = substr($item,$nPos+1,$nLen-$nPos-1);
            //放入数组中
            $para_text[$key] = $value;
        }

        if( ! empty ($para_text['res_data'])) {
            //token从res_data中解析出来（也就是说res_data中已经包含token的内容）
            $doc = new DOMDocument();
            $doc->loadXML($para_text['res_data']);
            $para_text['request_token'] = $doc->getElementsByTagName( "request_token" )->item(0)->nodeValue;
        }

        return $para_text;
    }


    public function createsn() {
        $rand = rand(0,99999);
        $rand = str_pad($rand,5,"0",STR_PAD_LEFT);
        $sn=time().$rand;
        return $sn;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        $payment = $this->payment;
        $seller_email = rawurldecode($_GET['seller_email']);

        /* 检查数字签名是否正确 */
        ksort($_GET);
        reset($_GET);

        $sign = '';
        foreach ($_GET AS $key=> $value) {
             if ('sign' == $key || 'sign_type' == $key || '' == $value || 'm' == $key  || 'a' == $key  || 'g' == $key   || 'payid' == $key || '_URL_' == $key){
             	continue;
             } else {
             	$sign .= "$key=$value&";
             }
        }

        $sign = substr($sign, 0, -1) . $payment['alipay_key'];
        if (md5($sign) != $_GET['sign']) {
            return false;
        }
        
        if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
            return true; //支付成功
        } elseif ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            return true;  //支付成功
        } else {
            return false;
        }
    }

    /**
     * 异步通知响应操作
     */
    public function notifyRespond()
    {
        $payment = $this->payment;

        /* 检查数字签名是否正确 */
        ksort($_REQUEST);
        reset($_REQUEST);

        $sign = '';
        foreach ($_REQUEST AS $key=> $value) {
            if ('sign' == $key || 'sign_type' == $key || '' == $value || 'm' == $key  || 'a' == $key  || 'g' == $key   || 'payid' == $key || '_URL_' == $key){
                continue;
            } else {
                $sign .= "$key=$value&";
            }
        }
        $logdir = '/tmp/alipay/'.date('Y_m_d').".log";
        file_put_contents($logdir,"\r\n --alipayNotify sign 【". $sign ."】  ---\r\n", FILE_APPEND);
        file_put_contents($logdir,"\r\n --alipayNotify request sign【". $_REQUEST['sign']."】  ---\r\n", FILE_APPEND);
        file_put_contents($logdir,"\r\n --alipayNotify key【".$payment['alipay_key']."】  ---\r\n", FILE_APPEND);

        $sign = substr($sign, 0, -1) .$payment['alipay_key'] ;
        file_put_contents($logdir,"\r\n --alipayNotify md5 sign【". md5($sign) ."】---\r\n", FILE_APPEND);
        if (md5($sign) != $_REQUEST['sign']) {
            return false;
        }

        if ($_REQUEST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
            return true; //支付成功
        } elseif ($_REQUEST['trade_status'] == 'TRADE_FINISHED' || $_REQUEST['trade_status'] == 'TRADE_SUCCESS') {
            return true;  //支付成功
        } else {
            return false;
        }
    }
}
