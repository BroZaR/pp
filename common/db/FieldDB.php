<?php

class FieldDB {

	protected $mysql;
	protected $table;

	public function __construct( $table ) {
		$this->mysql = new mysqli( HOST , USER , PASSWORD , BD );
		$this->table = $table;
	}

	public function OutData() {
		return $this->formatData( $this->myquery( "SELECT * FROM `" . $this->table . "`;" ) );
	}

	public function SelectFieldData( $field ) {
		return $this->formatData( $this->myquery( "SELECT " . $this->formatFieldData( $field ) . " FROM `" . $this->table . "`" ) );
	}

	public function SelectId( $field , $where = '' ) {
		$one = 'SELECT ' . $this->formatFieldData( $field );
		$two = ' FROM `' . $this->table . '`';
		if ( $where != '' ) {
			$three = $this->formatAdd( 'WHERE' , $where );
		} else {
			$three = '';
		}


		return $this->formatData( $this->myquery( $one . $two . $three ) );
	}

	public function SelectFieldWhereData( $field , $where , $order = '' , $inner = array () ) {
		$one = 'SELECT ' . $this->formatFieldData( $field );
		$two = ' FROM `' . $this->table . '`';
		if ( ! empty( $inner ) ) {
			$in = ' INNER JOIN `' . $inner[ 'table' ] . '` ON ' . $inner[ 'key' ];
		} else {
			$in = '';
		}

		if($where != '') {
			$three = $this->formatAdd( 'WHERE' , $where );
		} else {
			$three = '';
		}

		if ( ! empty( $order ) ) {
			$four = ' ORDER BY ' . $this->formatFieldData( $order );
		} else {
			$four = '';
		}

		return $this->formatData( $this->myquery( $one . $two . $in . $three . $four ) );
	}

	public function SelectFieldWhere( $field , $where ) {
		$one   = 'SELECT ' . $this->formatFieldData( $field );
		$two   = ' FROM `' . $this->table . '`';
		$three = $this->formatAdd( 'WHERE' , $where );

		return $this->formatData( $this->myquery( $one . $two . $three ) );
	}

	public function SelectCount( string $field , string $where = '' ) {
		if ( $where == '' ) {
			$qwhere = '';
		} else {
			$qwhere = " WHERE " . $where;
		}
		$query = "SELECT COUNT(`" . $field . "`) as `count` FROM `" . $this->table . "`" . $qwhere . ";";
		$count = $this->formatData( $this->myquery( $query ) );

		return $count[ 0 ][ 'count' ];
	}

	public function SelectMax( string $field ) {
		$query = "SELECT MAX(`" . $field . "`) AS `max` FROM `" . $this->table . "`";

		return $this->formatData( $this->myquery( $query ) );
	}

	public function SelectDistinct( $field, $where = '' ) {
		$query       = "SELECT DISTINCT " . $this->formatFieldData( $field ) . " FROM `" . $this->table . "`";
		if($where != '') {
			$query .= " WHERE " . $where;
		}
		$distinct    = $this->formatData( $this->myquery( $query ) );
		$format_data = array ();
		for ( $i = 0; $i < count( $distinct ); $i ++ ) {
			if ( $distinct[ $i ][ $field ] != null ) {
				$format_data[] = $distinct[ $i ][ $field ];
			}
		}
		rsort( $format_data );

		return $format_data;
	}

	public function InsertData( $field , $values ) {
		if ( count( $field ) == count( $values ) ) {
			$query = "INSERT INTO `" . $this->table . "` (" . $this->formatFieldData( $field ) . ") VALUES (" . $this->formatFieldData( $values , false ) . ")";
		} else {
			return null;
		}

		$this->myquery( $query );
	}

	public function UpdateData( $field , $values , $name_key , $key ) {
		$corect = $this->corectString( $field ) && $this->corectString( $values ) && $this->corectString( $name_key ) && $this->corectString( $key );
		if ( $corect ) {
			$query = "UPDATE `" . $this->table . "` SET `" . $field . "` = '" . $values . "' WHERE `" . $this->table . "`.`" . $name_key . "` = " . $key . ";";
		} else {
			$query = '';
		}
		$this->myquery( $query );
	}

	public function UpdateDataWithArray( array $field , array $values , $name_key , $key ) {
		$corect = $this->corectString( $name_key ) && $this->corectString( $key );
		$set = '';
		for($i = 0; $i < count($field); $i ++) {
			$set .= "`" . $field[$i] . "` = '" . addslashes($values[$i]) . "'";
			if($i != count($field) - 1)
				$set .= ", ";
		}
		if ( $corect ) {
			$query = "UPDATE `" . $this->table . "` SET $set WHERE `" . $this->table . "`.`" . $name_key . "` = " . $key . ";";
		} else {
			$query = '';
		}

		$this->myquery( $query );
	}

	public function DeleteData( $name_key , $key ) {
		if ( $this->corectString( $name_key ) && $this->corectString( $key ) ) {
			$query = "DELETE FROM `" . $this->table . "` WHERE `" . $this->table . "`.`" . $name_key . "` = " . $key . ";";
		} else {
			$query = '';
		}
		$this->myquery( $query );
	}

	protected function formatData( $data ) {
		$table = array ();
		if ( is_object( $data ) ) {
			while ( ( ( $row = $data->fetch_assoc() ) != false ) ) {
				$table[] = $row;
			}
		}

		return $table;
	}

	protected function formatFieldData( $field , $values = true ) {
		$format_field = '';
		if ( $values ) {
			$format = '`';
		} else {
			$format = "'";
		}
		if ( is_array( $field ) ) {
			for ( $i = 0; $i < count( $field ); $i ++ ) {
				$format_field .= $format . addslashes($field[ $i ]) . $format;
				if ( $i != ( count( $field ) - 1 ) ) {
					$format_field .= ', ';
				}
			}
		} elseif ( is_string( $field ) ) {
			if ( $field == '*' ) {
				$format_field = $field;
			} else {
				$format_field = $format . addslashes($field) . $format;
			}
		} else {
			$format_field = '';
		}

		return $format_field;
	}

	protected function formatAdd( $string , $add ) {
		if ( $string == 'WHERE' ) {
			$center = ' AND ';
		} else {
			$center = ', ';
		}
		if ( $this->corectString( $add ) ) {
			$format = ' ' . $string . ' ' . $add;
		} elseif ( is_array( $add ) && ! empty( $add ) ) {
			$format = ' ' . $string . ' ';
			for ( $i = 0; $i < count( $add ); $i ++ ) {
				$format .= $add[ $i ];
				if ( $i != ( count( $add ) - 1 ) ) {
					$format .= $center;
				}
			}
		} else {
			$format = '';
		}

		return $format;
	}

	protected function corectString( $string ) {
		if ( is_array( $string ) ) {
			return false;
		} elseif ( is_string( (string) $string ) && (string) $string != '' ) {
			return true;
		} else {
			return false;
		}
	}

	protected function NotNull( &$table ) {
		for ( $i = 0; $i < count( $table ); $i ++ ) {
			foreach ( $table[ $i ] as $key => $value ) {
				if ( $value == null ) {
					unset( $table[ $i ][ $key ] );
				}
			}
			unset( $table[ $i ][ 'topic' ] );
		}
	}

	protected function myquery( $query ) {
		return $this->mysql->query( $query );
	}
}

?>