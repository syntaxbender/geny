<?php
class view{
	public function jsBind($jsFiles){
		$buffer = "";
		foreach($jsFiles as $jsFile => $integrity){
			//$buffer .= "<script src=\"".ASSETS_DIR."/js/".$jsFile.".js\" integrity=\"".$integrity."\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" charset=\"UTF-8\" type=\"text/javascript\"></script>";
			$buffer .= "<script src=\"".ASSETS_DIR."/js/".$jsFile.".js\" charset=\"UTF-8\" type=\"text/javascript\"></script>";

		}
		return $buffer;
	}
	public function cssBind($cssFiles){
		$buffer = "";
		foreach($cssFiles as $cssFile){
			$buffer .= "<link href=\"".ASSETS_DIR."/css/".$cssFile.".css\" charset=\"UTF-8\" rel=\"stylesheet\" type=\"text/css\">";
		}
		return $buffer;
	}
	public static function jsonRender($array,$status=200){
		ob_start();
		http_response_code($status);
		header('Content-Type: application/json');
		echo json_encode($array);
		echo ob_get_clean();
		exit();
	}
	public static function render($file,$data=[]){
		extract($data);
		ob_start();
		require TEMPLATE_DIR.'/'.strtolower($file).'.php';
		echo ob_get_clean();
		exit();
	}
	public static function redirect($url){
		header('Location: '.$url);
		exit();
	}
}
?>