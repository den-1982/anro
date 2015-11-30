<?php
/*
*	CLIENT
*/ 

class pageModel extends CI_Model
{
	public function getPageSystem($type = '', $lang = 'ua')
	{
		
		$type = clean($type, true, true);
		$page = $this->db->query('SELECT * FROM pages WHERE type = "'.$type.'"')->row();
		
		if ( ! $page) return array();
		
		# DESCRIPTION
		$page->description = $this->db->query('SELECT pd.*, 
														l.id AS language_id 
													FROM pages_description pd
													RIGHT JOIN language l ON pd.language_id = l.id
														AND pd.pages_id = "'.$page->id.'" 
												WHERE l.code = "'.$lang.'"')->row();
		
		
		# IMAGES
		$page->images = $this->db->query('SELECT * FROM pages_images WHERE pages_id = "'.$page->id.'" ORDER BY `order` ASC')->result();
		foreach ($page->images as $k){
			$k->description = $this->db->query('SELECT pid.*, 
														l.id AS language_id
													FROM pages_images_description pid 
													RIGHT JOIN language l ON pid.language_id = l.id
														AND pid.pages_images_id = "'.$k->id.'"
												WHERE l.code = "'.$lang.'"')->row();

		}

		
		return $page;
	}
	
}