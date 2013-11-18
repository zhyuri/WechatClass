<?php
//wechat class v1.0 BY Yuri
//author's mail: bugformatrix@foxmail.com

//Copyright 2013
//Released under the MIT license
//Date: 2013-11-18

//类的结构
// class wechat
// {
//     private $postStr;//传入的原始字符串
//     private $postObj;//解析后
//
//     function __construct();//构造函数，从服务器里收到数据并解析
//     public function distribute();//判断收到的信息是哪些，分发给处理函数
//     public function text();//文本消息
//     public function location();//地理位置消息
//     public function event();//事件信息
//     private function sendText($contentStr)//负责被动文本信息的发送，传入$contentStr即可返回给微信服务器，私有成员。
// }

require_once "fetchCsdn.php";//fetch my blog's info

$wechatTest = new wechat();
$wechatTest->distribute();//入口函数distribute

class wechat
{
    private $postStr;//传入的原始字符串
    private $postObj;//解析后

    function __construct()//构造函数，从服务器里收到数据并解析
    {
        $this->postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//这里要根据环境自行配置
        $this->postObj = simplexml_load_string($this->postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 
    }

    public function distribute()//判断收到的信息是哪些，分发给处理函数
    {
        if (!empty($this->postStr))
        {
            $msgType = $this->postObj->MsgType;

            switch ($msgType) //分发
            {
                case "text":
                    $this->text();
                    break;
                case "location": 
                    $this->location();
                    break;

                case "event":
                    $this->event();
                    break;
                default:
                    echo "未知的消息类别";
                    break;
            }
        }
        else//无法得到返回值
        {
            echo "无法得到返回值";
        }

    }

    public function text()//文本消息
    {
        $content = trim($this->postObj->Content);//去除用户发来信息的前后空格

        switch ($content)
        {
            case "博客":
            //示例，抓取我的技术博客的信息，运用自己写的一个类，
            //这个类在fetchCsdn.php里
                $info = new fetch();
                $result = $info->get();
                //$result数组为抓取并整理后的所需信息
                $contentStr = "我的技术博客\n《Coder成长之路》\n目前信息:\n";
                $contentStr .=$result[0]."\n";//访问
                $contentStr .=$result[1]."\n";//积分
                $contentStr .=$result[2]."\n";//排名
                $contentStr .=$result[3]."\n";//原创
                $contentStr .=$result[4]."\n";//转载
                $contentStr .=$result[5]."\n";//译文
                $contentStr .=$result[6]."\n";//评论
                $contentStr .= "欢迎访问我的技术博客\n http://t.cn/8kvGx7T \n";
                break;
            
            default:
            //当不满足预设条件的时候返回默认的自动回复
                $contentStr = "欢迎使用我的公众号，目前只有 1 个功能\n其余功能正在开发当中，请谅解。\n1. 回复“博客”可以获得我的博客的实时信息。";
                break;
        }
        $this->sendText($contentStr);//发送信息
    }

    public function location()//地理位置消息
    {

    }

    public function event()//事件信息
    //包含“关注”“取消关注”“报告地理位置信息”等..
    {
        if ($this->postObj->Event == "LOCATION")//推送的地理位置信息
        {

            return ;
        }

        if ($this->postObj->Event == "subscribe")//关注公众号之后会执行以下代码
        {
            //示例，欢迎信息
            $contentStr = "您好！欢迎关注我的微信公众平台\n";
            $contentStr.= "我使用了由 孑良 开发的微信公众号php类\n";
            $contentStr.= "很抱歉目前尚处于开发过程中，也许有一段时间功能会出现异常，那一定是我在为它的新功能进行调试，请不必担心，它会回来的。\n";
            $contentStr.= "最后，感谢您的关注！\n";
            $this->sendText($contentStr);
            return ;
        }
        else if ($this->postObj->Event == "unsubscribe")//取消关注
        //经测试，此处无法反馈任何信息，用户也收不到
        {
            
            return ;
        }
        else//返回错误信息
        {
            echo "未知的事件类型";
            return ;
        }
    }

    private function sendText($contentStr)//负责被动文本信息的发送，传入$contentStr即可返回给微信服务器，私有成员。
    {
        //不检查用户是否输入为空，如需检查请在text()中自行实现
        $fromUsername = $this->postObj->FromUserName;
        $toUsername = $this->postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                    </xml>";
        $msgType = "text";//返回的数据类型
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//格式化写入XML
        echo $resultStr;//发送
    }
}
?>