===========
WechatClass v1.0

===========
writen by Yuri. You are warmly welcome to improve it's functions
blog : http://blog.csdn.net/yuri_4_vera
if you have any problem just mail to bugformatrix@foxmail.com
这个项目由友力发起并维护。欢迎大家一起来增强它的功能。
博客 : http://blog.csdn.net/yuri_4_vera
如果有任何的问题，请发邮件至bugformatrix@foxmail.com

===========
This is a class written by me for the people who want to use Wechat Public Platform easily.
You can modify it and fit your requirement. 
这是一个我为微信公众平台写的一个类，方便调用接口和初学者学习。
你可以根据你的需要进行自定义。

===========
How to use it?
First you should access your interface with Wechat server.
	You can download the sample code written by wechat on 
	http://mp.weixin.qq.com/mpres/htmledition/res/wx_sample.zip
	or use the one I have already downloaded for you.
	All you need to do is moving the wx_sample.php to your server folder
	and set the url on Wechat website
	https://mp.weixin.qq.com
	then just click the button and Wechat Public Platform will do the rest and give you an answer
Secend try class wechat
	you need to move wechatClass.php to your server folder and make sure the url will refer to it
	then you can test on your wechat or use test tools provided by Wechat Public Platform.
	try "博客" or "blog".
	you will receive my blog info in Chinese
Third just modify your own wechat class !

使用说明
首先你要有一个微信公众平台帐号，并且已验证，开启开发模式
	你需要接入你的接口。你可以直接使用微信公众平台提供的示例代码，下载地址：
	http://mp.weixin.qq.com/mpres/htmledition/res/wx_sample.zip
	或者你可以用GitHub上我已经为你准备好的示例代码。
	你所要做的就是把代码移至你的服务器目录下，并且确保你的url可以访问到
	在微信公众平台开发模式中填入你的url，
	https://mp.weixin.qq.com
	点击测试，微信公众平台会自动测试接口，并告诉你结果。
接下来你就可以尝试wechat类了
	把wechatClass.php放入你的服务器文件夹，确保你的url可以直接访问到它。
	你可以在你的手机上的微信里测试你的公众号或者使用微信公众平台提供的接口测试工具。
	试试看“博客”或者"blog"吧
	你会收到我的博客的实时信息。
最后，你可以自定义你自己的wechat类，增加或修改其中的功能。
请别忘了分享你的代码。

===========
English version:

class wechat
{
    private $postStr;//input data
    private $postObj;//extract post data

    function __construct();//get post data
    public function distribute();//judge the data's type and call next function(e.g text(); etc.).
    public function text();//solve the text message
    public function location();//solve the location message
    public function event();//solve the event message
    private function sendText($contentStr)//format the response data with $contentStr as the content.
}

Chinese version:

class wechat
{
    private $postStr;//传入的原始字符串
    private $postObj;//解析后

    function __construct();//构造函数，从服务器里收到数据并解析
    public function distribute();//判断收到的信息是哪些，分发给处理函数
    public function text();//文本消息
    public function location();//地理位置消息
    public function event();//事件信息
    private function sendText($contentStr)//负责被动文本信息的发送，传入$contentStr即可返回给微信服务器，私有成员。
}

===========
2013-11-18
create the respository and upload the first version (some comment in Chinese)
NEXT STEP:
translate the comment into English

