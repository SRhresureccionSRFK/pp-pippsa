	<?php

class DB{
	
	public static $dbms;

	public static function runDB(){
		$config = Register::$config;
		try {
		// Configura mysqli para lanzar excepciones en caso de error
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			self::$dbms = new mysqli(
				$config["user_db_host"], 
				$config["user_db"], 
				$config["user_db_password"], 
				$config["user_db_schema"],
				$config["port_db_port"],
			);
		} catch (mysqli_sql_exception $e) {
			echo "Error de conexión a la BD. Detalles: " . $e->getMessage();
		}
	}
	
	public static function get($model, $properties, $conditions){
		
		$cond = ($conditions=="")? 0: $conditions;
		$res = [];
		
		$query = "SELECT $properties FROM  $model WHERE $cond ";

		try{
			$rst = self::$dbms->query( $query );
			if( $rst->num_rows > 0 ){
				while( $row = $rst->fetch_assoc() ){
					$res[] = $row;
				}	
			}		
		}
		catch(Exception $e){
			exit;
		}
		
		return $res;
	}
	
	public static function insert($model,$properties){
		$query = "INSERT INTO $model SET $properties ";
		$rst = self::$dbms->query( $query );
		return self::$dbms->insert_id;
	}
	
	public static function update($model, $properties, $conditions){
		
		$query = "UPDATE $model SET $properties WHERE $conditions ";
		self::$dbms->query( $query );
	}
		
	public static function delete($model,$conditions){
		$query = "DELETE FROM $model WHERE $conditions";
		self::$dbms->query( $query );
	}
}
