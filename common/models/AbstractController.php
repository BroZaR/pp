<?php

abstract class AbstractController {

	protected $view;
	protected $user;

	public function __construct( $view , $user ) {
		$this->view = $view;
		$this->user = $user;
	}

	public function action404() {
		header( 'HTTP/1.1 404 Not Found' );
		header( 'Status: 404 Not Found' );
	}

	abstract protected function render( $str );
}

?>