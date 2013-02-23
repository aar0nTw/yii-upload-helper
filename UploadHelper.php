<?php 
/**
* Upload helper
* @author Aaron Huang
* @since 0.3.0
*/
class UploadHelper
{
	private $target;

	function __construct($path = null)
	{
		if (!is_null($path) && file_exists($path)) {
			$this -> target = $path;
		} else {
			$this -> target = dirname(__FILE__).DIRECTORY_SEPARATOR.'../../images/upload/';
			//$this -> target = "./images/upload/";
		}
	}

	public function getTarget()
	{
		return $this -> target;
	}

	public function upload($file)
	{
		//var_dump($file);
		if(!is_uploaded_file($file))
			return false;

		$extName = $this -> getFileExt($file);
		if ($extName !== false) {
			$targetName = sprintf("%x.{$extName}",crc32(sha1(uniqid('',true))));
			$targetPath = $this -> target . $targetName;
			if(move_uploaded_file($file, $targetPath))
				return $targetName;
		}
		return false;
	}

	public function getFileExt($file)
	{
		list($imageWidth, $imageHeight, $imageType) = getimagesize($file);
		$imageType = image_type_to_mime_type($imageType);

		switch ($imageType) {
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				return "png";
				break;
			case "image/png":
			case "image/x-png": 
				return "jpg";
				break;
			default:
				return false;
				break;
		}
	}
}
?>