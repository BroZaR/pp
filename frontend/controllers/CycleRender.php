<?php

class CycleRender {

	public static function CreateMemu() {
		$topic      = CycleRender::OutData( 'topic' );
		$view       = new View( DIR_USER );
		$menu_topic = '';
		for ( $i = 0; $i < count( $topic ); $i ++ ) {
			$param[ 'link' ]  = "topic?topic=" . $topic[ $i ][ 'id_topic' ];
			$param[ 'topic' ] = $topic[ $i ][ 'topic' ];
			$menu_topic       .= $view->render( 'menu_topic' , $param , 'site' , true );
		}

		return $menu_topic;
	}

	public static function CreateRowTable( $id_user ) {
		$topic     = CycleRender::OutData( 'topic' );
		$resultsdb = new FieldDB( 'results' );
		$results   = $resultsdb->SelectFieldWhere( [ 'id_topic' , 'result' ] , "`id_user` = '" . $id_user . "'" );
		$view      = new View( DIR_USER );
		$row       = '';
		for ( $i = 0; $i < count( $topic ); $i ++ ) {
			$param[ 'topic' ] = $topic[ $i ][ 'topic' ];
			if ( ! empty( $results ) ) {
				for ( $k = 0; $k < count( $results ); $k ++ ) {
					if ( $topic[ $i ][ 'id_topic' ] == $results[ $k ][ 'id_topic' ] ) {
						$param[ 'point' ] = $results[ $k ][ 'result' ];
						break;
					} else {
						$param[ 'point' ] = 'N/A';
					}
				}
			} else {
				$param[ 'point' ] = 'N/A';
			}
			$row .= $view->render( 'table_row' , $param , 'site' , true );
		}

		return $row;
	}

	public static function CreateResultTable($groups) {
		$topic = CycleRender::OutData('topic');
		$row = '';
		$view = new View(DIR_ADMIN);
		for($i = -1; $i < count($topic); $i++) {
			if($i == -1) $param['param'] = 'Студент';
			else $param['param'] = $topic[$i]['topic'];
			$row .= $view->render('block_row_table',$param,'site', true);
		}
	}

	public static function CreateBlockAnswer( $id_user ) {
		$topic     = CycleRender::OutData( 'topic' );
		$resultsdb = new FieldDB( 'results' );
		$results   = $resultsdb->SelectFieldWhere( 'id_topic' , "`id_user` = '" . $id_user . "'" );
		$view      = new View( DIR_USER );
		$block     = '';
		for ( $i = 0; $i < count( $topic ); $i ++ ) {
			$param[ 'topic' ] = $topic[ $i ][ 'topic' ];
			if ( ! empty( $results ) ) {
				for ( $k = 0; $k < count( $results ); $k ++ ) {
					if ( $topic[ $i ][ 'id_topic' ] == $results[ $k ][ 'id_topic' ] ) {
						$param[ 'link' ]  = '/answer?topic=' . $results[ $k ][ 'id_topic' ];
						$param[ 'class' ] = 'bg-success';
						$param[ 'icon' ]  = 'fa fa-pencil-square-o';
						$param['message'] = '';
						break;
					} else {
						$param[ 'link' ]  = '#';
						$param[ 'class' ] = 'bg-info';
						$param[ 'icon' ]  = 'fa fa-window-close-o';
						$param['message'] = 'Ви не можите переглядати відповіді, поки не здасте даний тест';
					}
				}
			} else {
				$param[ 'link' ]  = '#';
				$param[ 'class' ] = 'bg-info';
				$param[ 'icon' ]  = 'fa fa-window-close-o';
				$param['message'] = 'Ви не можите переглядати відповіді, поки не здасте даний тест';
			}
			$block .= $view->render( 'answer_row' , $param , 'site' , true );
		}

		return $block;
	}

	public static function CreateTest( $tests ) {
		$string_tests = '';
		for ( $i = 0; $i < count( $tests ); $i ++ ) {
			if ( preg_match( '/link/' , $tests[ $i ][ 'type' ] ) ) {
				if(preg_match('/test/' , $tests[ $i ][ 'type' ]))
				    $string_tests .= CycleRender::BlockTestLink( $tests[ $i ] );
				else
					$string_tests .= CycleRender::BlockCheckLink( $tests[ $i ] );
			} else {
				if(preg_match('/test/' , $tests[ $i ][ 'type' ]))
					$string_tests .= CycleRender::BlockTest( $tests[ $i ] );
				else
					$string_tests .= CycleRender::BlockCheckC( $tests[ $i ] );
			}
		}

		return $string_tests;
	}

	private static function BlockTestLink( $tests, $test = '' ) {
		$view               = new View( DIR_USER );
		$param[ 'problem' ] = $tests[ 'problem' ];
		if($test == 'answer')
		    $param[ 'radio' ]   = CycleRender::BlockAnswer( $tests );
		else
			$param[ 'radio' ]   = CycleRender::BlockRadio( $tests );
		$param['pidk'] = '(Відзначте один правильний варіант відповіді)';
		$param[ 'link' ]    = $tests[ 'link' ];

		return $view->render( 'block_test_link' , $param , 'site' , true );
	}

	private static function BlockCheckLink( $tests, $test = '' ) {
		$view               = new View( DIR_USER );
		$param[ 'problem' ] = $test[ 'problem' ];
		$param['pidk'] = '(Відзначте ті відповіді, які вважаєте правильними)';
		if($test == 'answer')
			$param[ 'radio' ]   = CycleRender::BlockAnswer( $tests );
		else
			$param[ 'radio' ]   = CycleRender::BlockCheck( $tests );
		$param[ 'link' ]    = $test[ 'link' ];

		return $view->render( 'block_test_link' , $param , 'site' , true );
	}

	private static function BlockTest( $tests, $test = '' ) {
		$view               = new View( DIR_USER );
		$param[ 'problem' ] = $tests[ 'problem' ];
		$param['pidk'] = '(Відзначте один правильний варіант відповіді)';
		if($test == 'answer')
			$param[ 'radio' ]   = CycleRender::BlockAnswer( $tests );
		else
			$param[ 'radio' ]   = CycleRender::BlockRadio( $tests );

		return $view->render( 'block_test' , $param , 'site' , true );
	}

	private static function BlockCheckC( $tests, $test = '' ) {
		$view               = new View( DIR_USER );
		$param[ 'problem' ] = $tests[ 'problem' ];
		$param['pidk'] = '(Відзначте ті відповіді, які вважаєте правильними)';
		if($test == 'answer')
			$param[ 'radio' ]   = CycleRender::BlockAnswer( $tests );
		else
			$param[ 'radio' ]   = CycleRender::BlockCheck( $tests );

		return $view->render( 'block_test' , $param , 'site' , true );
	}

	private static function BlockRadio( $tests ) {
		$count              = count( $tests[ 'right' ] ) + count( $tests[ 'wrong' ] );
		$view               = new View( DIR_USER );
		$right              = rand( 0 , $count - 1 );
		$param[ 'id_test' ] = $tests[ 'id_test' ];
		$w                  = 0;
		$block              = '';
		for ( $i = 0; $i < $count; $i ++ ) {
			if ( $i == $right ) {
				$param[ 'test' ] = $tests[ 'right' ][ 0 ];
			} else {
				$param[ 'test' ] = $tests[ 'wrong' ][ $w ];
				$w ++;
			}
			$block .= $view->render( 'block_radio' , $param , 'site' , true );
		}

		return $block;
	}

	private static function BlockCheck( $test ) {
		$count              = count( $test[ 'right' ] ) + count( $test[ 'wrong' ] );
		$view               = new View( DIR_USER );
		$rand              = CycleRender::ARand(0, $count - 1, count($test['right']), false);
		$param[ 'id_test' ] = $test[ 'id_test' ];
		$r = 0;
		$w                  = 0;
		$block              = '';
		for ( $i = 0; $i < $count; $i ++ ) {
			if ( isset($rand[$r]) && $i == $rand[$r] ) {
				$param[ 'test' ] = $test[ 'right' ][ $r ];
				$r++;
			} else {
				$param[ 'test' ] = $test[ 'wrong' ][ $w ];
				$w ++;
			}
			$param['number'] = $i;

			$block .= $view->render( 'block_check' , $param , 'site' , true );
		}

		return $block;
	}

	private static function BlockAnswer( $answer ) {
		$view = new View(DIR_USER);
		$array = CycleRender::Create($answer);
		CycleRender::NotNull($array);
		$string = '';

		for($i = 0; $i < count($array['right']); $i ++) {
			for($k = 0; $k < count($array['answer']); $k ++) {
				if($array['answer'][$k] == $array['right'][$i]) {
					$param['color'] = 'black';
					break;
				} else {
					$param['color'] = '#ccc';
				}
			}
			$param['answer'] = '(+) ' . $array['right'][$i];
			$string .= $view->render('block_answer_ol', $param, 'site', true);
	    }

		for($i = 0; $i < count($array['wrong']); $i ++) {
			for($k = 0; $k < count($array['answer']); $k ++) {
				if($array['answer'][$k] == $array['wrong'][$i]) {
					$param['color'] = 'black';
					break;
				} else {
					$param['color'] = '#ccc';
				}
			}
			$param['answer'] = '(-) ' . $array['wrong'][$i];
			$string .= $view->render('block_answer_ol', $param, 'site', true);
		}

		return $string;
	}

	private static function Create( $answer ) {
		return [
			'right' => [
				$answer['right_0'],
				$answer['right_1'],
				$answer['right_2'],
				$answer['right_3'],
				$answer['right_4'],
			],
			'wrong' => [
				$answer['wrong_0'],
				$answer['wrong_1'],
				$answer['wrong_2'],
				$answer['wrong_3'],
				$answer['wrong_4'],
			],
			'answer' => [
				$answer['answer_0'],
				$answer['answer_1'],
				$answer['answer_2'],
				$answer['answer_3'],
				$answer['answer_4'],
				$answer['answer_5'],
				$answer['answer_6'],
				$answer['answer_7'],
				$answer['answer_8'],
				$answer['answer_9'],
			],
		];
	}

	private static function NotNull( &$array ) {
		foreach ($array['right'] as $key => $value) {
			if($value == '')
				unset($array['right'][$key]);
		}

		foreach ($array['wrong'] as $key => $value) {
			if($value == '')
				unset($array['wrong'][$key]);
		}

		foreach ($array['answer'] as $key => $value) {
			if($value == '')
				unset($array['answer'][$key]);
		}
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

	public static function OutData( $table ) {
		$db = new FieldDB( $table );

		return $db->OutData();
	}

	public static function CreateAnswer( $answer ) {
		$string_tests = '';
		for($i = 0; $i < count($answer); $i ++) {
			if ( preg_match( '/link/' , $answer[ $i ][ 'type' ] ) ) {
				if(preg_match('/test/' , $answer[ $i ][ 'type' ]))
					$string_tests .= CycleRender::BlockTestLink( $answer[ $i ], 'answer' );
				else
					$string_tests .= CycleRender::BlockCheckLink( $answer[ $i ], 'answer' );
			} else {
				if(preg_match('/test/' , $answer[ $i ][ 'type' ]))
					$string_tests .= CycleRender::BlockTest( $answer[ $i ], 'answer' );
				else
					$string_tests .= CycleRender::BlockCheckC( $answer[ $i ], 'answer' );
			}
		}

		return $string_tests;
	}
}

?>