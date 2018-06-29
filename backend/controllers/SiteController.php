<?php

class SiteController extends AbstractController {

	protected $title;
	protected $get;
	protected $layout = MAIN_LAYOUT;
	protected static $pag_count = 10;

	public function __construct( $get ) {
		parent::__construct( new View( DIR_ADMIN ) , new User() );
		$this->get = $get;
	}

	public function action404() {
		parent::action404();
		$title[ 'title' ] = 'Сторінку не знайдено - 404';
		$this->layout     = 'auth';

		$content = $this->view->render( '404' , $title , 'site' , true );
		$this->render( $content );
	}

	public function actionResults() {
		$this->title = 'Результати тестувань';
		if ( isset( $_POST[ 'years' ] ) && $_POST[ 'years' ] != 0 ) {
			$_SESSION[ 'years' ] = $_POST[ 'years' ];
		}
		if ( isset( $_POST[ 'groups' ] ) && $_POST[ 'groups' ] != 0 ) {
			$_SESSION[ 'groups' ] = $_POST[ 'groups' ];
		}
		$content = $this->view->render( 'results' , [] , 'site' , true );
		$this->render( $content );
	}

	public function actionTopic() {
		$this->title = 'Теми';
		if ( isset( $this->get[ 'action' ] ) && $this->get[ 'action' ] == 'add' ) {
			$param[ 'action' ] = $this->TopicAdd();
		} elseif ( isset( $this->get[ 'action' ] ) && isset( $this->get[ 'id' ] ) && $this->get[ 'action' ] == 'edit' ) {
			$param[ 'action' ] = $this->TopicEdit();
		} elseif ( isset( $this->get[ 'action' ] ) && isset( $this->get[ 'id' ] ) && $this->get[ 'action' ] == 'delete' ) {
			$param[ 'action' ] = $this->TopicDelete();
		} else {
			$param[ 'action' ] = '';
		}
		$content = $this->view->render( 'topic' , $param , 'site' , true );
		$this->render( $content );
	}

	private function TopicAdd() {
		$this->title = 'Додати тему';
		$param       = [
			'message' => '' ,
			'class'   => ''
		];
		if ( isset( $_POST[ 'add' ] ) ) {
			$topic = new FormTopic( $_POST[ 'topic' ] );
			if ( $topic->Add() ) {
				$param[ 'message' ] = new ErrorMessage( 'topic_add_success' );
				$param[ 'class' ]   = 'alert alert-success';
			} else {
				$param[ 'message' ] = new ErrorMessage( 'topic_add_error' );
				$param[ 'class' ]   = 'alert alert-danger';
			}
		}

		return $this->view->render( 'topic_add' , $param , 'block' , true );
	}

	private function TopicEdit() {
		$this->title = 'Редагувати тему';
		$topic       = new FormTopic( '' , $this->get[ 'id' ] );
		$param       = [
			'message' => '' ,
			'class'   => ''
		];
		if ( $topic != '' ) {
			$param[ 'title' ] = 'Редагувати тему "' . $topic . '"';
			if ( isset( $_POST[ 'edit' ] ) ) {
				if ( $topic->Edit( $_POST[ 'topic' ] ) ) {
					$param[ 'class' ]   = 'alert alert-success';
					$param[ 'message' ] = new ErrorMessage( 'topic_edit_success' );
				} else {
					$param[ 'class' ]   = 'alert alert-danger';
					$param[ 'message' ] = new ErrorMessage( 'topic_edit_name_error' );
				}
			}
		} else {
			$param[ 'title' ]   = 'Редагувати тему "' . $topic . '"';
			$param[ 'class' ]   = 'alert alert-danger';
			$param[ 'message' ] = new ErrorMessage( 'topic_edit_error' );
		}

		return $this->view->render( 'topic_edit' , $param , 'block' , true );
	}

	private function TopicDelete() {
		$this->title      = 'Видалення теми';
		$topic            = new FormTopic( '' , $this->get[ 'id' ] );
		$param[ 'title' ] = 'Видалення теми "' . $topic . '"';
		if ( $topic->Delete() ) {
			$param[ 'message' ] = 'Тему успішно видалено';
			$param[ 'class' ]   = ' alert-success';
			$param[ 'icon' ]    = 'fa fa-check';
		} else {
			$param[ 'message' ] = 'Даної теми не існує';
			$param[ 'class' ]   = ' alert-danger';
			$param[ 'icon' ]    = 'fa fa-close';
		}

		return $this->view->render( 'topic_delete' , $param , 'block' , true );
	}

	public function actionTest() {
		$this->title = 'Тести';
		$table       = new FieldDB( 'test' );

		if ( isset( $this->get[ 'action' ] ) && $this->get[ 'action' ] == 'delete' && isset( $this->get[ 'id' ] ) ) {
			$table->DeleteData( 'id_test' , $this->get[ 'id' ] );
		}

		$page_count = SiteController::$pag_count;
		$array      = $this->SortTest();

		$id = $table->SelectFieldWhereData( 'id_test' , $array[ 'where' ] , $_SESSION[ 'sortBy' ] , [
			'table' => 'topic' ,
			'key'   => "`test`.`id_topic` = `topic`.`id_topic`"
		] );

		if ( count( $id ) > $page_count ) {
			$param[ 'count_pages' ] = count( $id ) / $page_count;
			if ( count( $id ) % $page_count != 0 ) {
				$param[ 'count_pages' ] ++;
			}
		} else {
			$param[ 'count_pages' ] = 1;
		}

		if ( isset( $this->get[ 'page' ] ) ) {
			$param[ 'active' ] = $this->get[ 'page' ];
		} else {
			$param[ 'active' ] = 1;
		}

		$page_id = $this->PaginArray( $id , $page_count , $param[ 'active' ] );

		$param[ 'tests' ] = $this->CreateArrayTest( $page_id );
		$param[ 'sort' ]  = 'Сортування за ' . $array[ 'sort' ];

		$content = $this->view->render( 'testoftest' , $param , 'site' , true );
		$this->render( $content );
	}

	private function SortTest() {
		if ( ! isset( $_SESSION[ 'topic' ] ) || ( isset( $_SESSION[ 'topic' ] ) && $_SESSION[ 'topic' ] == 'Всі теми' ) ) {
			$_SESSION[ 'topic' ] = 'Всі теми';
		}
		if ( ! isset( $_SESSION[ 'sortBy' ] ) ) {
			$_SESSION[ 'sortBy' ] = 'problem';
		}

		if ( isset( $_POST[ 'topic' ] ) && ! is_numeric( $_POST[ 'topic' ] ) ) {
			$_SESSION[ 'topic' ] = $_POST[ 'topic' ];
		}

		if ( isset( $_POST[ 'sortBy' ] ) && ! is_numeric( $_POST[ 'sortBy' ] ) ) {
			$_SESSION[ 'sortBy' ] = $_POST[ 'sortBy' ];
		}

		if ( $_SESSION[ 'topic' ] != 'Всі теми' ) {
			$where = "`topic` = '" . $_SESSION[ 'topic' ] . "'";
		} else {
			$where = '';
		}
		if ( $_SESSION[ 'sortBy' ] == 'type' ) {
			$sort = 'типом';
		} elseif ( $_SESSION[ 'sortBy' ] == 'topic' ) {
			$sort = 'назвою теми';
		} elseif ( $_SESSION[ 'sortBy' ] == 'options' ) {
			$sort = 'варіантом';
		} else {
			$sort = 'назвою тесту';
		}

		return [
			'where' => $where ,
			'sort'  => $sort
		];
	}

	private function PaginArray( $array , $pagin_count , $page ) {
		$array_pagin = array ();
		$p           = 0;
		$c           = 0;
		for ( $i = 0; $i < count( $array ); $i ++ ) {
			$array_pagin[ $p ][ $c ] = $array[ $i ][ 'id_test' ];
			$c ++;
			if ( $c == $pagin_count ) {
				$c = 0;
				$p ++;
			}
		}
		if ( ! is_numeric( $page ) || $page < 0 || $page > count( $array_pagin ) ) {
			if(isset($array_pagin[0]))
			    return $array_pagin[ 0 ];
		}

		if(isset($array_pagin[$page - 1]))
		    return $array_pagin[ $page - 1 ];
	}

	private function CreateArrayTest( $id ) {
		$tests = [];
		for ( $i = 0; $i < count( $id ); $i ++ ) {
			$test        = new Test( $id[ $i ] );
			$tests[ $i ] = $test->toArray();
		}

		return $tests;
	}

	public function actionTestEdit() {
		$this->title = 'Редагування тесту';
		if ( ! isset( $this->get[ 'action' ] ) || ( ! isset( $this->get[ 'id' ] ) && $this->get[ 'action' ] != 'add' ) ) {
			header( "Location: /test" );
			exit;
		}

		if ( $this->get[ 'action' ] == 'edit' ) {
			$param = $this->EditTest();
		}

		if ( $this->get[ 'action' ] == 'add' ) {
			$param = $this->AddTest();
		}

		$content = $this->view->render( 'testedit' , $param , 'site' , true );
		$this->render( $content );
	}

	private function EditTest() {
		$param = [
			'message'  => '' ,
			'class'    => '' ,
			'img_edit' => ''
		];
		$test  = new Test( $this->get[ 'id' ] );
		if ( isset( $_POST[ 'submit' ] ) ) {
			$param[ 'error' ] = $test->Edit( $_POST );
			$param[ 'value' ] = $test->toArrayAll();
			if ( $test->valide ) {
				$param[ 'message' ] = 'Тест успішно додано';
				$param[ 'class' ]   = 'alert alert-success';
			} else {
				$param[ 'message' ] = 'Дані про тест введено з помилками. Виправте їх та спробуйте ще раз';
				$param[ 'class' ]   = 'alert alert-danger';
			}
		} else {
			$param            = [
				'value' => $test->toArray(),
				'message' => '' ,
				'class'   => '' ,
			];
			$param[ 'error' ] = Test::$error;
			if ( empty( $param[ 'value' ] ) ) {
				$param[ 'value' ] = [
					'problem' => '' ,
					'options' => '' ,
					'topic'   => '' ,
					'right'   => '' ,
					'wrong'   => '' ,
					'link'    => '' ,
					'type'    => '' ,
					'message' => '' ,
					'class'   => '' ,
				];
			}
		}

		if ( $param[ 'value' ][ 'link' ] != '' ) {
			$array[ 'link' ]     = $param[ 'value' ][ 'link' ];
			$param[ 'img_edit' ] = $this->view->render( 'img_edit' , $array , 'block' , true );
		}

		return $param;
	}

	private function AddTest() {
		$param = [
			'message'  => '' ,
			'class'    => '' ,
			'img_edit' => ''
		];
		if ( isset( $_POST[ 'submit' ] ) ) {
			$test             = new Test();
			$param[ 'error' ] = $test->Add( $_POST );
			$param[ 'value' ] = $test->toArrayAll();
			if ( $test->valide ) {
				$param[ 'message' ] = 'Тест успішно додано';
				$param[ 'class' ]   = 'alert alert-success';
				if ( $param[ 'value' ][ 'link' ] != '' ) {
					$array[ 'link' ]     = $param[ 'value' ][ 'link' ];
					$param[ 'img_edit' ] = $this->view->render( 'img_edit' , $array , 'block' , true );
				}
			} else {
				$param[ 'message' ] = 'Дані про тест введено з помилками. Виправте їх та спробуйте ще раз';
				$param[ 'class' ]   = 'alert alert-danger';
			}
		} else {
			$param[ 'error' ] = Test::$error;
			$param[ 'value' ] = [
				'options' => '' ,
				'topic'   => '' ,
				'problem' => '' ,
			];
		}

		return $param;
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
		}
		$this->view->render( $this->layout , $params , 'layouts' );
	}

}

?>