<?php 
namespace Models;

use Core\Model;

class Index extends Model{	
	public function insertProduct($data){
		$id = $this->db->insert(PREFIX."product",$data['product']);
		$data['image']['product_id'] = $id;
		$this->db->insert(PREFIX."product_image",$data['image']);
	}

}