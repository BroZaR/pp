<?php

class Route {

	public static function start() {
		$controller_name = 'site';
		$action_name = 'index';

		$parse_url = parse_url( $_SERVER[ 'REQUEST_URI' ] );
		$uri       = substr( $parse_url[ 'path' ] , 1 );
		if ( $uri ) {
			$action_name = $uri;
		}
		if ( isset( $parse_url[ 'query' ] ) ) {
			parse_str( $parse_url[ 'query' ] , $get );
		} else {
			$get = array ();
		}
		$controller_name = $controller_name . 'Controller';
		$action_name     = 'action' . $action_name;
		$controller      = new $controller_name( $get );
		if ( method_exists( $controller , $action_name ) ) {
			$controller->$action_name();
		} else {
			$controller->action404();
		}
	}
}

?>