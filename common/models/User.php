<?php

class User extends FieldDB {

	public $id;
	public $username;
	public $email;
	public $password;
	public $groups;
	public $years;
	public $rights;

	public function __construct() {
		parent::__construct( 'user' );
		if ( isset( $_SESSION[ 'user' ][ 'id' ] ) ) {
			$this->id = $_SESSION[ 'user' ][ 'id' ];
			$this->FieldUser();
		}
	}

	private function FieldUser() {
		$where     = "`id_user` = '" . $this->id . "'";
		$data_user = $this->SelectFieldWhereData( '*' , $where );
		$this->SetFieldUser( $data_user[ 0 ] );
	}

	public function SetFieldUser( $data ) {
		$this->username = $data[ 'username' ];
		$this->email    = $data[ 'email' ];
		$this->password = $data[ 'password' ];
		$this->groups   = $data[ 'groups' ];
		$this->years    = $data[ 'years' ];
		$this->rights   = $data[ 'rights' ];
	}

	public function Login( $login , $password ) {
		$user = $this->SelectFieldWhereData( [
			'id_user' ,
			'password' ,
			'rights'
		] , "`email` = '" . $login . "'" );
		if ( ! empty( $user[ 0 ] ) && $user[ 0 ][ 'password' ] == md5( $password ) ) {
			$_SESSION[ 'user' ][ 'id' ]    = $user[ 0 ][ 'id_user' ];
			$_SESSION[ 'user' ][ 'right' ] = $user[ 0 ][ 'rights' ];
			$this->id                      = $_SESSION[ 'user' ][ 'id' ];
			$this->FieldUser();

			return true;
		} else {
			return false;
		}
	}

	public function Signup( $data ) {
		$this->InsertData( [
			'id_user' ,
			'username' ,
			'email' ,
			'password' ,
			'groups' ,
			'years' ,
			'rights'
		] , [
			$data[ 'id' ] ,
			$data[ 'username' ] ,
			$data[ 'email' ] ,
			$data[ 'password' ] ,
			$data[ 'groups' ] ,
			$data[ 'years' ] ,
			$data[ 'rights' ]
		] );
		$_SESSION[ 'user' ][ 'id' ] = $data[ 'id' ];
		$this->SetFieldUser( $data );
	}

	public function __toString() {
		return "$this->username";
	}
}

?>