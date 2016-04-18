<?php
    header("Content-type:text/html;charset=utf-8");
    //也就这么回事
    //加密方法
     function api_encode($str){
        //异或 
	$key1="";   
	for($i=0;$i<8;$i++){
	    $key1.= rand(0,9);
	}
	$tmp="";
	for($i=0;$i<strlen($str);$i++){
	    $tmp.=substr($str,$i,1) ^ substr($key1,$i%8,1);
	}
	$str =  base64_encode($key1.$tmp);//异或后进行base64加密
	//des加密
	$key2 = md5('www.xingdong365.com');
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);  
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
	$str = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key2, $str, MCRYPT_MODE_ECB, $iv);
	//base64加密
	return $str =base64_encode($str); 

    }  
    //解密方法
    function api_decode($str){
    	//base64解密
    	$str= base64_decode($str);
    	//des解密
    	$key1 = md5('www.xingdong365.com');
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);  
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
        $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$key1,$str,MCRYPT_MODE_ECB,$iv);
        //base64解密后异或
        $len=strlen($str);
       	$str=base64_decode($str);
       	$key2 = substr($str,0,8);
       	$str=substr($str,8,$len-8);
       	$tmp="";
       	for($i=0;$i<strlen($str);$i++){
        	$tmp.=substr($str,$i,1) ^ substr($key2,$i%8,1);
       	}

       return $tmp;    
    }
    
    $str =  "flycoder";
    echo "要加密的字符串:".$str."<br/>";
    $str_encode =  api_encode($str);//加密结果
    echo "加密后的字符串:".$str_encode."<br/>";
    $str_decode = api_decode($str_encode);
    echo "解密后的字符串:".$str_decode;



