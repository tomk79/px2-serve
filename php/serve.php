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
	public function __construct( $px ){
		$this->px = $px;
	}
}
