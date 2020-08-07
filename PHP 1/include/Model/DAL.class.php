<?php

class DAL{

	private	$conn;
	public function __construct(){
		$instance = Config::getInstance(); // create an instance of the config class;
		$this->conn = $instance->getConnection(); // get database connection
	}

	// get a specific user from the database;
	private function Get_user($email){
		$sql = "SELECT email, password FROM users WHERE email = ?";
			try{
		$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("s", $param_email);
				$param_email= $email;
				if($stmt->execute()){
						$stmt->store_result();
						return $stmt;
							}
						}catch(\Exception $e){
					echo "failed to conncet to database";
						}
					}

	//check if a user exists;
		public function UserExist($email){
			// Prepare a select statement
			$query_result = $this->Get_user($email);
			if(!$query_result){
				throw new \Exception("Error Processing Request");

			}
       		if($query_result->num_rows == 1)
					{
						return true; // user exist;
					}else {
						return false; // user does not exist;
					}
	}
// get username id
	private function GetUserId($username){
		$sql = "SELECT id from users WHERE email = '$username'";
		try{
		$result = $this->QueryDB($sql);
		if($result->num_rows == 1){
			 $id = $result->fetch_assoc();
			  return $id['id'];
		}
	}catch(Exception $e	){
		echo $e->getMessage();
	}
}
// save birthday
	public function SaveBirthday($birthday){
		// get user id  (foreign key);
		$id = $this->GetUserId($birthday->username);
		$sql = "INSERT INTO birthdays (name,surname, relationship, dob, owner) VALUES (?, ?, ?, ?, ?)";
		if($stmt = $this->conn->prepare($sql)){
			try {
				$stmt->bind_param("sssss", $param_name, $param_surname, $param_relationship, $param_dob,$param_owner);
				$param_name = "$birthday->name";
				$param_surname = "$birthday->surname";
				$param_relationship = "$birthday->relationship";
				$param_dob = "$birthday->dob";
				$param_owner = $id;
			} catch (\Exception $e) {
				echo $e->getMessage();
			}


				if($stmt->execute()){
					return true; // user successfuly saved to the database
				} else{
					return false; // failed to save
				}

	}
}
// edit birthday
public function EditBirthday($birthday,$id){
	$sql = "UPDATE birthdays SET name=?,surname=?, relationship=?, dob=? WHERE id=?";
	if($stmt = $this->conn->prepare($sql)){
		try {
			$stmt->bind_param("sssss", $param_name, $param_surname, $param_relationship, $param_dob, $param_id);
			$param_name = "$birthday->name";
			$param_surname = "$birthday->surname";
			$param_relationship = "$birthday->relationship";
			$param_dob = "$birthday->dob";
			$param_id = $id;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
			if($stmt->execute()){
				return true; // user successfuly saved to the database
			} else{
				return false; // failed to save
			}
}
}
public function EditAccount($editAcc){
	$sql = "UPDATE users SET name=?,email=? WHERE id=?";
			if($stmt = $this->conn->prepare($sql)){
				try {
					$stmt->bind_param("sss", $param_name, $param_email, $param_id);
					$param_name = "$editAcc->name";
					$param_email = "$editAcc->email";
					$param_id = $editAcc->id;
				} catch (\Exception $e) {
					echo $e->getMessage();
				}


					if($stmt->execute()){
						return true;
					}else{
						return false;
					}
}

}
//insert email,name password into the database
	public function RegisterUser($newAccount){
		$sql = "INSERT INTO users (email,name, password,userType) VALUES (?, ?, ?,?)";
		if($stmt = $this->conn->prepare($sql)){
			try {
				$stmt->bind_param("ssss", $param_email, $param_name, $param_password,$param_userType);
				$param_email = $newAccount->email;
				$param_name = $newAccount->name;
				$param_userType = $newAccount->userType;
				//encrypt the password;
				$param_password = password_hash($newAccount->password, PASSWORD_DEFAULT);
			} catch (\Exception $e) {
				echo $e->getMessage();
			}

				if($stmt->execute()){
							return true;// user successfuly saved to the database
						}else{
							return false;
						}
					}
	}



		// connect to database and make a query
  	private function QueryDB($sql){
		$result = $this->conn->query($sql);
		if(!$result){
			throw new \Exception("Error Processing Request");
		}
		return $result;

  	}

		// get all user accounts
		public function GetAllUsers(){
			$sql = "SELECT users.id, users.email, users.name,users.password, users.registration_date, type_of_user.userType FROM users JOIN type_of_user ON users.userType=type_of_user.id";
			try {
				$result = $this->QueryDB($sql);
				return $result;
			} catch (\Exception $e) {
				$e->getMessage();
			}
		}

// delete  birthday
	public function DeleteBirthday($id){
		$sql = "DELETE FROM birthdays WHERE id = $id";
		try {
			$result = $this->QueryDB($sql);
			return $result;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}



	}

	public function DeleteToken($email){
	$sql = "DELETE FROM pass_reset WHERE email = '$email'";
	try {
		$result = $this->QueryDB($sql);
		return $result;
	} catch (\Exception $e) {
		echo $e->getMessage();
	}


}
public function DeleteAccount($id){
$sql = "DELETE FROM users WHERE id = $id";
try {
	$result = $this->QueryDB($sql);
	return $result;
} catch (\Exception $e) {
	echo $e->getMessage();
}


}

// save token and email to password reset table
public function StoreEmailToken($email, $token, $selector, $expires){
	$sql = "INSERT INTO pass_reset (email,token,selector,expires) VALUES (?, ?, ?, ?)";
	if($stmt = $this->conn->prepare($sql)){
		try {
			$stmt->bind_param("ssss", $param_email, $param_token, $param_selector, $param_expires);
			$param_email = $email;
			//encrypt token;
			$param_token= password_hash($token, PASSWORD_DEFAULT);
			$param_selector = $selector;
			$param_expires = $expires;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
			if($stmt->execute()){
				return true; // token and email saved to the database
			} else{
				return false; // did not save
			}

}
}

// get row associated with a specific token;
public function GetToken($selector){
			$sql = "SELECT email, token, selector FROM pass_reset WHERE selector = ? ";
			try {
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("s", $param_selector);
				$param_selector = $selector;
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows == 1){
					$row = $result->fetch_assoc();
						 return $row;
				}else{
					return false; // row not found
				}
			} catch (\Exception $e) {
				echo $e->getMessage();
			}



				}


public function Login($userAccount){
	$query_result = $this->Get_user($userAccount->email); // check if user exists
					if($query_result->num_rows == 1){
							// Bind result variables
							$query_result->bind_result($userAccount->email, $hashed_password);
							if($query_result->fetch()){
									if(password_verify($userAccount->password, $hashed_password)){
											$profile = $this->GetProfile($userAccount->email);
											if(!$profile){
												throw new \Exception("Error Processing Request");

											}
											return $profile;
									} else{
										return false; // login failure wrong password;
										}
							}
					}
					}

			public function PasswordReset($username, $new_password){
				//check if user exist;
				$query_result = $this->Get_user($username);
				if($query_result->num_rows == 1){
					 // if user exist update row
				$sql = "UPDATE users SET `password` = ? WHERE email = ?";
        if($stmt = $this->conn->prepare($sql)){
					try {
						// Bind variables to the prepared statement as parameters
						$stmt->bind_param("ss", $param_password, $param_username);
						$param_password = password_hash($new_password, PASSWORD_DEFAULT);
						$param_username = $username;
					} catch (\Exception $e) {
						echo $e->getMessage();
					}
            if($stmt->execute()){
                return true; // password changed;
            } else{
							return false; // password change failed;
            }
        }

    }else{
			return false; //username not found;
		}
}
// get result for passed sql statement
	private function GetResult($sql){
		try {
			$results = $this->QueryDB($sql);
		  $numRows = $results->num_rows;
			if($numRows > 0){
				while($row = $results->fetch_assoc()){
				$result[] = $row;
				}
				return $result;
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
		}


	}
// get user profile when login is successful
private function GetProfile($email){
	// join users and usertype table
	$sql = "SELECT users.id, users.email, users.name,users.password, users.registration_date, type_of_user.userType FROM users JOIN type_of_user ON users.userType=type_of_user.id WHERE email = '$email'"; // get all registerd users
	if($result = $this->GetResult($sql)){
		return $result;

	}else{
		return false;
	}

}
// get all saved birthdays;
public function GetBirthdays($username){
	$id = $this->GetUserId($username);
	$sql ="SELECT id, name, surname, relationship, dob FROM birthdays WHERE owner = $id";
	if($result = $this->GetResult($sql)){
		return $result;

	}else{
		return false;
	}

}
// get search results
public function Search($keyword){
$sql="SELECT  users.id, users.email,users.name, users.password, users.registration_date, type_of_user.userType FROM users JOIN type_of_user ON users.userType=type_of_user.id WHERE email LIKE '%" . $keyword .  "%' OR name LIKE '%" . $keyword .  "%'";
if($result = $this->GetResult($sql)){
	return $result;

}
 return false;
}

	}
