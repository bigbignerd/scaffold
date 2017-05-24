<?php
namespace backend;
use backend\String;

class GenerateRandomImage
{
	/** @var integer 图片宽度 */
	public $imgWidth  = 272;
	/** @var integer 图片高度 */
	public $imgHeight = 162;
	/** @var  根据type不同来生成不同的背景颜色 */
	public $type = '';
	/** @var  图片上要显示的文字 */
	public $text = '';
    /** @var integer 图片上文字的字体大小 */
    public $fontSize = 16;

	public function __construct($type, $text)
	{
		$this->type = $type;
		$this->text = $text;
	}
    /**
     * 创建生成随机图片
     * @author bignerd
     * @since  2017-03-21T14:49:41+0800
     */
	public function createImg()
	{
		$image = imagecreate($this->imgWidth, $this->imgHeight);
		$rgb   = $this->getBackground($this->type);
		/** @var 为图片创建一个背景色 */
		$backgroundColor = imagecolorallocate($image, $rgb['r'], $rgb['g'], $rgb['b']);
		/** @var 创建文字白色字体 */
		$textColor = imagecolorallocate($image, 255, 255, 255);
		/** @var 字体文件路径 */
        $font = $_SERVER['DOCUMENT_ROOT'].'/public/font/simhei.ttf';

        $x = 18;
        $y = 50;
        /** 文字写入图片 */
        imagettftext($image, $this->fontSize, 0, $x, $y, $textColor, $font, $this->text);

        $waterImgPath = $this->randWaterImage();
        $waterInfo    = getimagesize($waterImgPath);
        $waterType    = image_type_to_extension($waterInfo[2], false);//获取文件类型

        $createImageFunc = 'imagecreatefrom'.$waterType;
        /** @var $mask  */
        $mask = $createImageFunc($waterImgPath);
        $posX = $this->imgWidth  - $waterInfo[0];
        $posY = $this->imgHeight - $waterInfo[1];

        header("Content-Type:image/png");
        /** 水印图片复制到创建的image */
        imagecopy($image, $mask, $posX, $posY, 0, 0, $waterInfo[0], $waterInfo[1]);
        imagepng($image);
        imagedestroy($image);
	} 
	/**
     * 图片背景颜色的rgb值
     * @author bignerd
     * @since  2017-03-21T14:50:16+0800
     */
	public function getBackground()
    {
        $background = [
            '1'=>['r'=>0,  'g'=>160,'b'=>233],
            '2'=>['r'=>198,'g'=>0,  'b'=>110],
            '3'=>['r'=>237,'g'=>109,'b'=>0],
            '4'=>['r'=>33, 'g'=>148,'b'=>75],
            '5'=>['r'=>63, 'g'=>58, 'b'=>57],           
            '6'=>['r'=>202,'g'=>162,'b'=>101],
        ];
        return $background[$this->type];
    }
    /**
     * 随机水印图片路径
     * @author bignerd
     * @since  2017-03-21T14:51:00+0800
     * @return 路径
     */
    public function randWaterImage()
    {
    	$folder = [
    		'1'=>'product','2'=>'team','3'=>'architecture','4'=>'developer','5'=>'test','6'=>'engineer'
    	];
    	$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/public/images/role/'.$folder[$this->type].'/'.rand(1,38).'.png';
    	return $targetFolder;
    }
}

$image = new GenerateRandomImage(1,"扛得住的MySql数据架构");
$image->createImg();
?>