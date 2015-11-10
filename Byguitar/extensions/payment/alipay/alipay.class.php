<?php


class alipay
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
    function alipay()
    {
      $this->payment = array(
  	  'alipay_partner' => '2088901491675963', 
  	  'alipay_key' => 'mgz8qo4qb09orn0as9oywlv7hwyhzndl',
      'private_key_path' => dirname(__FILE__).'/keys/alipay_rsa_private_key.pem'
  	  );
    }

    function __construct()
    {
        $this->alipay();
    }

    /**
     * 生成支付代码
     * @param   array   $order    订单信息
     * @param   array   $class    按钮样式
     */
    function get_code($order,$class = '')
    {
     
        $payment = $this->payment;

        //参与加密的参数
        $parameter = array(
            //基本参数 不需要更改
            'service'           => 'create_direct_pay_by_user',//指定为即时到帐 
            '_input_charset'    => 'utf-8',
            'payment_type'      => 1,
            //账户信息
            'partner'           => $payment['alipay_partner'],
            'seller_id' => $payment['alipay_partner'],
            //'seller_email'      => $payment['alipay_account']
            //url信息
            'notify_url'        => 'http://'.$_SERVER['HTTP_HOST'].'/notify/alipay',
            'return_url'        => 'http://'.$_SERVER['HTTP_HOST'].'/pay/alipay',
            'show_url' => 'http://'.$_SERVER['HTTP_HOST'].'/shop/user/order/orderSn/',
            //订单信息
            'subject'           => $order['ordersn'],
			'body' => '彼岸吉他订单',
            'out_trade_no'      => $order['ordersn'],
            'total_fee' => $order['payamount'],
            'it_b_pay' => $order['limittime'].'m',//交易限制时间
            
        );


        //支付宝快捷登录 和 一淘登录需要传递token参数
        if(isset($_COOKIE['AP_TOKEN']) && $_COOKIE['AP_TOKEN'] != '')
        {
        	$parameter['token'] = $_COOKIE['AP_TOKEN'];
        }

        ksort($parameter);
        $param = '';
        $sign  = '';
        foreach ($parameter AS $key => $val)
        {
            $param .= "$key=" .urlencode($val). "&";
            $sign  .= "$key=$val&";
        }
        
        $param = substr($param, 0, -1);
        $sign  = substr($sign, 0, -1). $payment['alipay_key'];
        
        {
            //使用链接返回支付code
          //$url = 'https://www.alipay.com/cooperate/gateway.do?'.($param). '&sign='.md5($sign).'&sign_type=MD5';
          $url = 'https://mapi.alipay.com/gateway.do?'.($param). '&sign='.md5($sign).'&sign_type=MD5';
        }

        return $url;
    }

    /**
     * 生成WAP支付代码,返回订单交易接口
     * @param   array   $order    订单信息
     */
    function get_code_wap($order)
    {
        import('@.Util.Payment.alipay');

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
        foreach ($_GET AS $key=> $value)
        {
             if ('sign' == $key || 'sign_type' == $key || '' == $value || 'm' == $key  || 'a' == $key  || 'g' == $key   || 'payid' == $key || '_URL_' == $key){
             	continue;
             }else{
             	$sign .= "$key=$value&";//$para[$key] = $value;
             }
        }

        $sign = substr($sign, 0, -1) . $payment['alipay_key'];
        //echo $sign;
        //$sign = substr($sign, 0, -1) . ALIPAY_AUTH;
        if (md5($sign) != $_GET['sign'])
        {
            return false;
        }
        
        if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS')
        {
            return false;
        }
        elseif ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS')
        {
            /* 支付成功 */
            return true;
        }
        else
        {
            return false;
        }
    }
}
