###  微信公众号配合新浪sea开发


#### 10.17
---

==注册订阅号：
https://mp.weixin.qq.com/cgi-bin/home?t=home/index&lang=zh_CN&token=1404205170==

（订阅号->个人->控制台）
使用功能：

1、基本功能：自定义菜单，自动回复等（例如通过关键字‘回复数字1’‘回复数字2’)；

2、自定义跳转链接可以使用sea搭建的服务器，需要在配置服务器，通过服务器url转发；


==注册新浪sea服务器：
http://sae.sina.com.cn/==


```
创建版本
- 进入控制台->点击名称（进入管理）->应用->代码管理
- 上传文件：
     MP_verify_cSiRNdeM0pOLGa8V.txt和官方wx_sample.php
```


==阅读文档：
https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115&token=&lang=zh_CN ==

微信SDK接入指南：
 
```
在微信公众平台操作：

1. 接入指南下载：官网php ：wx_sample.php 上传到sea，打开文件;

2. 配置安全域名 ：设置---公众号设置--功能设置-设置安全域名;
guani.applinzi.com 

3.基本设置：						        
-     设置url（sea打开wx_sample.php的url）：http://1.guani.applinzi.com/wx_sample.php,请求时默认交给php处理
-     token：看文档wx_sample.php： weixin
-     密匙随机生成

4.启用后自动回复和自定义菜单就无法使用;
```

#### 10.18
---
##### example1：图灵机器人 
    weixin/wx_sample.php


---
##### example2: 消息管理 
    wx_sampletw.php
    功能：发送关键字，回复语音，图片，视频等
    由于权限的问题，不能在素材管理区可以找到mediaID,需要通过以下取到对应[mediaID]
    

```

//需要先发送相应的图片、语音到微信，取得mediaID，放到对应tpl，再注释；
$keyword = $postObj->MediaId; //获取midiaid步1

// 放到keyword外面    //  步2
//$msgType = "text";
//$contentStr = json_encode($postObj); 
//$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
//echo $resultStr;

```
---
##### example3:微信网页开发

参考微信JS-SDK文档说明

    php/sample.php;
    功能：用于调用硬件API接口;
    
    issue:jssdk.php 108-109行报错;读不了tooken 和ticket;无法读写读写fopen、fclose
    
    解决：
        1、存储与CND服务-》storage-》创建-》上传access_token.php,jsapi_ticket.php
        2、打开文件复制url到对应位置：
        80行：http://guani-weixin.stor.sinaapp.com/access_token.php
        59行: http://guani-weixin.stor.sinaapp.com/jsapi_ticket.php
    



