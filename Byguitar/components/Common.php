<?php
/**
 * 常用的可重复使用的功能.
 * @auther mwq2020@163.com
 */

class Common 
{
    protected static $Instances;

    /**
     * 获取内部对象的方法.
     *
     * @param string $className 类名.
     *
     * @return mixed
     */
    public static function instance()
    {
        if (!self::$Instances) {
            self::$Instances = new self;
        }
        return self::$Instances;
    }

    /**
     +
     * 获取格式化的链接字符串
     +
     */
    function getFormatUrl($type='category',$filter){
        $urlStr = '';
        if($type == 'category' || empty($type)){
            $newArr = array();
            $params = array('id','brand','price','size','origin','color','sort');
            foreach ($params as $row) {
                $value = isset($filter[$row]) ? intval($filter[$row]) : 0;
                array_push($newArr, $value);
            }
            $urlStr = implode('-', $newArr);
        } elseif($type == 'coupon') {
            $urlStr = '?id=';
        }
        return $urlStr;
    }

    /**
     * 获取分页链接地址串(用于href)
     * @access  public
     * @access  $sum              总数
     * @access  $page_status      当前页码
     * @access  $page_cut         每页数量
     * @access  $point            链接
     * @access  $pagetype         页面类型
     * @return  array             返回链接字符串 和 每页数量 和 每页开始数
     * @time    2010-05-20
     */
    public function get_page_list($sum, $page_status, $page_cut, $point='', $pagetype='')
    {
        if(empty($sum))
        {
            return array('str' => '','size' => $page_cut,'start' => ($page_status -1) * $page_cut);
        }
        $page_cut = intval($page_cut);
        $page_cut = $page_cut < 1 ? 10 :$page_cut;
            
       if($pagetype == 'category') {
            $ptarget = '-';
       }else{
            $str = substr($point, -1, 1);
            if($str == '?') {
                $ptarget = 'p='; 
            }else{
                $ptarget = '?p=';
            }
       }

        $page_sum = ceil($sum / $page_cut);
        /* 首页|上一页| 1| ... 或 首页 | 上一页| 1 | 2 */
        if (1 == $page_status)
        {
            $first = '<span style="display:none;"><font>&laquo;首页</font></span><span><font>&#173;上一页</font></span><span id="page_on">1</span>';
        }
        else
        {
            //if($page_status > 3 && $page_sum > 5)
            if($page_status > 4 && $page_sum > 6)
            {
                $first = '<span style="display:none;"><a href="' . $point . $ptarget.'1" >&laquo;首页</a></span><span><a href="' . $point . $ptarget.'' . ($page_status - 1) . '" >&#173;上一页</a></span><span><a href="' . $point . $ptarget.'1" >1</a></span>';
                if($page_status == 5)
                {
                    $first .= '<span><a href="' . $point . $ptarget.'2" >2</a></span>';
                }else
                {
                    if($page_sum == $page_status || ($page_sum - $page_status) == 1)
                    {
                        if($page_sum == 7)
                        {
                             $first .= '<span><a href="' . $point . $ptarget.'' . ($page_sum - 5) . '" >' . ($page_sum - 5). '</a></span>';
                        }else
                        {
                             $first .= '<span><a href="' . $point . $ptarget.'' . ($page_sum - 5) . '" >...</a></span>';
                        }
                       
                    }else
                    {
                        $first .= '<span><a href="' . $point . $ptarget.'' . ($page_status - 3) . '" >...</a></span>';
                    }
                }
                
            }
            else
            {
                $first = '<span style="display:none;"><a href="' . $point . $ptarget.'1" >&laquo;首页</a></span><span><a href="' . $point . $ptarget.'' . ($page_status - 1) . '" >&#173;上一页</a></span><span><a href="' . $point . $ptarget.'1" >1</a></span>';
            }
        }
        /* ...| N | 下一页|尾页 或  N-1 | N | 下一页|尾页 */
        if ($page_sum == $page_status)
        {
            if($page_sum >= 7)
            {
                for ($i = $page_sum - 4; $i < $page_sum ; $i ++)
                {
                    if($i > 1)
                    {
                        $midd .=  '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                    }
                }
                $midd .= '<span id="page_on">' . $page_sum . '</span><span><font>&#173;下一页</font></span><span style="display:none;"><font>&#173;尾页&raquo;</font></span>';
            }
            else if(7 == $page_sum)
            {
                $end = '<span id="page_on">' . $page_sum . '</span><span><font>&#173;下一页</font></span><span style="display:none;"><font>&#173;尾页&raquo;</font></span>';
            }
            else if(1 == $page_sum)
            {
                $end = '<span><font>&#173;下一页</font></span><span style="display:none;"><font>&#173;尾页&raquo;</font></span>';
            }else
            {
                $end = '<span id="page_on">' . $page_sum . '</span><span><font>&#173;下一页</font></span><span style="display:none;"><font>&#173;尾页&raquo;</font></span>';
            }
        }
        else
        {
            //if (($page_sum - $page_status) > 2 && $page_sum > 5)
            if (($page_sum - $page_status) > 3 && $page_sum > 6)
            {
                if(($page_sum - $page_status) == 4)
                {
                    $end = '<span><a href="' . $point . $ptarget.'' . ($page_status + 3) . '" >' . ($page_status + 3) . '</a></span>';
                }else
                {
                    if($page_status == 1 || $page_status == 2)
                    {
                        if($page_sum == 7)
                        {
                             $end = '<span><a href="' . $point . $ptarget.'6" >6</a></span>';
                        }else
                        {
                             $end = '<span><a href="' . $point . $ptarget.'6" >...</a></span>';
                        }
                    }else
                    {
                        $end = '<span><a href="' . $point . $ptarget.'' . ($page_status + 3) . '" >...</a></span>';
                    }
                    
                }
                $end .= '<span><a href="' . $point . $ptarget.'' . $page_sum . '" >' . $page_sum . '</a></span><span><a href="' . $point . $ptarget.'' . ($page_status + 1) . '">&#173;下一页</a></span><span style="display:none;"><a href="' . $point . $ptarget.'' . $page_sum . '" >&#173;尾页&raquo;</a></span>';
            }
            else
            {
                $end = '<span><a href="' . $point . $ptarget.'' . $page_sum . '" >' . $page_sum . '</a></span><span><a href="' . $point . $ptarget.'' . ($page_status + 1) . '">&#173;下一页</a></span><span style="display:none;"><a href="' . $point . $ptarget.'' . $page_sum . '" >&#173;尾页&raquo;</a></span>';
            }
        }
        /* 中间部分 */
        if ($page_sum < 6)
        {
            for($i = 2; $i < $page_sum; $i ++)
            {
                $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
            }
        }
        else if($page_status < 7 && $page_sum < 7)
        {
            for ($i = 2; $i < 6 ; $i ++)
            {
                $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
            }
        }
        else if ($page_status < 4 && $page_sum > 7)
        {
            switch ($page_status)
            {
                case 1:
                case 2:
                case 3:
                    $tmp1 = 2;
                    $tmp2 = 5;
                    break;
            }
            for ($i = $tmp1; $i <= $tmp2 ; $i ++)
            {
                if($i > 1)
                {
                    $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                }
            }
        }
        else if (7 == $page_sum)
        {
            if($page_status < 4)
            {
                switch ($page_status)
                {
                    case 1:
                    case 2:
                    case 3:
                        $tmp1 = 2;
                        $tmp2 = 6;
                        break;
                }
                for ($i = $tmp1; $i < $tmp2 ; $i ++)
                {
                    if($i > 1)
                    {
                        $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                    }
                }
            }
            else if($page_status == 4)
            {
                switch ($page_status)
                {
                    case 4:
                    case 5:
                        $tmp1 = 2;
                        $tmp2 = 7;
                        break;
                }
                for ($i = $tmp1; $i < $tmp2 ; $i ++)
                {
                    if($i > 1)
                    {
                        $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                    }
                }
            }
            else if($page_status > 4)
            {
                switch ($page_status)
                {
                    case 5:
                    case 6:
                        $tmp1 = 3;
                        $tmp2 = 7;
                        break;
                }
                for ($i = $tmp1; $i < $tmp2 ; $i ++)
                {
                    if($i > 1)
                    {
                        $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                    }
                }
            }
        }
        else if ($page_status > 3 && $page_sum > 7 && ($page_status < ($page_sum - 2))){
            for ($i = $page_status - 2 ; $i <= $page_status + 2 ; $i ++) {
                if($i > 1){
                    $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                }
            }
        }
        else if ($page_status > ($page_sum - 4) && $page_sum > 7)
        {
            switch ($page_status)
            {
                case $page_sum - 1:
                case $page_sum - 2:
                case $page_sum - 3:
                case $page_sum - 4:
                    $tmp1 = $page_sum - 4;
                    $tmp2 = $page_sum;
                    break;
            }
            for ($i = $tmp1; $i < $tmp2 ; $i ++)
            {
                if($i > 1)
                {
                    $midd .= ($page_status == $i) ? '<span id="page_on">' . $i . '</span>' : '<span><a href="' . $point . $ptarget.'' . $i . '" >' . $i . '</a></span>';
                }
            }
        }

        $link = $first . $midd . $end.'<span style="display:none;"><font>'.$page_status.'/共'.$page_sum.'页</font></span>';
        
        return array('str' => $link,'size' => $page_cut,'start' => ($page_status -1) * $page_cut);
    }


    /**
     +
     *获取短分页连接（上一页、下一页）
     +
     * @time 2014-05-16
     */
    public function get_page_short($sum, $page_status, $page_cut, $point='', $pagetype=''){
        if(empty($sum)) {
            return array('str' => '','size' => $page_cut,'start' => ($page_status -1) * $page_cut);
        }

        $page_cut = intval($page_cut);
        $page_cut = $page_cut < 1 ? 10 : $page_cut;

            
       if($pagetype == 'category') {
            $ptarget = '-';
       }else{
            $str = substr($point, -1, 1);
            if($str == '?')
            {
                $ptarget = 'p='; 
            }else{
                $ptarget = '&p='; 
            }
       }

        $page_sum = ceil($sum / $page_cut);
        if (1 == $page_status) {
            $first = '<span><font>&#173;上一页</font></span>';
        } else {
            $first = '<span><a href="' . $point . $ptarget.'' . ($page_status - 1) . '" >&#173;上一页</a></span>';
        }
     
        if ($page_sum == $page_status) {
            $end = '<span><font>&#173;下一页</font></span>';
        } else {
            $end = '<span><a href="' . $point . $ptarget.'' . ($page_status + 1) . '">&#173;下一页</a></span>';
        }
        $link = $first . $end;
        
        return array('str' => $link,'size' => $page_cut,'start' => ($page_status -1) * $page_cut);
    }


}