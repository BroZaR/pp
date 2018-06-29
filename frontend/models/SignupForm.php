<?php

class SignupForm {

	private $name;
	private $surname;
	private $email;
	private $password;
	private $groups;
	private $rights;
	private $key;

	public function __construct( $data ) {
		$this->name     = $data[ 'name' ];
		$this->surname  = $data[ 'surname' ];
		$this->email    = $data[ 'email' ];
		$this->password = $data[ 'password' ];
		$this->key      = $data[ 'key' ];
	}

	public function AuditField() {
		$error[ 'name' ]     = $this->AuditString( 'name' );
		$error[ 'surname' ]  = $this->AuditString( 'surname' );
		$error[ 'email' ]    = $this->AuditString( 'email' );
		$error[ 'password' ] = $this->AuditString( 'password' );
		$error[ 'key' ]      = $this->AuditKey();
		$error[ 'total' ]    = $this->AuditArray( $error );
		if ( ! $error[ 'total' ] ) {
			return [];
		}
		$error[ 'message' ] = new ErrorMessage( 'signup' );

		return $error;
	}

	private function AuditString( $field ) {
		if ( $this->$field == '' ) {
			return [
				'class'   => ' has-error' ,
				'message' => 'Дане поле повинне містити символи'
			];
		} else {
			return [
				'class'   => ' has-default' ,
				'message' => ''
			];
		}
	}

	private function AuditKey() {
		$signupkey = new FieldDB( 'signupkey' );
		$key       = $signupkey->OutData();
		$valid     = false;
		for ( $i = 0; $i < count( $key ); $i ++ ) {
			if ( $this->key == $key[ $i ][ 'skey' ] ) {
				$this->groups = $key[ $i ][ 'groups' ];
				$this->rights = $key[ $i ][ 'rights' ];
				$valid        = true;
				break;
			}
		}
		if ( $valid ) {
			return [
				'class'   => ' has-default' ,
				'message' => ''
			];
		}

		return [
			'class'   => ' has-error' ,
			'message' => 'Такого ключа не існує'
		];
	}

	private function AuditArray( $error ) {
		$error_total = false;
		foreach ( $error as $key => $value ) {
			if ( $value[ 'class' ] == ' has-error' ) {
				$error_total = true;
				break;
			}
		}

		return $error_total;
	}

	public function FormatField() {
		$db       = new FieldDB( 'user' );
		$count_id = $db->SelectCount( 'id_user' );

		return [
			'id'       => ++$count_id,
			'username' => "$this->surname $this->name",
			'email'    => $this->email ,
			'password' => md5( $this->password ) ,
			'groups'   => $this->groups ,
			'years'    => date( 'Y' ) ,
			'rights'   => $this->rights
		];
	}

	public static function CreateClassArray() {
		return [
			'name'     => [
				'class'   => ' has-default' ,
				'message' => ''
			] ,
			'surname'  => [
				'class'   => ' has-default' ,
				'message' => ''
			] ,
			'email'    => [
				'class'   => ' has-default' ,
				'message' => ''
			] ,
			'password' => [
				'class'   => ' has-default' ,
				'message' => ''
			] ,
			'key'      => [
				'class'   => ' has-default' ,
				'message' => ''
			] ,
			'message'  => ''
		];
	}
}

?>