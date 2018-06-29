<?php

class CycleRender {

	public static function CreateResultTable() {
		if ( ! isset( $_SESSION[ 'years' ] ) ) {
			$years = date( 'Y' );
		} else {
			$years = $_SESSION[ 'years' ];
		}
		if ( ! isset( $_SESSION[ 'groups' ] ) ) {
			$groups = '3ОК1';
		} else {
			$groups = $_SESSION[ 'groups' ];
		}
		$view             = new View( DIR_ADMIN );
		$param[ 'thead' ] = CycleRender::THead();
		$param[ 'tbody' ] = CycleRender::TBody( $years , $groups );

		return $view->render( 'table_result' , $param , 'block' , true );
	}

	private static function THead() {
		$topic            = CycleRender::OutData( 'topic' );
		$params[ 'coll' ] = '';
		$view             = new View( DIR_ADMIN );
		$param[ 'teg' ]   = 'th';
		for ( $i = - 1; $i < count( $topic ); $i ++ ) {
			if ( $i == - 1 ) {
				$param[ 'row' ]      = 'Студент';
				$param[ 'atribute' ] = 'width="200px"';
			} else {
				$param[ 'row' ]      = $topic[ $i ][ 'topic' ];
				$param[ 'atribute' ] = '';
			}
			$params[ 'coll' ] .= $view->render( 'coll_table' , $param , 'block' , true );
		}

		return $view->render( 'row_table' , $params , 'block' , true );
	}

	private static function TBody( $years , $groups ) {
		$table_user = new FieldDB( 'user' );
		$results    = CycleRender::OutData( 'results' );
		$topic      = CycleRender::OutData( 'topic' );
		$user       = $table_user->SelectFieldWhere( [ 'id_user' , 'username' ] , [
			"`years` = '" . $years . "'" ,
			"`groups` = '" . $groups . "'"
		] );
		$param      = [
			'coll'     => '' ,
			'result'   => '' ,
			'teg'      => 'td' ,
			'atribute' => ''
		];
		$view       = new View( DIR_ADMIN );
		for ( $u = 0; $u < count( $user ); $u ++ ) {
			for ( $i = - 1; $i < count( $topic ); $i ++ ) {
				if ( $i == - 1 ) {
					$param[ 'row' ] = $user[ $u ][ 'username' ];
				} else {
					for ( $r = 0; $r < count( $results ); $r ++ ) {
						if ( $results[ $r ][ 'id_topic' ] == $topic[ $i ][ 'id_topic' ] && $results[ $r ][ 'id_user' ] == $user[ $u ][ 'id_user' ] ) {
							$param[ 'row' ] = $results[ $r ][ 'result' ];
							break;
						} else {
							$param[ 'row' ] = 'N/A';
						}
					}
				}
				$param[ 'coll' ] .= $view->render( 'coll_table' , $param , 'block' , true );
			}
			$param[ 'result' ] .= $view->render( 'row_table' , $param , 'block' , true );
			$param[ 'coll' ]   = '';
		}

		return $param[ 'result' ];

	}

	public static function COption( $field , $table = null , $selected = null ) {
		if ( $table == null ) {
			$ktable = 'user';
		} else {
			$ktable = $table;
		}
		$table = new FieldDB( $ktable );
		$name  = $table->SelectDistinct( $field );
		$row   = '';
		$view  = new View( DIR_ADMIN );
		for ( $i = 0; $i < count( $name ); $i ++ ) {
			$param[ 'value' ] = $name[ $i ];
			if ( $selected != null && $selected == $param[ 'value' ] ) {
				$param[ 'select' ] = 'selected';
			} else {
				$param[ 'select' ] = '';
			}
			$row .= $view->render( 'option' , $param , 'block' , true );
		}

		return $row;
	}

	public static function Way() {
		if ( isset( $_SESSION[ 'years' ] ) && isset( $_SESSION[ 'groups' ] ) ) {
			return $_SESSION[ 'years' ] . ' / ' . $_SESSION[ 'groups' ];
		} elseif ( isset( $_SESSION[ 'years' ] ) && ! isset( $_SESSION[ 'groups' ] ) ) {
			return $_SESSION[ 'years' ] . ' / 3ОК1';
		} elseif ( ! isset( $_SESSION[ 'years' ] ) && isset( $_SESSION[ 'groups' ] ) ) {
			return date( 'Y' ) . ' / ' . $_SESSION[ 'groups' ];
		} else {
			return date( 'Y' ) . ' / 3ОК1';
		}
	}

	public static function CreateTopic() {
		$topic = CycleRender::OutData( 'topic' );
		$view  = new View( DIR_ADMIN );
		$coll  = [
			'teg'      => 'td' ,
			'atribute' => ''
		];
		$row   = '';
		for ( $i = 0; $i < count( $topic ); $i ++ ) {
			$coll[ 'row' ]   = $topic[ $i ][ 'topic' ];
			$param[ 'coll' ] = $view->render( 'coll_table' , $coll , 'block' , true );

			$coll[ 'row' ]   = $view->render( 'link' , [
				'link'    => '/topic?action=edit&id=' . $topic[ $i ][ 'id_topic' ] ,
				'message' => 'Редагувати'
			] , 'block' , true );
			$param[ 'coll' ] .= $view->render( 'coll_table' , $coll , 'block' , true );

			$coll[ 'row' ]   = $view->render( 'link' , [
				'link'    => '/topic?action=delete&id=' . $topic[ $i ][ 'id_topic' ] ,
				'message' => 'Видалити'
			] , 'block' , true );
			$param[ 'coll' ] .= $view->render( 'coll_table' , $coll , 'block' , true );

			$row .= $view->render( 'row_table' , $param , 'block' , true );
		}

		return $row;
	}

	public static function OutData( $table ) {
		$db = new FieldDB( $table );

		return $db->OutData();
	}

	public static function CreateTest( $tests ) {
		$view         = new View( DIR_ADMIN );
		$string_tests = '';
		for ( $i = 0; $i < count( $tests ); $i ++ ) {
			$param[ 'header' ] = $tests[ $i ][ 'topic' ];
			$param[ 'body' ]   = CycleRender::CTest( $tests[ $i ] );
			$param[ 'id' ]     = $tests[ $i ][ 'id_test' ];
			$param[ 'option' ] = $tests[ $i ][ 'options' ];
			$string_tests      .= $view->render( 'block_test' , $param , 'block' , true );
		}
		if ( $string_tests == '' ) {
			return '<h5>В дані темі тести відсутні</h5>';
		}

		return $string_tests;
	}

	private static function CTest( $test ) {
		$view               = new View( DIR_ADMIN );
		$param[ 'problem' ] = $test[ 'problem' ];
		$param[ 'ul' ]      = CycleRender::CUl( $test );
		if ( $test[ 'link' ] != '' ) {
			$param[ 'img' ] = CycleRender::CImg( $test[ 'problem' ] , $test[ 'link' ] );
		} else {
			$param[ 'img' ] = '';
		}

		return $view->render( 'test' , $param , 'block' , true );
	}

	private static function CUl( $test ) {
		$view          = new View( DIR_ADMIN );
		$param[ 'li' ] = CycleRender::CLi( $test );

		return $view->render( 'ul' , $param , 'block' , true );
	}

	private static function CLi( $test ) {
		$view      = new View( DIR_ADMIN );
		$count     = count( $test[ 'right' ] ) + count( $test[ 'wrong' ] );
		$string_li = '';
		$rand      = CycleRender::ARand( 0 , $count - 1 , count( $test[ 'right' ] ), false );
		$r         = 0;
		$w         = 0;
		for ( $i = 0; $i < $count; $i ++ ) {
			if ( isset($rand[$r]) && $i == $rand[ $r ] ) {
				$param[ 'li' ]    = $test[ 'right' ][ $r ];
				$param[ 'color' ] = 'red';
				$r ++;
			} else {
				$param[ 'li' ]    = $test[ 'wrong' ][ $w ];
				$param[ 'color' ] = 'black';
				$w ++;
			}

			$string_li .= $view->render( 'li' , $param , 'block' , true );
		}

		return $string_li;
	}

	private static function CImg( $alt , $link ) {
		$view             = new View( DIR_ADMIN );
		$param[ 'link' ]  = $link;
		$param[ 'alt' ]   = $alt;
		$param[ 'title' ] = $param[ 'alt' ];

		return $view->render( 'img' , $param , 'block' , true );
	}

	private static function ARand( $min, $max, $count, $_repeat )  {
		for($i = 0; $i < $count; $i++) {
			$rand[$i] = rand($min, $max);
		}
		$repeat = false;
		for($i = 0; $i < $count; $i++) {
			for($j = 0; $j != $i; $j++) {
				if($rand[$j] == $rand[$i]) {
					$repeat = true;
					break;
				}
			}
		}
		if ($repeat == true && $_repeat == false)
			return CycleRender::ARand($min, $max, $count, false);
		else {
			sort( $rand );

			return $rand;
		}
	}

	public static function CreatePagination( $count , $active ) {
		$view              = new View( DIR_ADMIN );
		$string[ 'pages' ] = '';
		$krok              = 5;
		if ( is_numeric( $active ) ) {
			$min = $active - $krok;
			$max = $active + $krok;
			for ( $i = 1; $i <= $count; $i ++ ) {
				if ( $min > 3 && $i == 2 ) {
					$param[ 'has_active' ] = 'disabled';
					$param[ 'number' ]     = '...';
					$i                     = $active - 6;
				} elseif ( $i == $max ) {
					$param[ 'has_active' ] = 'disabled';
					$param[ 'number' ]     = '...';
					$i                     = $count - 1;
				} else {
					if ( $i == $active ) {
						$param[ 'has_active' ] = 'active';
					} else {
						$param[ 'has_active' ] = '';
					}
					$param[ 'number' ] = $i;
				}

				$string[ 'pages' ] .= $view->render( 'pagination_page' , $param , 'block' , true );
			}
		}

		return $view->render( 'pagination' , $string , 'block' , true );
	}
}

?>