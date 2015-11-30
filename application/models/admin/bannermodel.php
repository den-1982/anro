<?php
/*
*	ADMIN
*/
class bannerModel extends CI_Model
{
	public function getBanner()
	{	
		$banners = $this->db->query('SELECT * FROM banner ORDER BY `order` ASC')->result();
		
		foreach ($banners as $k){
			$k->cache_bg = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->background);
			$k->cache = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->image);
			$k->cache2 = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->image2);
			$k->cache3 = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->image3);
			
			
			$description = $this->db->query('SELECT bd.*, 
													l.id AS language_id 
												FROM language l
												LEFT JOIN banner_description bd 
													ON l.id = bd.language_id 
													AND bd.banner_id = "'.$k->id.'"')->result();
			foreach ($description as $j){
				$k->description[$j->language_id] = $j;
			}
		}
		
		return $banners;
	}
	
	public function editBanner()
	{
		# UPDATE
		$this->db->query('DELETE FROM banner');
		if (isset($_POST['banner_id']['update'])) foreach ($_POST['banner_id']['update'] as $k=>$v){
			$id = abs((int)$k);
			
			$order		= isset($_POST['banner_order']['update'][$k])	? abs((int)$_POST['banner_order']['update'][$k]) : 0;
			$background = isset($_POST['background']['update'][$k])		? clean($_POST['background']['update'][$k], true, true) : '';
			$image 		= isset($_POST['image']['update'][$k])			? clean($_POST['image']['update'][$k], true, true) : '';
			$image2 	= isset($_POST['image2']['update'][$k])			? clean($_POST['image2']['update'][$k], true, true) : '';
			$image3 	= isset($_POST['image3']['update'][$k])			? clean($_POST['image3']['update'][$k], true, true) : '';
			
			// if ( ! $image) continue;
			
			# INSERT BANNER
			$this->db->query('INSERT INTO banner (id, background, image, image2, image3, `order`) 
								VALUES(
									"'.$id.'",
									"'.$background.'",
									"'.$image.'",
									"'.$image2.'",
									"'.$image3.'",
									"'.$order.'"
								)');
			
			if (isset($_POST['description']['update'][$k])) foreach ($_POST['description']['update'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['description']['update'][$k][$l]['h1'])		? clean($_POST['description']['update'][$k][$l]['h1'], false, true) : '';
				$h2			= isset($_POST['description']['update'][$k][$l]['h2'])		? clean($_POST['description']['update'][$k][$l]['h2'], false, true) : '';
				$text		= isset($_POST['description']['update'][$k][$l]['text']) 	? clean($_POST['description']['update'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO banner_description (banner_id, language_id, h1, h2, text) 
									VALUES(
										"'.$id.'",
										"'.$language_id.'",
										"'.$h1.'",
										"'.$h2.'",
										"'.$text.'"
									)');
				
			}
		}
		# INSERT
		if (isset($_POST['banner_id']['insert'])) foreach ($_POST['banner_id']['insert'] as $k=>$v){

			$order		= isset($_POST['banner_order']['insert'][$k])	? abs((int)$_POST['banner_order']['insert'][$k]) : 0;
			$background = isset($_POST['background']['insert'][$k])		? clean($_POST['background']['insert'][$k], true, true) : '';
			$image 		= isset($_POST['image']['insert'][$k])			? clean($_POST['image']['insert'][$k], true, true) : '';
			$image2 	= isset($_POST['image2']['insert'][$k])			? clean($_POST['image2']['insert'][$k], true, true) : '';
			$image3 	= isset($_POST['image3']['insert'][$k])			? clean($_POST['image3']['insert'][$k], true, true) : '';
			
			// if ( ! $image) continue;
			
			# INSERT NEW BANNER
			$this->db->query('INSERT INTO banner (background, image, image2, image3, `order`) 
								VALUES(
									"'.$background.'",
									"'.$image.'",
									"'.$image2.'",
									"'.$image3.'",
									"'.$order.'"
								)');
			
			# get id_banner
			$id = $this->db->query('SELECT MAX(id) AS id FROM banner')->row()->id;
			
			if (isset($_POST['description']['insert'][$k])) foreach ($_POST['description']['insert'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['description']['insert'][$k][$l]['h1'])		? clean($_POST['description']['insert'][$k][$l]['h1'], true, true) : '';
				$h2			= isset($_POST['description']['insert'][$k][$l]['h2'])		? clean($_POST['description']['insert'][$k][$l]['h2'], true, true) : '';
				$text		= isset($_POST['description']['insert'][$k][$l]['text']) 	? clean($_POST['description']['insert'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO banner_description (banner_id, language_id, h1, h2, text) 
									VALUES(
										"'.$id.'",
										"'.$language_id.'",
										"'.$h1.'",
										"'.$h2.'",
										"'.$text.'"
									)');
				
			}
		}
		
		return;
	}
}