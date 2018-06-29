<?php

class Test extends FieldDB {

	public function __construct() {
		parent::__construct('test');
	}

	public function SelectRandomTest($topic) {
		$var = $this->SelectDistinct('options', "`id_topic` = '" . $topic . "'");
		$rand = rand(0, count($var) - 1);
		$_SESSION['options'] = $var[$rand];
		$tests = $this->SelectFieldWhere('*', ["`id_topic` = '" . $topic . "'", "`options` = '" . $_SESSION['options'] . "'"]);
		$this->TestSort($tests);
		return $tests;
	}

	private function TestSort(&$table) {
		$this->NotNull($table);
		for($i = 0; $i < count($table); $i++) {
			$this->Sort($table[$i], 'right');
			$this->Sort($table[$i], 'wrong');
		}
	}

	private function Sort(&$table, $sort) {
		$k = 0;
		foreach ($table as $key => $value) {
			if($key == $sort.'_'.$k) {
				$table[$sort][$k] = $value;
				unset($table[$key]);
				$k++;
			}
		}
	}

	public function CheckingTest( $data, $id_topic ) {
		if(isset($_SESSION['options']))
		    $options = $_SESSION['options'];
		else
			$options = 1;
		$table_answer = new FieldDB('answer');
		$answer_last = $table_answer->SelectFieldWhereData('id_answer',[
			"`id_user` = '". $_SESSION['user']['id'] ."'",
			"`id_topic` = '" . $id_topic . "'"
		], '', [
			'table' => 'test',
			'key' => "`answer`.`id_test` = `test`.`id_test`"
		]);

		if(!empty($answer_last)) {
			for($i = 0; $i < count($answer_last); $i ++) {
				$table_answer->DeleteData('id_answer', $answer_last[$i]['id_answer']);
			}
		}

		$tests = $this->SelectFieldWhere('*', [
			"`id_topic` = '" . $id_topic . "'",
			"`options` = '" . $options . "'"
		]);
		$point_test = 0;
		$point_check = 0;

		foreach($data as $key => $value) {
			if(preg_match('/_/', $key)) {
				$arr = explode('_', $key);
				$data[$arr[0]][$arr[1]] = $value;
				if(isset($tests))
				unset($data[$key]);
			}
		}

		for($i = 0; $i < count($tests); $i ++) {
			if(isset($data[$tests[$i]['id_test']]) && !is_array($data[$tests[$i]['id_test']])) {
				$table_answer->InsertData(
					[
						'id_test',
						'id_user',
						'answer_0'
					],
					[
						$tests[$i]['id_test'],
						$_SESSION[ 'user' ][ 'id' ],
						$data[$tests[$i]['id_test']]
					]);
				if($tests[$i]['right_0'] == $data[$tests[$i]['id_test']])
					$point_test += 1;
			} elseif (isset($data[$tests[$i]['id_test']]) && is_array($data[$tests[$i]['id_test']])) {
				$point_check += $this->CheckPoint($tests[$i], $data[$tests[$i]['id_test']]);
			} else {
				$table_answer->InsertData(
					[
						'id_test',
						'id_user',
					],
					[
						$tests[$i]['id_test'],
						$_SESSION[ 'user' ][ 'id' ],
					]);
			}
		}
		$point = (($point_check + $point_test) * 5) / count($tests);
		$table = new FieldDB('results');
		$table->InsertData(
			[
			'id_user',
			'id_topic',
			'result'
		],
			[
			$_SESSION['user']['id'],
			$id_topic,
			$point
		]);

		return $point;
	}

	private function CheckPoint( $test, $answer ) {
		$right = $this->CreateRight($test);
		$point = 0;
		$checking = true;
		foreach($answer as $key => $value) {
			for($i = 0; $i < count($right); $i ++) {
				if($right[$i] == $value && $checking) {
					$check = true;
					break;
				} else
					$check = false;
			}
			$checking = $check;
		}

		$table = new FieldDB('answer');
		$array = $this->CreateAnswer($answer);
		$field = [
			'id_test',
			'id_user',
			'answer_0',
			'answer_1',
			'answer_2',
			'answer_3',
			'answer_4',
			'answer_5',
			'answer_6',
			'answer_7',
			'answer_8',
			'answer_9',
		];
		$values = [
			$test['id_test'],
			$_SESSION[ 'user' ][ 'id' ],
			$array[0],
			$array[1],
			$array[2],
			$array[3],
			$array[4],
			$array[5],
			$array[6],
			$array[7],
			$array[8],
			$array[9],
		];

		$table->InsertData($field, $values);

		if($checking)
			$point = 1;

		return $point;
	}

	private function CreateRight( $data ) {
		$array = [];
		$k = 0;
		for($i = 0; $i < 5; $i ++) {
			if($data["right_$i"] != '') {
				$array[$k] = $data["right_$i"];
				$k++;
			}
		}

		return $array;
	}

	private function CreateAnswer( $answer ) {
		$array = [];
		$k = 0;
		foreach ($answer as $key => $value) {
			$array[$k] = $value;
			$k++;
		}

		for($i = 0; $i < 10; $i ++) {
			if(!isset($array[$i]))
				$array[$i] = NULL;
		}

		return $array;
	}
}

?>