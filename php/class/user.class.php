<?php

class User extends Database
{
    public $db = null;

    public function __construct()
    {
        $this->db = self::instance(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    }


    public function registerUser($username, $password, $repeatpw, $email)
    {
    	/*
    		Before registering the user, we will do some checks to prevent dupes etc.
    		We set the password algo to bcrypt, with 8 rounds. This is really high security.
    	*/

    	if($password != $repeatpw)
    	{
    		return false;
    	}

    	if(!$this->validateEmail($email))
    	{
    		return false;
    	}

    	if(!$this->validatePassword($password))
    	{
    		return false;
    	}
	
	    if(!$this->validateUsername($username))
	    {
	    	return false;
	    }
	    		
		$password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 8));

		$this->insert("INSERT INTO `users` (`id`, `username`, `password`, `email`, `reg_date`, `reg_ip`) VALUES (NULL, :username, :password, :email, CURRENT_TIMESTAMP, :ip);", array(":email" => $email, ":username" => $username, ":password" => $password, ":ip" => $_SERVER['REMOTE_ADDR']));

		return true;

	    	
    }

    public function authUser($username, $password)
    {
    	if(!$this->validatePassword($password))
    	{
    		return false;
    	}

    	if(!$this->validateUsername($username, 1))
    	{
    		return false;
    	}

    	$result = $this->Query("SELECT id, password, username FROM `users` WHERE `username` = :username", array(":username" => $username));

    	if(password_verify($password, $result['password']))
    	{
    		$this->logLogin($result['id']);
    		$_SESSION['id'] = $result['id'];
    		return true;
    	}

    	return false;
    }


    public function getData($id)
    {

    	$result = $this->Query("SELECT * FROM `users` WHERE `id` = :id LIMIT 1", array(":id" => $id));
    	
    	if(isset($result['password']))
    	{
    		unset($result['password']);
    	}

    	return $result;

    }

    private function validateUsername($username, $check = 0)
    {
    	/*
    		0 == Register Check
    		1 == Regex Check / Login

			We don't want duplicate usernames, so we added this check!
			* Validates the username using a regex.
			* Checks for duplicates

			Regex Check
			* Has to start with a letter.
			* Has to be between between 5 & 32 characters.
			* Letters & Numbers only.
    	*/


		if(!preg_match('/^[A-Za-z][A-Za-z0-9]{4,31}$/', $username))
		{
			return false;
		}
		if($check == 0)
		{
			if(empty($this->Query("SELECT id FROM users WHERE username=:username LIMIT 1", ["username" => $username])))
			{
				return true;
			}
			return false;
		}

		return true;

    }

    private function validatePassword($password)
    {
		/*
			We require complex passwords, for users own safety.
			* contain at least (1) upper case letter
			* contain at least (1) lower case letter
			* contain at least (1) number or special character
			* contain at least (8) characters in length
		*/

    	if(preg_match('/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/', $password))
    	{
    		return true;
    	}

    	return false;

    }


    public function validateEmail($email)
    {
		/*
			There are three checks:
			* Uses PHP's default filter/regex
			* Checks if the domain contains a dns record
			* Checks for duplicates in database
		*/

    	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    	{
    		return false;
    	}

		if(!checkdnsrr(explode("@", $email, 2)[1]))
		{
			return false;
		}

		if(empty($this->Query("SELECT id FROM users WHERE email=:email LIMIT 1", ["email" => $email])))
		{
			return true;
		}

		return false;

    }


    public static function logOut()
    {
		session_start();
		unset($_SESSION['id']);
    	return header("Location: login.php");
    }


    private function logLogin($uid)
    {
    	$search = $this->Query("SELECT id FROM `login_logs` WHERE `ipaddr` = :ip AND `log_date` = CURDATE() AND `uid` = :uid LIMIT 1", array(":ip" => $_SERVER['REMOTE_ADDR'], ":uid" => $uid));

    	if(!empty($search))
    	{
    		$this->insert("UPDATE `login_logs` SET `used` = 1 + used WHERE `login_logs`.`id` = :id", array(":id" => $search['id']));
    	}
    	else
    	{
    		$this->insert("INSERT INTO `login_logs` (`id`, `uid`, `ipaddr`, `log_date`, `used`) VALUES (NULL, :uid, :ip, CURDATE(), 1);", array(":uid" => $uid, ":ip" => $_SERVER['REMOTE_ADDR']));
    	}
    }

}