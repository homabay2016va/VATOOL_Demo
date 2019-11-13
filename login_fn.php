<?php
Class loginFN{

	public function __construct(){
		
		try{
			
		$this->con=new PDO('pgsql:host=127.0.0.1;dbname=demova','demova','demova');
			
		}catch(PDOException $e){
			print($e->getMessage());
		}
	}

	function CheckUser($user){
		$arr= array();
		$uq = "select username,usergroup,uid from users where username='".$user."'";
		$res = $this->con->query($uq);
		
		if(is_array($res) || is_object($res)){
			foreach($res as $row){
				
				array_push($arr,$row['username']);
				array_push($arr,$row['usergroup']);
				array_push($arr,$row['uid']);
			}
		}	

		return $arr;
	}

	function login($user,$pwd){
		$arr= array();
		$uq = "select username,usergroup,uid,password from users where username='".$user."'";
		$res = $this->con->query($uq);
		
		if(is_array($res) || is_object($res)){
			foreach($res as $row){
				if(password_verify($pwd, $row['password'])){
					array_push($arr,$row['username']);
					array_push($arr,$row['usergroup']);
					array_push($arr,$row['uid']);
				}		
			}
		}	

		return $arr;
	}


}	


?>