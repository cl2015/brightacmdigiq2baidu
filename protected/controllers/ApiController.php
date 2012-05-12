<?php

class ApiController extends Controller
{
	public function actionQuery($code='',$name='',$phone='',$email='')
	{
		$user = new User();
		var_dump($name);
		if ($code != ''){
			$user->code = $code;
		}
		if ($name != ''){
			$user->name = $name;
		}
		if ($phone != ''){
			$user->phone = $phone;
		}
		if ($email != ''){
			$user->email = $email;
		}
		$results = array('status'=>1,'participants'=>$user->apiQuery());
		echo CJavaScript::jsonEncode($results);
		Yii::app()->end();
	}

	public function actionCheckin($ids,$ipad_id)
	{
		$idArray = explode(',', $ids);
		$participants = array();
		foreach ($idArray as $id ){
			$user = User::model()->findByPk($id);
			if($user===null){

			}else{
				//if check_in?
				if($user->has_checked_in == 1){
					$user->display = '已经注册过。';
				}else{
					$user = $this->printCode($user,$ipad_id);
				}
				$participants[]=$user;
			}
		}
		$results = array('results'=>$participants
		);
		echo CJavaScript::jsonEncode($results);
		Yii::app()->end();
	}
	
	/**
	 * list all questions
	 */
	public function actionQuestions(){
		$questions = Question::model()->findAll();
		echo CJavaScript::jsonEncode($questions);
		Yii::app()->end();
	}
	
	/**
	 * create a question
	 */
	public function actionCreateQuestion()
	{
		$result = array('message'=>'false');
		$model=new Question;
			
		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$message = 'success';
		}
		echo CJavaScript::jsonEncode($result);
		Yii::app()->end();
	}

	/**
	 * print & update user
	 *
	 */

	public function printCode($user,$ipad_id){
		try {
			$client = new SoapClient ( 'http://192.168.1.101:1887/hello?wsdl' );
			$info = new SoapPrint($user->name,$user->room,$user->code);
			$result= $client->Print ($info);
			if($result->PrintResult=='OK'){
				$user->has_checked_in = 1;
				$user->status = 1;
				$user->display = '签到成功。';
				$user->save();
			}else{
				$user->display = '测试一下啦';
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

