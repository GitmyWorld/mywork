
<?php
/**
  * wechat php test
  * 消息管理
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();

if(isset($_GET['echostr'])){
	$wechatObj->valid();
}else{
	$wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            header('content-type:text');// 增加一行
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data 
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);//回复
                //$keyword = $postObj->MediaId; //获取midiaid步1
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            //图文回复模板 在素材管理区mediaID，但需要权限，需要发图片取id，
                $imgTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName> 
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[QZKQFsxryPrdg5F61nyQFOfEqbiX0_vnA9zO9rpmxShTbeQQkKwKkLdgnccN2K8h]]></MediaId>  
                            </Image>
                            </xml>";
                $vioceTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Voice>
                            <MediaId><![CDATA[p6VXiuiMKwvnlBxH63bZGTSWeEAzb5If99EnDT6UuYau69czIAZHioqVdTwt3OCg]]></MediaId>
                            </Voice>
                            </xml>";
            	$videoTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Video>
                            <MediaId><![CDATA[z3ahECWwYrwqEmIi02kLYskkF15fLpIpXwq7-NjmjmIMI-QzZfaq5NZU-sIxONbL]]></MediaId>
                            <Title><![CDATA[abc]]></Title>
                            <Description><![CDATA[ab]]></Description>
                            </Video> 
                            </xml>";
				if(!empty( $keyword ))
                {
                    //$msgType = "text";
                    // 放到keyword外面    //取midiaId  步2             
                    //$contentStr = json_encode($postObj); 
                    //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //echo $resultStr;
                    if( $keyword){
                        //$contentStr = "你在询问天气";//输入的请求返回数据回来 
                        //回复图片
                        if($keyword=='图片'){
                        	 $msgType = "image";
                            //$contentStr = json_encode($postObj);
                			$resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time, $msgType);
                    		echo $resultStr;                    
                        }else if($keyword == '语音'){
                        	 $msgType = "voice";
                            //$contentStr = json_encode($postObj);
                			$resultStr = sprintf($vioceTpl, $fromUsername, $toUsername, $time, $msgType); 
                    		echo $resultStr;
                                               
                        }else if($keyword == '视频'){
                        	$msgType = "video";
                            //$contentStr = json_encode($postObj);
                			$resultStr = sprintf($videoTpl, $fromUsername, $toUsername, $time, $msgType);
                    		echo $resultStr;       
                            
                    	}else{ 
                             $msgType = "text";
                             $apiKey = "f2f81bc4690b136dca164e75bc371824";
                             $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";      
                             header("Content-type: text/html; charset=utf-8");                        
                             $reqInfo = $keyword;                       
                             $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));                        
                             $res = file_get_contents($url);
                             $contentStr = json_decode($res)->text;//转回obj输出                         
                             $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);                            
                             echo $resultStr;
                        }
                       
                    }else{
                    	$contentStr = json_encode($postObj);
                		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                		echo $resultStr;
                    }
                   
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>