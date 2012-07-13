<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * print & update user
	 * default printer:192.168.1.101
	 *
	 */

	public function printCode($user,$ipad_id='101'){
		try {
			$clientHost = 'http://192.168.1.102:1887/HostPrint?wsdl';
			$client = new SoapClient ( $clientHost );
			$info = new SoapPrint($user->name,$user->room,$user->code,$ipad_id);
			$result= $client->Print ($info);
			if($result->PrintResult=='OK'){
				$user->has_checked_in = 1;
				$user->status = 1;
				$user->display = '签到成功。';
				$user->save();
			}else{
				$user->display = '打印失败。';
				$user->save();
			}
		} catch (Exception $e) {
			print $e;
			$user->display = $e;
		}
		return $user;
	}
}
class SoapPrint{
	protected $name, $room, $code;
	public function __construct($name, $room, $code) {
		$this->name = $name;
		$this->room = $room;
		$this->code = $code;
	}
}
