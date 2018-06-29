<?php

class Test extends FieldDB {

	private $id;
	private $topic;
	private $options;
	private $type;
	private $problem;
	private $right;
	private $wrong;
	private $link;
	public $valide;

	public static $error = [
		'topic'   => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
		'options' => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
		'problem' => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
		'link'    => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
		'right'   => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
		'wrong'   => [
			'message' => '' ,
			'class'   => 'has-default'
		] ,
	];

	public function __construct( $id = null ) {
		parent::__construct( 'test' );
		if ( $id != null ) {
			$this->id     = $id;
			$this->valide = $this->SetField();
		}
	}

	private function SetField() {
		$test = $this->SelectFieldWhereData( '*' , "`id_test` = '" . $this->id . "'" , '' , [
			'table' => 'topic' ,
			'key'   => "`test`.`id_topic`=`topic`.`id_topic`"
		] );
		if ( ! empty( $test ) ) {
			$this->topic   = $test[ 0 ][ 'topic' ];
			$this->options = $test[ 0 ][ 'options' ];
			$this->type    = $test[ 0 ][ 'type' ];
			$this->problem = $test[ 0 ][ 'problem' ];
			$this->right   = [];
			$this->wrong   = [];
			for ( $i = 0; $i < 5; $i ++ ) {
				if ( isset( $test[ 0 ][ "right_$i" ] ) && $test[ 0 ][ "right_$i" ] ) {
					$this->right[ $i ] = $test[ 0 ][ "right_$i" ];
				}
				if ( isset( $test[ 0 ][ "wrong_$i" ] ) && $test[ 0 ][ "wrong_$i" ] ) {
					$this->wrong[ $i ] = $test[ 0 ][ "wrong_$i" ];
				}
			}
			if ( preg_match( '/link/' , $this->type ) ) {
				$this->link = $test[ 0 ][ 'link' ];
			} else {
				$this->link = null;
			}

			return true;
		} else {
			return false;
		}
	}

	private function SetFieldWithData( $data ) {
		$this->valide = true;
		$right        = [
			$data[ 'right_0' ] ,
			$data[ 'right_1' ] ,
			$data[ 'right_2' ] ,
			$data[ 'right_3' ] ,
			$data[ 'right_4' ] ,
		];
		$wrong        = [
			$data[ 'wrong_0' ] ,
			$data[ 'wrong_1' ] ,
			$data[ 'wrong_2' ] ,
			$data[ 'wrong_3' ] ,
			$data[ 'wrong_4' ] ,
		];

		return [
			'topic'   => $this->SetTopic( $data[ 'topic' ] ) ,
			'options' => $this->SetOptions( $data[ 'options' ] ) ,
			'problem' => $this->SetProblem( $data[ 'problem' ] ) ,
			'link'    => $this->SetImg() ,
			'right'   => $this->SetRight( $right ) ,
			'wrong'   => $this->SetWrong( $wrong ) ,
			'type'    => $this->SetType() ,
		];

	}

	private function SetTopic( $topic ) {
		if ( $this->StringValide( $topic ) && ! is_numeric( $topic ) ) {
			$this->topic = $topic;
		} else {
			$this->topic  = null;
			$this->valide = false;

			return false;
		}

		return true;
	}

	private function SetOptions( $options ) {
		if ( $this->OptionsValide( $options ) ) {
			$this->options = $options;
		} else {
			$this->options = null;
			$this->valide  = false;

			return false;
		}

		return true;
	}

	private function SetProblem( $problem ) {
		if ( $problem != '' ) {
			$this->problem = $problem;
		} else {
			$this->problem = null;
			$this->valide  = false;

			return false;
		}

		return true;
	}

	private function SetRight( $right ) {
		if ( $this->ArrayValide( $right ) && $this->CountRight( $right ) >= 1 ) {
			$this->right = $right;
		} else {
			$this->right  = null;
			$this->valide = false;

			return false;
		}

		return true;
	}

	private function SetWrong( $wrong ) {
		if ( $this->ArrayValide( $wrong ) ) {
			$this->wrong = $wrong;
		} else {
			$this->wrong  = null;
			$this->valide = false;

			return false;
		}

		return true;
	}

	public function SetImg() {
		if ( $_FILES[ 'file' ][ 'name' ] == '' ) {
			$this->link = '';

			return true;
		}
		$path     = 'image/test/';
		$tmp_path = $_FILES[ 'file' ][ 'tmp_name' ];
		// Массив допустимых значений типа файла
		$types = array ( 'image/gif' , 'image/png' , 'image/jpeg' );

		// Обработка запроса
		// Проверяем тип файла
		if ( ! in_array( $_FILES[ 'file' ][ 'type' ] , $types ) ) {
			$this->valide = false;
			$this->link   = '';

			return false;
			exit();
		}
		$name = $_FILES[ 'file' ][ 'name' ];

		// Загрузка файла и вывод сообщения
		if ( ! @copy( $tmp_path , $path . $name ) ) {
			// Удаляем временный файл
			//unlink( $tmp_path );
			$this->link   = '';
			$this->valide = false;

			return false;
		} else {
			$this->link = '..\\' . $path . $name;
			$this->link = str_replace( '/' , '\\' , $this->link );
			// Удаляем временный файл
			unlink( $tmp_path );

			return true;
		}
		//setcookie('img_eror', $img_eror, time() + 3600);
	}

	private function SetType() {
		$count = $this->CountRight( $this->right );
		if ( ! empty( $this->right ) ) {
			if ( $count == 1 ) {
				$this->type = 'test';
			} else {
				$this->type = 'check';
			}

			if ( $this->link != '' ) {
				$this->type .= '_link';
			}

			return true;
		} else {
			$this->valide = false;

			return false;
		}
	}

	private function CountRight( $right ) {
		$count = 0;
		for ( $i = 0; $i < count( $right ); $i ++ ) {
			if ( $right[ $i ] != '' ) {
				$count ++;
			}
		}

		return $count;
	}

	public function Add( $data ) {
		$this->id = $this->SetId();
		return $this->AddEdit($data, 'add');
	}

	public function Edit( $data ) {
		return $this->AddEdit($data, 'edit');
	}

	private function AddEdit( $data, $action ) {
		$valide = $this->SetFieldWithData( $data );
		if ( $this->valide ) {
			$field = [
				'id_test' ,
				'id_topic' ,
				'options' ,
				'type' ,
				'problem' ,
				'right_0' ,
				'right_1' ,
				'right_2' ,
				'right_3' ,
				'right_4' ,
				'wrong_0' ,
				'wrong_1' ,
				'wrong_2' ,
				'wrong_3' ,
				'wrong_4' ,
				'link' ,
			];

			$right    = $this->AddNullInArray( $this->right );
			$wrong    = $this->AddNullInArray( $this->wrong );
			$table    = new FieldDB( 'topic' );
			$topic    = $table->OutData();
			$id_topic = $this->FiendId( $topic );

			$values = [
				$this->id ,
				$id_topic ,
				$this->options ,
				$this->type ,
				$this->problem ,
				$right[ 0 ] ,
				$right[ 1 ] ,
				$right[ 2 ] ,
				$right[ 3 ] ,
				$right[ 4 ] ,
				$wrong[ 0 ] ,
				$wrong[ 1 ] ,
				$wrong[ 2 ] ,
				$wrong[ 3 ] ,
				$wrong[ 4 ] ,
				$this->link
			];

			if($action == 'add') {
				$this->InsertData( $field , $values );
			} else {
				$this->UpdateDataWithArray($field , $values, 'id_test',$this->id);
			}

			return Test::$error;
		} else {
			return $this->Error( $valide );
		}
	}

	private function Error( $valide ) {
		$error = Test::$error;
		if ( ! $valide[ 'topic' ] ) {
			$error[ 'topic' ][ 'message' ] = 'Неправильно введено тему';
			$error[ 'topic' ][ 'class' ]   = 'has-error';
		}
		if ( ! $valide[ 'options' ] ) {
			$error[ 'options' ][ 'message' ] = 'Значення мають бути в межах від 1 до 10';
			$error[ 'options' ][ 'class' ]   = 'has-error';
		}
		if ( ! $valide[ 'problem' ] ) {
			$error[ 'problem' ][ 'message' ] = 'Поле має містити видимі символи';
			$error[ 'problem' ][ 'class' ]   = 'has-error';
		}
		if ( ! $valide[ 'link' ] ) {
			$error[ 'link' ][ 'message' ] = 'Картинка має бути у форматі jpg, png або gif';
			$error[ 'link' ][ 'class' ]   = 'has-error';
		}
		if ( ! $valide[ 'right' ] ) {
			$error[ 'right' ][ 'message' ] = 'Має бути хоча б одна правильна відповідь';
			$error[ 'right' ][ 'class' ]   = 'has-error';
		}
		if ( ! $valide[ 'wrong' ] ) {
			$error[ 'wrong' ][ 'message' ] = 'Поля мають містити видимі символи';
			$error[ 'wrong' ][ 'class' ]   = 'has-error';
		}

		return $error;
	}

	private function FiendId( $array ) {
		for ( $i = 0; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ][ 'topic' ] == $this->topic ) {
				return $array[ $i ][ 'id_topic' ];
			}
		}

		return '';
	}

	private function AddNullInArray( $array , $count = 5 ) {
		for ( $i = 0; $i < $count; $i ++ ) {
			if ( ! isset( $array[ $i ] ) ) {
				$array[ $i ] = null;
			}
		}

		return $array;
	}

	private function StringValide( $var ) {
		return ( is_string( $var ) && $var != '' );
	}

	private function OptionsValide( $var ) {
		return ( is_numeric( $var ) && $var > 0 );
	}

	private function ArrayValide( $var ) {
		return ( is_array( $var ) && count( $var ) < 6 );
	}

	private function SetId() {
		$max = $this->SelectMax( 'id_test' );

		return ( $max[ 0 ][ 'max' ] + 1 );
	}

	public function toArray() {
		if ( $this->valide ) {
			return [
				'id_test' => $this->id ,
				'topic'   => $this->topic ,
				'options' => $this->options ,
				'type'    => $this->type ,
				'problem' => $this->problem ,
				'right'   => $this->right ,
				'wrong'   => $this->wrong ,
				'link'    => $this->link
			];
		} else {
			return [];
		}
	}

	public function toArrayAll() {
		return [
			'id_test' => $this->id ,
			'topic'   => $this->topic ,
			'options' => $this->options ,
			'type'    => $this->type ,
			'problem' => $this->problem ,
			'right'   => $this->right ,
			'wrong'   => $this->wrong ,
			'link'    => $this->link
		];
	}
}

?>