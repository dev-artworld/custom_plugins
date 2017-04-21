<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AwFloorFields {
	/* variables */

	/* methods */
	public static function floor_supplier( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['supplier_'.$section_inner];

		// echo '<pre>';
		// print_r(AwComponents::$itemFirePlace);
		// 	echo '</pre>';
		?>
			<input type="text" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" data-roomID="<?php echo AwComponents::$roomTypeID;?>" data-areaID="<?php echo AwComponents::$areaTypeID;?>" name="supplier_<?php echo $section_inner;?>" class="supplier_<?php echo $section_inner;?>"placeholder="Enter the Tile Supplier, Manufacturer, Style Name and Number, Color Name and Number and / or Part Number" value="<?php echo $value;?>">
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_tile_types( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['tile_types_'.$section_inner];
		?>
			<?php  $tile_types_query = new WP_Query(array('post_type'=>'tile_types', 'post_status'=>'publish', 'posts_per_page'=>-1));
							if ( $tile_types_query->have_posts() ) : ?>
								<select class="tile_types_<?php echo $section_inner;?>"  data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" name="tile_types_<?php echo $section_inner;?>">
									<option> Enter the Tile Types</option>
									<?php while ( $tile_types_query->have_posts() ) : $tile_types_query->the_post(); $title = get_the_title( get_the_ID() );
									?>
									<?php if($value == $title){?>
										<option selected="selected" ><?php echo  the_title(); ?></option>
		            				<?php } 
		            				else{ ?> 
		            					<option><?php echo  the_title(); ?></option>
		            				<?php } ?>
									<?php endwhile; ?>
								</select>
							<?php endif; ?>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_width( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['width_'.$section_inner];
		?>
			<input type="text" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" placeholder="Tile Width (inches)" class="width_<?php echo $section_inner;?>" name="width_<?php echo $section_inner;?>" value="<?php echo $value;?>">
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_length( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['length_'.$section_inner];
		?>
			
		<input type="text" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="length_<?php echo $section_inner;?>" name="length_<?php echo $section_inner;?>" placeholder="Tile Length (inches)" class="length" value="<?php echo $value;?>" >
		
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_tile_height( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['tile_height_'.$section_inner];
		?>
			
		<?php  $tile_height_query = new WP_Query(array('post_type'=>'tile_height', 'post_status'=>'publish', 'posts_per_page'=>-1));
				if ( $tile_height_query->have_posts() ) : ?>
					<select  data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>"class="tile_height_<?php echo $section_inner;?>" name="tile_height_<?php echo $section_inner;?>" id="tile_height">
								<option> Tile Height</option>
						<?php while ( $tile_height_query->have_posts() ) : $tile_height_query->the_post();
						$title = get_the_title( get_the_ID() );
										?>
						   <?php if($value == $title){?>
								<option selected="selected" ><?php echo  the_title(); ?></option>
		            	   <?php } 
		            		else{ ?> 
		            			<option><?php echo  the_title(); ?></option>
		            		<?php } ?>
						<?php endwhile; ?>
					</select>
				<?php endif; ?>
		
		<?php                
		$output = ob_get_clean();
		return $output;
	}
	
	public static function floor_upload( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		//$height = AwComponents::$itemFirePlace['height_'.$section_inner];
		?>
			
		<div id="upload-drop" class="uk-placeholder">
						        <i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> <a class="uk-form-file">Select image<input id="upload-select" class="upload-select_<?php echo $section_inner;?>" type="file"></a>.
						    </div>
						    <div id="progressbar" class="uk-progress uk-hidden">
						        <div class="uk-progress-bar" style="width: 0%;">...</div>
						    </div>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_upload1( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		//$height = AwComponents::$itemFirePlace['height_'.$section_inner];
		?>
			
		<div id="upload-drop1" class="uk-placeholder">
						        <i class="uk-icon-cloud-upload uk-icon-medium uk-text-muted uk-margin-small-right"></i> <a class="uk-form-file">Select image<input id="upload-select1" class="upload-select1_<?php echo $section_inner;?>" type="file"></a>.
						    </div>
						    <div id="progressbar1" class="uk-progress uk-hidden">
						        <div class="uk-progress-bar" style="width: 0%;">...</div>
						    </div>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_brand( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['brand_'.$section_inner];
		?>
			
		<?php  global $wpdb;
							$grout_brand_query = $wpdb->get_results( "SELECT  DISTINCT `meta_value`  FROM `wp_postmeta` WHERE `meta_key` LIKE 'brand'" );  ?>
							<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" id="Brand_<?php echo $section_inner;?>" class="barand_<?php echo $section_inner;?> brand" name="brand_<?php echo $section_inner;?>"> <option>Select Grout Brand </option>
								<?php    //   [meta_id] [post_id]  [meta_key] [meta_value]
								 foreach($grout_brand_query as $grout_brand){    ?>

								<?php if($value == $grout_brand->meta_value){?>
									<option selected="selected" ><?php echo $grout_brand->meta_value;?></option>
		            	   		<?php } 
		            			else{ ?> 
		            				<option><?php echo $grout_brand->meta_value;?></option>
		            			<?php } ?>
								   
								<?php  }   ?>
							</select>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_serrries( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['serries_'.$section_inner];
		?>
			
				<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="serries" id="serrries_<?php echo $section_inner;?>" name="serries_<?php echo $section_inner;?>">
								<option>Select Grout Series</option>
						<?php if($value){?>

								<option selected="" ><?php echo $value;?></option>
						<?php } ?>
				</select>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_color( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['color_'.$section_inner];
		?>
			
			<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="color" id="color_<?php echo $section_inner;?>" name="color_<?php echo $section_inner;?>">
						<option>Select Grout Color</option>
					<?php if($value){?>

						<option selected="" ><?php echo $value;?></option>
					<?php } ?>
			</select>
		<?php                
		$output = ob_get_clean();
		return $output;
	}


	public static function floor_lay( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['lay_'.$section_inner];
		?>
			
		<?php  $lay_query = new WP_Query(array('post_type'=>'lay', 'post_status'=>'publish', 'posts_per_page'=>-1));
				if ( $lay_query->have_posts() ) : ?>
					<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="lay lay_<?php echo $section_inner;?>"name="lay_<?php echo $section_inner;?>"><option>Select Tile Pattern</option>
						<?php while ( $lay_query->have_posts() ) : $lay_query->the_post(); 
								$title = get_the_title( get_the_ID() );
										?>
						   <?php if($value == $title){?>
								<option selected="selected" ><?php echo  the_title(); ?></option>
		            	   <?php } 
		            		else{ ?> 
		            			<option><?php echo  the_title(); ?></option>
		            		<?php } ?>
						<?php endwhile; ?>
					</select>
				<?php endif; ?>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_direction( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['direction_'.$section_inner];
		?>
			
		<?php  /*$direction_query = new WP_Query(array('post_type'=>'direction', 'post_status'=>'publish', 'posts_per_page'=>-1));
							   if ( $direction_query->have_posts() ) : */
							   	?>
								<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="direction_<?php echo $section_inner;?>"name="direction_<?php echo $section_inner;?>"><option>Select Lay Direction </option>

								<?php 
								if($value){?>

								<option selected="" ><?php echo $value;?></option>
								<?php }

								/*while ( $direction_query->have_posts() ) : $direction_query->the_post(); ?>
										<option><?php echo  the_title(); ?></option>
								<?php endwhile; */?>
								</select>
							<?php /*endif;*/ ?>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_additional( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['additional_'.$section_inner];
		?>
			
		<input type="text" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" placeholder="Any additional instructions" class="additional_<?php echo $section_inner;?>" name="additional_<?php echo $section_inner;?>" value="<?php echo $value;?>">
		<?php                
		$output = ob_get_clean();
		return $output;
	}


	public static function floor_tile_direction( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['tile_direction_'.$section_inner];
		?>
			
		<?php  $door_query = new WP_Query(array('post_type'=>'door', 'post_status'=>'publish', 'posts_per_page'=>-1));
				if ( $door_query->have_posts() ) : ?>
					<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="pattern direction_<?php echo $section_inner;?>" name="tile_direction_<?php echo $section_inner;?>"><option>Select Tile Transition</option>
						<?php while ( $door_query->have_posts() ) : $door_query->the_post();
								 $title = get_the_title( get_the_ID() );
										?>
						   <?php if($value == $title){?>
								<option selected="selected" ><?php echo  the_title(); ?></option>
		            	   <?php } 
		            		else{ ?> 
		            			<option><?php echo  the_title(); ?></option>
		            		<?php } ?>
						<?php endwhile; ?>
					</select>
				<?php endif; ?>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_tile_transitions( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['transitions_'.$section_inner];
		?>
			
		<?php  /*$transitions_type_query = new WP_Query(array('post_type'=>'transitions_type', 'post_status'=>'publish', 'posts_per_page'=>-1));
							   if ( $transitions_type_query->have_posts() ) :*/ ?>
								<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" id="transitions_<?php echo $section_inner;?>" name="transitions_<?php echo $section_inner;?>" class="transitions_type"><option>Select Transition Types </option>
								<?php 
								if($value){?>

								<option selected="" ><?php echo $value;?></option>
								<?php }
								/*while ( $transitions_type_query->have_posts() ) : $transitions_type_query->the_post(); ?>
										<option id="<?php echo get_the_ID();?>"><?php echo  the_title(); ?></option>
								<?php endwhile;*/ ?>
								</select>
							<?php /*endif; */?>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_tile_transition_direction( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['transition_direction_'.$section_inner];
		?>
			
		<select data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="Direction" id="direction_<?php echo $section_inner;?>"name="transition_direction_<?php echo $section_inner;?>">
								<option>Select Transition</option>
							</select>
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_amount( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['amount_'.$section_inner];
		?>
			
		 <input type="text" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" placeholder="Amount in LF" class="amount_<?php echo $section_inner;?>"name="amount_<?php echo $section_inner;?>" value="<?php echo $value;?>">

		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_underlayment( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['underlayment_'.$section_inner];
		?>
			
		<?php  $underlayment = new WP_Query(array('post_type'=>'underlayment', 'post_status'=>'publish', 'posts_per_page'=>-1));
							   if ( $underlayment->have_posts() ) : ?>
							<select class="Underlayment" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" id="underlayment_<?php echo $section_inner;?>"name="underlayment_<?php echo $section_inner;?>">
								<option>Select underlayment </option>
							<?php while ( $underlayment->have_posts() ) : $underlayment->the_post();


								$title = get_the_title( get_the_ID() );
										?>
						   <?php if($value == $title){?>
								
								<option selected="selected" id="<?php echo get_the_ID();?>"><?php echo  the_title(); ?></option>
		            	   <?php } 
		            		else{ ?> 
		            			<option id="<?php echo get_the_ID();?>"><?php echo  the_title(); ?></option>
		            		<?php } ?>
										
								<?php endwhile; ?>
								</select>
							<?php endif; ?>
		 
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_thinest( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$value = AwComponents::$itemFirePlace['thinest_'.$section_inner];
		?>
			
			<select id="Thinest_<?php echo $section_inner;?>" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" name="thinest_<?php echo $section_inner;?>" class="thinset">
						<option>Select Thinset For underlayment </option>
					<?php if($value){?>

						<option selected="" ><?php echo $value;?></option>
					<?php } ?>
			</select>
				      	
		 
		<?php                
		$output = ob_get_clean();
		return $output;
	}

	public static function floor_thinesttop( $roomTypeID, $areaTypeID, $section_inner, $name = '', $value = '' ){
		ob_start();	
		$height = AwComponents::$itemFirePlace['thinesttop_'.$section_inner];
		?>
			
		<select id="Thinesttop_<?php echo $section_inner;?>" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" name="thinesttop_<?php echo $section_inner;?>" class="Thinesttop">
							<option>Select Thinset For Tile </option>
					<?php if($value){?>

						<option selected="" ><?php echo $value;?></option>
					<?php } ?>
		</select>
				      	
		 
		<?php                
		$output = ob_get_clean();
		return $output;
	}

}/* class ends here */

?>
