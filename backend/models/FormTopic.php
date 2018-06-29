<?php

class FormTopic {

	private $id;
	private $topic;

	public function __construct( $topic , $id = null ) {
		if ( $id == null ) {
			$this->id = $this->CreateId();
		} else {
			$this->id = $id;
		}
		if ( $topic == '' && $this->id != null ) {
			$this->topic = $this->CreateTopic();
		} else {
			$this->topic = $topic;
		}
	}

	private function CreateId() {
		$table = new FieldDB( 'topic' );
		$max   = $table->SelectMax( 'id_topic' );

		return ++ $max[ 0 ][ 'max' ];
	}

	private function CreateTopic() {
		$table = new FieldDB( 'topic' );
		$topic = $table->SelectFieldWhere( 'topic' , "`id_topic` = '" . $this->id . "'" );
		if(isset($topic[ 0 ][ 'topic' ])) {
			return $topic[ 0 ][ 'topic' ];
		} else {
			return '';
		}
	}

	public function Add() {
		$table = new FieldDB( 'topic' );
		if ( $this->DataValid() ) {
			$table->InsertData( [ 'id_topic' , 'topic' ] , [ $this->id , $this->topic ] );

			return true;
		} else {
			return false;
		}
	}

	public function Edit($name) {
		$table = new FieldDB( 'topic' );
		if ( $this->DataValid() && $name != '') {
			$table->UpdateData('topic', $name, 'id_topic', $this->id);

			return true;
		} else {
			return false;
		}
	}

	public function Delete() {
		$table = new FieldDB('topic');
		$result = new FieldDB('results');
		$test = new FieldDB('test');
		if($this->DataValid()) {
			$table->DeleteData('id_topic', $this->id);
			$result->DeleteData('id_topic', $this->id);
			$test->DeleteData('id_topic', $this->id);
			return true;
		} else {
			return false;
		}
	}

	private function DataValid() {
		if ( is_numeric( $this->id ) && $this->topic != '' && is_string( $this->topic ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function __toString() {
		return $this->topic;
	}
}

?>