<?php 
/* https://github.com/PHPAuth/PHPAuth/blob/master/Auth.php */

class Auth {
    
    protected $dbref;
    protected $site_key;
    protected $coast_bcrpyt;
    
    public function __construct(\PDO $db){
        $this->dbref = $db;
        $this->site_key = 123;
        $this->bcrypt_cost = 12;
    }
    
    public function logout($hash) {
        if (strlen($hash) != 40) {
            return false;
        }
        return $this->delete_session($hash);
    }
    
    public function get_hash($password) {
        //  return password_hash($password, 'sha256');
        //  Ab php 5.5     return password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->config->bcrypt_cost]);
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->bcrypt_cost]);
    }
    
    public function get_UID($email) {
        $query = $this->dbh->prepare("SELECT id FROM users WHERE email = ?");
        $query->execute(array($email));
        if(!$row = $query->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }
        return $row['id'];
    }
    
    
    protected function add_session($uid, $remember) {
        $ip = $this->get_ip();
        $user = $this->get_base_user($uid);
        
        if (!$user) {
            return false;
        }
        
        $data['hash'] = sha1($this->config->site_key . microtime());
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $this->delete_existing_sessions($uid);
        
        if ($remember == true) {
            $data['expire'] = date("Y-m-d H:i:s", 'cookie_remember');
            $data['expiretime'] = strtotime($data['expire']);
        } else {
            $data['expire'] = date("Y-m-d H:i:s", 'cookie_forget');
            $data['expiretime'] = 0;
        }
        $data['cookie_crc'] = sha1($data['hash'] . $this->site_key);
        $query = $this->dbh->prepare("INSERT INTO sessions (uid, hash, expiredate, ip, cookie_crc) VALUES (?, ?, ?, ?, ?)");
        if (!$query->execute(array($uid, $data['hash'], $data['expire'], $ip, $data['cookie_crc']))) {
            return false;
        }
        $data['expire'] = strtotime($data['expire']);
        return $data;
    }
    
    
    protected function delete_existing_sessions($uid) {
        $query = $this->dbh->prepare("DELETE FROM sessions WHERE uid = ?");
        $query->execute(array($uid));
        return $query->rowCount() == 1;
    }
    
    protected function delete_session($hash) {
        $query = $this->dbh->prepare("DELETE FROM sessions WHERE hash = ?");
        $query->execute(array($hash));
        return $query->rowCount() == 1;
    }
    
    public function get_sessionUID($hash)
    {
        $query = $this->dbh->prepare("SELECT uid FROM sessions WHERE hash = ?");
        $query->execute(array($hash));
		
		if (!$row = $query->fetch(\PDO::FETCH_ASSOC)) {
			return false;
		}
		return $row['uid'];
    }
    
    
    
    public function is_email_taken($email)
    {
        $query = $this->dbh->prepare("SELECT count(*) FROM users WHERE email = ?");
        $query->execute(array($email));
        if ($query->fetchColumn() == 0) {
            return false;
        }
        return true;
    }
    
    
    
    
    /* REwrite*/
    
    protected function add_user($email, $password /*, &$sendmail*/) {
        
        $return['error'] = true;
        $email = htmlentities(strtolower($email));
        $password = $this->get_hash($password);
        $query = $this->dbh->prepare("UPDATE {users} SET email = ?, password = ?");

        if (!$query->execute()) {
            $return['message'] = "system_error" . " #03";
            return $return;
        }

        /*
        $query = $this->dbh->prepare("INSERT INTO {users} (isactive) VALUES (0)");
        if (!$query->execute()) {
            $return['message'] = $this->lang["system_error"] . " #03";
            return $return;
        }
        $uid = $this->dbh->lastInsertId("{$this->config->users}_id_seq");
        $email = htmlentities(strtolower($email));
        $password = $this->getHash($password);
        
        $query = $this->dbh->prepare("UPDATE {$this->config->users} SET email = ?, password = ? {$setParams} WHERE id = ?");
        $bindParams = array_values(array_merge(array($email, $password, $isactive), $params, array($uid)));
        
        if (!$query->execute($bindParams)) {
            $query = $this->dbh->prepare("DELETE FROM {$this->config->table_users} WHERE id = ?");
            $query->execute(array($uid));
            $return['message'] = $this->lang["system_error"] . " #04";
            return $return;
        }
        */
        
        $return['error'] = false;
        return $return;
    }
    
    
    
    
    

    protected function get_base_user($uid) {
        $query = $this->dbh->prepare("SELECT email, password FROM { users } WHERE id = ?");
        $query->execute(array($uid));
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        }
        $data['uid'] = $uid;
        return $data;
    }

    public function delete_user($uid, $password, $captcha = NULL) {
        
        $return['error'] = true;

        $user = $this->get_base_user($uid);
        if (!password_verify($password, $user['password'])) {
            $return['message'] = "password_incorrect";
            return $return;
        }
        
        $query = $this->dbh->prepare("DELETE FROM users WHERE id = ?");
        if (!$query->execute(array($uid))) {
            $return['message'] = "system_error";
            return $return;
        }
        
        $query = $this->dbh->prepare("DELETE FROM {$this->config->sessions} WHERE uid = ?");
        if (!$query->execute(array($uid))) {
            $return['message'] = "system_error" . " #06";
            return $return;
        }
        
        $return['error'] = false;
        $return['message'] = "account deleted";
        return $return;
    }
    


    
    public function check_session($hash) {
        $ip = $this->getIp();

        if (strlen($hash) != 40) {
            return false;
        }
        
        $query = $this->dbh->prepare("SELECT id, uid, expiredate, ip, cookie_crc FROM sessions WHERE hash = ?");
        $query->execute(array($hash));
		if (!$row = $query->fetch(\PDO::FETCH_ASSOC)) {
			return false;
		}
        $sid = $row['id'];
        $uid = $row['uid'];
        $expiredate = strtotime($row['expiredate']);
        $currentdate = strtotime(date("Y-m-d H:i:s"));
        $db_ip = $row['ip'];
        $db_cookie = $row['cookie_crc'];
        if ($currentdate > $expiredate) {
            $this->delete_existing_sessions($uid);
            return false;
        }
        if ($ip != $db_ip) {
            return false;
        }
        if ($db_cookie == sha1($hash . $this->config->site_key)) {
            return true;
        }
        return false;
    }
    



    
    public function is_logged() {
        return (isset($_COOKIE['shoenecookeie']) && $this->check_session($_COOKIE['shoenecookeie']));
    }

    protected function get_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
           return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
           return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function get_session_hash(){
        return $_COOKIE['shoenecookeie'];
    }

    public function compare_passwords($user_id, $password_for_check)
    {
        $query = $this->dbh->prepare("SELECT password FROM users WHERE id = ?");
        $query->execute(array($user_id));
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        }
        return password_verify($password_for_check, $data['password']);
    }

}

/*
$options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
echo password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options)."\n";
*/

/* password_verify() */