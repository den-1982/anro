<?php
/*
*	CLIENT
*/
class bannerModel extends CI_Model
{
	public function getBanners($lang = 'ua')
	{	
		$banners = $this->db->query('SELECT * FROM banner ORDER BY `order` ASC')->result();
		
		foreach ($banners as $k){
			$k->description = $this->db->query('SELECT bd.*, 
													l.id AS language_id 
												FROM banner_description bd
												RIGHT JOIN language l ON l.id = bd.language_id 
													AND bd.banner_id = "'.$k->id.'"
												WHERE l.code = "'.$lang.'"')->row();
		}
		
		return $banners;
	}

}