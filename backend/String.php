<?php
namespace backend;

class String
{
	/**
	 * 判断一个字符是否为中文字符
	 * @author bignerd
	 * @since  2017-03-21T13:31:12+0800
	 * @param  $character
	 * @return boolean
	 */
	public static function isChina($character)
	{
		if(ord($character) <= 128){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * 避免截取字符串中英文长度的问题
	 * @author bignerd
	 * @since  2017-03-21T13:33:08+0800
	 * @param  $string 字符串
	 * @param  $length 截取的长度 字符的字节数
	 * @return string
	 */
	public function cutString($string, $length)
	{
		$length = strlen($string);
		$chinaCharacter = $noChinaCharacter = 0;

		for($i = 0; $i < $length; $i++){
			$curCharacter = substr($string, $i, 1);
			if(self::isChina($curCharacter)){
				$chinaCharacter++;
			}else{
				$noChinaCharacter++;
			}
		}

		$realLength = $chinaCharacter * 3 + $noChinaCharacter;

		return substr($string, 0, $realLength);
	}
}
?>