<?php
Class loginFN{

	public function __construct(){
		
		try{
			
		$this->con=new PDO('pgsql:host=127.0.0.1;dbname=zmdata','vaprogram','P@55w0rd');
	
		}catch(PDOException $e){
			print($e->getMessage());
		}
	}

	function CheckUser($user){
		$user=pg_escape_string($user);
		$arr= array();
		//$uq = "select username,usergroup,uid from users where username='mmm'";
		
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
		$user=pg_escape_string($user);
		$pwd=pg_escape_string($pwd);

		$arr= array();
		$uq = "select username,usergroup,uid,password from users where username='".$user."'";
		//echo $uq;
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