<?php
/*
*	CLIENT
*/
class materialsModel extends CI_Model
{
	public function getMaterials($lang = 'ua')
	{
		$materials = $this->db->query('SELECT * FROM materials WHERE visibility = 1 ORDER BY `order` ASC')->result();
		
		if ( ! $materials) return array();

		foreach ($materials as $material){
			# DESCRIPTION
			$material->description = $this->db->query('SELECT md.*, 
																l.id AS language_id 
															FROM materials_description md
															RIGHT JOIN language l ON md.language_id = l.id
																AND md.materials_id = "'.$material->id.'" 
														WHERE l.code = "'.$lang.'"')->row();
			
			# IMAGES
			$material->images = $this->db->query('SELECT * FROM materials_images WHERE materials_id = "'.$material->id.'" ORDER BY `order` ASC')->result();
			foreach ($material->images as $image){
				$image->description = $this->db->query('SELECT mid.*, 
															l.id AS language_id
														FROM materials_images_description mid 
														RIGHT JOIN language l ON mid.language_id = l.id
															AND mid.materials_images_id = "'.$image->id.'"
													WHERE l.code = "'.$lang.'"')->row();

			}
		}
		
		return $materials;
	}

}