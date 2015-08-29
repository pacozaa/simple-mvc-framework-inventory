<?php 
namespace Models;

use Core\Model;

class Auth extends Model{
	public function getHash($username){
		$data = $this->db->select("SELECT password FROM ".PREFIX."members WHERE username = :username",
			array(':username' => $username));
		return $data[0]->password;
	}
	public function getID($username){
		$data = $this->db->select("SELECT memberID FROM ".PREFIX."members WHERE username = :username",
			array(':username' => $username));
		return $data[0]->memberID;
	}
	public function update($data,$where){
		$this->db->update(PREFIX."members",$data,$where);
	}

}