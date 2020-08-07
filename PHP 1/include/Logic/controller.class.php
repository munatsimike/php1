
<?php

class controller{
private $DAL;

public function __construct($DAL){
	$this->DAL = $DAL;
}

//check if  a user exists
	public function User_Exist($email){
		try {
			$result = $this->DAL->UserExist($email);
			return $result;

		} catch (\Exception $e) {
			echo $e->getMessage();
		}


	}
	// edit user account
		public function EditAccount_ ($editAcc){
				$result = $this->DAL->EditAccount($editAcc);
				return $result;

		 }


// register new user;
	public function Register_User($newAccount){
			$result = $this->DAL->RegisterUser($newAccount);
			return $result;
	}
	// save birthday
	public function Save_Birthday($addBirthday){
		try {
			$result = $this->DAL->SaveBirthday($addBirthday);
			return $result;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}


	}
	//edit birthday
	public function Edit_Birthday($birthday,$id){
			$result = $this->DAL->EditBirthday($birthday,$id);
			return $result;

	}
	// login
	public function login($userAccount){
		try {
			$result = $this->DAL->Login($userAccount);
		return $result;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}


	}
	//reset password
	public function Password_Reset($email, $password){
		try {
			$result = $this->DAL->PasswordReset($email, $password);
			return $result;
		} catch (\Exception $e) {
			echo $e->getMessage();
		}


}
// get birthdays for a logged in user
public function GetBirthdays($username){
	try {
		$result = $this->DAL->GetBirthdays($username);
	return $result;
	} catch (\Exception $e) {
		echo $e->getMessage();
	}


}
// get search results
public function Search($keyword){
	try {
		$result = $this->DAL->Search($keyword);
		return $result;
	} catch (\Exception $e) {
		echo $e->getMessage();
	}


}
// save email token
public function Store_Email_Token($email, $token,$selector, $expires){

		$result = $this->DAL->StoreEmailToken($email, $token, $selector,$expires);
		return $result;
}
// get saved token
public function Get_Token($selector){
	try {
		$result = $this->DAL->GetToken($selector);
		return $result;
	} catch (\Exception $e) {
		echo $e->getMessage();
	}


}
//delete token or birthday
public function DeleteBirthday_($id){
		$result = $this->DAL->DeleteBirthday($id);
		return $result;
}
// get all saved users
public function GetAllUsers_(){
		$result = $this->DAL->GetAllUsers();
		return $result;
}
// delete user account
public function DeleteAccount_($id){
		$result = $this->DAL->DeleteAccount($id);
		return $result;
}
// delete exisisting token associated with an email address
public function DeleteToken_($email){

		$result = $this->DAL->DeleteToken($email);
		return $result;
}
}
