<?php
namespace tomk79\pickles2\px2serve;

/**
 * px2-serve
 */
class serve{

	/** Picklesオブジェクト */
	private $px;

	/** PXコマンド名 */
	private $command = array();

	/** px2dtconfig */
	private $px2dtconfig;

	/**
	 * entry
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $options プラグイン設定
	 */
	static public function register( $px = null, $options = null ){
		if( count(func_get_args()) <= 1 ){
			return __CLASS__.'::'.__FUNCTION__.'('.( is_array($px) ? json_encode($px) : '' ).')';
		}

		$px->pxcmd()->register('serve', function($px){
			(new self( $px ))->kick();
			exit;
		}, true);

		return;
	}


	/**
	 * Constructor
	 *
	 * @param object $px $pxオブジェクト
	 */
	private function __construct( $px ){
		$this->px = $px;
	}

	/**
	 * サーバーを起動する
	 */
	private function kick(){
		$realpath_entryScript = $_SERVER['SCRIPT_FILENAME'];
		$path_entryScript = $this->px->fs()->get_relatedpath($realpath_entryScript);
		$entryScriptBasename = basename($realpath_entryScript);
		$path_controot = $this->px->get_path_controot();
		$realpath_homedir = $this->px->get_realpath_homedir();
		$realpath_router = $realpath_homedir.'_sys/serve/route.php';
		$path_router = $this->px->fs()->get_relatedpath($realpath_router);

		$src = '';
		$src .= '<'.'?php'."\n";
		$src .= 'chdir($_SERVER[\'DOCUMENT_ROOT\']);'."\n";
		$src .= '$path = $_SERVER[\'REQUEST_URI\'];'."\n";
		$src .= '$path_entryScript = \'./\'.'.json_encode($entryScriptBasename).';'."\n";
		$src .= '$script_name = \'/\'.'.json_encode($entryScriptBasename).';'."\n";
		$src .= '$querystring = \'\';'."\n";
		$src .= 'if( strpos($path, \'?\') !== false ){'."\n";
		$src .= '    list($path, $querystring) = preg_split(\'/\?/\', $_SERVER[\'REQUEST_URI\'], 2);'."\n";
		$src .= '}'."\n";
		$src .= 'if( strrpos($path, \'/\') === strlen($path)-1 || preg_match(\'/\.(?:html?|css|js)$/\', $path) ){'."\n";
		$src .= '    $_SERVER[\'SCRIPT_FILENAME\'] = realpath($path_entryScript);'."\n";
		$src .= '    $_SERVER[\'SCRIPT_NAME\'] = $script_name;'."\n";
		$src .= '    $_SERVER[\'PATH_INFO\'] = $path;'."\n";
		$src .= '    $_SERVER[\'PHP_SELF\'] = $path_entryScript.$path;'."\n";
		$src .= '    include($path_entryScript);'."\n";
		$src .= '    return;'."\n";
		$src .= '}'."\n";
		$src .= 'return false;'."\n";

		$this->px->fs()->mkdir(dirname($realpath_router));
		$this->px->fs()->save_file($realpath_router, $src);

		// --------------------------------------
		// サーバーを起動する
		$cmd_serve = 'php -S localhost:8080 -t ./ '.$path_router;
		passthru($cmd_serve);
		exit;
	}
}
