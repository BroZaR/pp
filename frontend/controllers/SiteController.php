<?php

class SiteController extends AbstractController {

	protected $title;
	protected $get;
	protected $layout = MAIN_LAYOUT;

	public function __construct( $get ) {
		parent::__construct( new View( DIR_USER ) , new User() );
		$this->get = $get;
	}

	public function action404() {
		parent::action404();
		$title[ 'title' ] = 'Сторінку не знайдено - 404';
		$this->layout     = 'auth';

		$content = $this->view->render( '404' , $title , 'site' , true );
		$this->render( $content );
	}

	public function actionIndex() {
		$param[ 'title' ] = 'Периферійні пристрої';
		$param[ 'error' ] = [ 'class' => ' has-default' , 'message' => '' ];
		if ( isset( $_POST[ 'login' ] ) ) {
			if ( $this->user->Login( $_POST[ 'email' ] , $_POST[ 'password' ] ) ) {
				header( "Location: /results" );
				exit;
			} else {
				$param[ 'error' ][ 'class' ]   = ' has-error';
				$param[ 'error' ][ 'message' ] = new ErrorMessage( 'login' );
			}
		}
		$this->view->render( 'index' , $param );
	}

	public function actionSignup() {
		$this->title  = 'Реєстрація користувача';
		$this->layout = 'auth';
		$param        = SignupForm::CreateClassArray();
		if ( isset( $_POST[ 'submit' ] ) ) {
			$_SESSION[ 'signup' ] = $_POST;
			$form                 = new SignupForm( $_POST );
			$param                = $form->AuditField();
			if ( empty( $param ) ) {
				$data = $form->FormatField();
				$this->user->Signup( $data );
				unset( $_SESSION[ 'signup' ] );
				header( "Location: /results" );
				exit;
			}
		}

		$content = $this->view->render( 'signup' , $param , 'site' , true );
		$this->render( $content );
	}

	public function actionResults() {
		$this->title        = 'Результати тестувань';
		$param[ 'id_user' ] = $this->user->id;
		$content            = $this->view->render( 'results' , $param , 'site' , true );
		$this->render( $content );
	}

	public function actionTopic() {
		$this->title          = $this->AuthTopic( $this->get[ 'topic' ] );
		$param[ 'topic' ]     = $this->title;
		$param[ 'key_topic' ] = $this->get[ 'topic' ];

		$content = $this->view->render( 'topic' , $param , 'site' , true );
		$this->render( $content );
	}

	private function AuthTopic( $key_topic ) {
		$topic      = CycleRender::OutData( 'topic' );
		$name_topic = '';
		for ( $i = 0; $i < count( $topic ); $i ++ ) {
			if ( $topic[ $i ][ 'id_topic' ] == $key_topic ) {
				$name_topic = $topic[ $i ][ 'topic' ];
				break;
			}
		}

		return $name_topic;
	}

	public function actionTest() {
		$topic                = $this->AuthTopic( $this->get[ 'topic' ] );
		$this->title          = 'Тестування - ' . $topic;
		$testdb               = new Test();

		if(isset($_POST['submit'])) {
			$_SESSION['point'] = $testdb->CheckingTest($_POST, $this->get['topic']);
			header( "Location: /point?topic=" . $this->get['topic'] );
			exit;
		}
		$param[ 'topic' ]     = $topic;
		$param[ 'key_topic' ] = $this->get[ 'topic' ];
		$param[ 'tests' ]     = $testdb->SelectRandomTest( $this->get['topic'] );

		$content = $this->view->render( 'test' , $param , 'site' , true );
		$this->render( $content );
	}

	public function actionPoint() {
		$this->title = 'Результат';
		$param       = [
			'message_title' => 'Ви здали тест на <b>'. $_SESSION['point'] .'</b> бали' ,
			'message'       => 'Тепер ви можете переглянути свої відповіді <a href="/answer?topic=' . $this->get['topic'] . '">тут</a>'
		];

		$content = $this->view->render( 'block_message' , $param , 'site' , true );
		$this->render( $content );
	}

	public function actionAnswer() {
		$this->title = 'Аналіз помилок';
		if(!isset($this->get['topic']))
			$this->get['topic'] = 1;
		$table = new FieldDB('answer');
		$param['answer'] = $table->SelectFieldWhereData('*',[
			"`id_user` = '" . $_SESSION['user']['id'] . "'",
			"`id_topic` = '" . $this->get['topic'] . "'"
		], '', [
			'table' => 'test',
			'key' => "`answer`.`id_test` = `test`.`id_test`"
		]);
		$table = new FieldDB('results');
		$result = $table->SelectFieldWhere('result', [
			"`id_user` = '" . $_SESSION['user']['id'] . "'",
			"`id_topic` = '" . $this->get['topic'] . "'"
		]);
		$param['point'] = $result[0]['result'];

		$content = $this->view->render( 'answer' , $param , 'site' , true );
		$this->render( $content );
	}

	public function actionExit() {
		session_destroy();
		header( "Location: /" );
		exit;
	}


	protected function render( $content ) {
		$params              = [];
		$params[ 'title' ]   = $this->title;
		$params[ 'content' ] = $content;
		if ( $this->user->username != null ) {
			$params[ 'username' ] = $this->user;
		} else {
			$params[ 'username' ] = '';
		}
		$this->view->render( $this->layout , $params , 'layouts' );
	}

}

?>