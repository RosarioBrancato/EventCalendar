<?php

	include_once('../constant/Constants.php');
	include_once('../bo/PriceBracketBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');

	function getPriceBrackets() {
		$values = array();
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, price FROM tbl_price_bracket');
		if($stmt !== FALSE) {
			$stmt->execute();
			
			$id;
			$name;
			$price;
			
			$stmt->bind_result($id, $name, $price);
			
			while($stmt->fetch()) {
				$values[$id] = new PriceBracketBO($id, $name, $price);
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $values;
	}
	
	function getPriceBracket($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, price FROM tbl_price_bracket WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$name;
			$price;
			
			$stmt->bind_result($id, $name, $price);
			
			while($stmt->fetch()) {
				$bo = new PriceBracketBO($id, $name, $price);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
?>