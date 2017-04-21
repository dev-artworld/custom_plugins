<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AwComponents {

	public static $selectedoption;
	public static $roomTypeID;
	public static $areaTypeID;
	public static $sectionTypeID;

	/*Input variables*/
	public static $roomTypeValue;

	public static $areaTypeValue;

	public static $itemFirePlace;

	public static $sectionsData;




	public static function getMainSection(){
		$uniqid = uniqid();
		$rand 	= 'aw_'.$uniqid;

		self::$roomTypeID = $rand;
		ob_start();
		?>
			<div class="main-section">
				<div class="aw-toolbar">
					<input type="hidden" name="roomTypeID" value="<?php echo $rand;?>" />
					<a href="#" class="uk-button aw-toggle-btn" title="Collapse" data-uk-toggle="{target:'#<?php echo $rand;?>', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}"><i class="uk-icon-chevron-down"></i></a>
					<!-- <a href="#" class="uk-button add-area-btn" title="Add Area"><i class="uk-icon-plus"></i></a> -->
					<!-- <a href="#" class="uk-button close-btn" title="close"><i class="uk-icon-times"></i></a> -->
					<a href="#" class="uk-button add-area-btn" title="Add an Area to this room"><i class="uk-icon-plus"></i></a>
					<a href="#" class="uk-button close-btn" title="Remove Room"><i class="uk-icon-times"></i></a>
				</div>
				<div class="form-wrapper">
					<div class="form-wrapper-inner" id="<?php echo $rand;?>" aria-hidden="false">
						<!-- inner section comes here-->
						<?php echo AwComponents::getInnerMainSection();?>
					</div>
				</div>
			</div> <!-- main-section -->
		<?php
		$output = ob_get_clean();
		return $output;
	}

	/*get inner-main-section*/
	public static function getInnerMainSection(){
		$uniqid 	= uniqid();
		$area_inner = 'aw_inner_'.$uniqid;

		self::$areaTypeID = $area_inner;
		ob_start();
		?>
			<div class="form-wrapper-internal-collapse" style="margin-bottom: 5px;">
				<h3 class="inner-collapse-bar">
					<input type="hidden" name="areaTypeID" value="<?php echo $area_inner;?>" />
					<a href="#" class="btn-2 area-close" title="Remove Area"><i class="uk-icon-times"></i></a>
					<a href="#" class="btn-1 aw-area-toggle-btn" title="Collapse" data-uk-toggle="{target:'#<?php echo $area_inner;?>', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}"><i class="uk-icon-chevron-down"></i></a>
				</h3>
				<div class="inner-main-section" id="<?php echo $area_inner;?>" aria-hidden="false">
					<div class="row-wrapper">
				    	<div class="col-2">
				            <div class="select-room-row">
				                   <?php echo AwComponents::getRoomType(); ?>
				            </div>
				        </div>
				        <div class="col-2">
				            <div class="select-room-row area-select-section">
				            	 <?php echo AwComponents::getArea('floor'); ?>
				            </div>
				        </div>
				        <div class="clear"></div>
				    </div>
			    </div>
		    </div>
		<?php
		$output = ob_get_clean();
		return $output;
	}			

	public static function getRoomType(){
		
		$roomTypeValue = self::$roomTypeValue;

		$array_room 	= array();
		$room_query 	= new WP_Query(array('post_type' => 'room', 'post_status' => 'publish', 'posts_per_page' => -1 ));

		if ( $room_query->have_posts() ) :
			while ( $room_query->have_posts() ) : $room_query->the_post();
				$post_id              = get_the_ID();
				$key_1_value          = get_post_meta($post_id, 'arrange_this_room_', true );
				$array_room[$post_id] = $key_1_value;
			endwhile;
		endif;
		asort($array_room);
		array_filter($array_room);


		$html = '';
		$html .= '<select name="room" class="room_types" id="room_select_type">';
		$html .= 	'<option>Select Room</option>';
			    foreach($array_room as $key => $room) {
					$post_id        = $key;
					$sorted_order   = $room;
					$title 			=  get_the_title( $post_id );

					if($roomTypeValue == $title){

						$html .= 	'<option selected id="room_type_id_'.$post_id.'">'.$title.'</option>';
					}

					elseif(  $title == self::$selectedoption){
        				$html .= 	'<option selected id="room_type_id_'.$post_id.'">'.$title.'</option>';
					}else{
						$html .= 	'<option id="room_type_id_'.$post_id.'">'.$title.'</option>';
					}

				}
		$html .= '</select>';

		return $html;
	}

	public static function getArea(){

		$areaTypeValue = self::$areaTypeValue;
		$area_query = new WP_Query(array('post_type'=>'area', 'post_status'=>'publish', 'posts_per_page'=>-1));

		$html = '';
		$html .= '<select name="area" class="selected_area" id="area_select_type">';
		$html .= 	'<option>Select Area</option>';
		if ( $area_query->have_posts() ) :
			while ( $area_query->have_posts() ) :
				$area_query->the_post();
				if($areaTypeValue == get_the_title()){
					$html .= '<option selected id="room_type_id_'.get_the_ID().'">'.get_the_title().'</option>';
				}
				else{
				$html .= '<option id="room_type_id_'.get_the_ID().'">'.get_the_title().'</option>';
	
				}
				
			endwhile;
        endif;
		$html .= '</select>';

		return $html;
	}

	public static function innerFloorSection( $sectionsData = ''){	

		if(!empty($sectionsData)) {
			
			$roomTypeID 	= $sectionsData->sectionMeta[0]->roomDID;
			$areaTypeID     = $sectionsData->sectionMeta[0]->areaDID;
			$section_inner 	= $sectionsData->sectionMeta[0]->sectionDID;
		}else {
			$roomTypeID =$_POST['roomID'];
			$areaTypeID =$_POST['areaID'];	
			$uniqid = uniqid();
			$section_inner 	= 'aw_inner_section_'.$uniqid;
		}
	
		$section = AwComponents::$itemFirePlace['section_'.$section_inner];
		$square = AwComponents::$itemFirePlace['square_'.$section_inner];

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
			
				<div class="row-wrapper">
					<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
					<div class="col-3">
						<div class="select-room-row">
							<?php  $section_query = new WP_Query(array('post_type'=>'section', 'post_status'=>'publish', 'posts_per_page'=>-1));
							   if ( $section_query->have_posts() ) : ?>
								<select class="section" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" id="section_<?php echo $section_inner;?>" name="section_<?php echo $section_inner;?>"><option>Select Section</option>
								<?php while ( $section_query->have_posts() ) : $section_query->the_post(); 
									$title = get_the_title( get_the_ID() );
								?>
								<?php if($section == $title){?>

									<option selected="" ><?php echo  the_title(); ?></option>

								<?php } else{?>
									<option><?php echo  the_title(); ?></option>
								
								<?php } ?>		
								<?php endwhile; ?>
								</select>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
							<input type="text" placeholder="Square Feet" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="square" id="square_<?php echo $section_inner;?>" name="square_<?php echo $section_inner;?>" value="<?php echo $square ;?>">
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
				      		<a type="button" class="uk-button uk-button-primary add_section">Add Section</a>
				      		<a type="button" class="uk-button uk-button-danger remove_section">Remove Section</a>
				      	</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- first  row ends-->

			
			
		<?php
		$output = ob_get_clean();
		return $output;
	
	}

	public static function getFloorHeader(){
		
		$html = '';
		if(!empty(self::$sectionsData)) {
				
			// echo '<pre>';
			// print_r(self::$sectionsData);
			// echo '</pre>';
			$number = 1;
			foreach (self::$sectionsData as $key => $value) {

				// if (strpos($value->sectionMeta[0]->section_key, 'section') == true) {
				// 		$html .= '<div class="area-wrapper">';
				//     	$html .= self::innerFloorSection( $value);
				// 	}
				// else{
						
						
				// 		$html .= self::getInnerFloor($value);	

				// 		$html .= '</div>';

				// 	}


				if(($number % 2) != 0){
					$html .= '<div class="area-wrapper">';
				    $html .= self::innerFloorSection( $value);
					
				}else{
					
				    $html .= self::getInnerFloor($value);	

					$html .= '</div>';
				}


				$number++;
				
			}

				$html .= '</div>';
			return $html;

		}else {
			$roomTypeID =$_POST['roomID'];
			$areaTypeID =$_POST['areaID'];	
			$uniqid = uniqid();
			$section_inner 	= 'aw_inner_section_'.$uniqid;
		}		

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
			<div class="area-wrapper">
				<div class="row-wrapper">
					<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
					<div class="col-3">
						<div class="select-room-row">
							<?php  $section_query = new WP_Query(array('post_type'=>'section', 'post_status'=>'publish', 'posts_per_page'=>-1));
							   if ( $section_query->have_posts() ) : ?>
								<select class="section" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" id="section_<?php echo $section_inner;?>" name="section_<?php echo $section_inner;?>"><option>Select Section</option>
								<?php while ( $section_query->have_posts() ) : $section_query->the_post(); ?>
										<option><?php echo  the_title(); ?></option>
								<?php endwhile; ?>
								</select>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
							<input type="text" placeholder="Square Feet" data-section="<?php echo $section_inner;?>" data-room="<?php echo $roomTypeID;?>" data-area="<?php echo $areaTypeID;?>" class="square" id="square_<?php echo $section_inner;?>" name="square_<?php echo $section_inner;?>">
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
				      		<a type="button" class="uk-button uk-button-primary add_section">Add Section</a>
				      		<a type="button" class="uk-button uk-button-danger remove_section">Remove Section</a>
				      	</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- first  row ends-->
			</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	public static function getInnerFloor($sectionsData){
		
		if(!empty($sectionsData)){

		$roomTypeID 	= $sectionsData->sectionMeta[0]->roomDID;
		$areaTypeID     = $sectionsData->sectionMeta[0]->areaDID;
		$section_inner 	= $sectionsData->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
			<div class="floor-wrapper">
				<!-- second row start-->
				<div class="row-wrapper">
					<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
					<div class="col-1-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_supplier($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-1-9">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_types($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- second row ends-->
				<!-- Third row start-->
				<div class="row-wrapper">
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_width($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_length($roomTypeID, $areaTypeID, $section_inner);?>
					   	
							
						</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_height($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_upload($roomTypeID, $areaTypeID, $section_inner);?>
					   </div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_upload1($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- Third row ends-->
				<!-- Fourth row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_brand($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_serrries($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_color($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- Fourth row ends-->

				<!-- Fifth  row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_lay($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_direction($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_additional($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- Fifth  row ends-->

				<!-- Sixth  row start-->
				<div class="row-wrapper">
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_direction($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_transitions($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_transition_direction($roomTypeID, $areaTypeID, $section_inner);?>
						
							
				      	</div>
				   	</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_amount($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- Sixth  row ends-->
				<!-- seventh  row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_underlayment($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_thinest($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
				   	<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_thinesttop($roomTypeID, $areaTypeID, $section_inner);?>
							
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- seventh  row ends-->
			</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	public static function getFloor(){
		
		if(!empty(self::$sectionsData)){

		$roomTypeID 	= self::$sectionsData[0]->sectionMeta[0]->roomDID;
		$areaTypeID     = self::$sectionsData[0]->sectionMeta[0]->areaDID;
		$section_inner 	= self::$sectionsData[0]->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
			<div class="floor-wrapper">
				<!-- second row start-->
				<div class="row-wrapper">
					<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
					<div class="col-1-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_supplier($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-1-9">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_types($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- second row ends-->
				<!-- Third row start-->
				<div class="row-wrapper">
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_width($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_length($roomTypeID, $areaTypeID, $section_inner);?>
					   	
							
						</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_height($roomTypeID, $areaTypeID, $section_inner);?>
					   	</div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_upload($roomTypeID, $areaTypeID, $section_inner);?>
					   </div>
					</div>
					<div class="col-5">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_upload1($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- Third row ends-->
				<!-- Fourth row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_brand($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_serrries($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_color($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- Fourth row ends-->

				<!-- Fifth  row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_lay($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_direction($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_additional($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- Fifth  row ends-->

				<!-- Sixth  row start-->
				<div class="row-wrapper">
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_direction($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_transitions($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_tile_transition_direction($roomTypeID, $areaTypeID, $section_inner);?>
						
							
				      	</div>
				   	</div>
					<div class="col-4">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_amount($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
					<div class="clear"></div>
				</div>
				<!-- Sixth  row ends-->
				<!-- seventh  row start-->
				<div class="row-wrapper">
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_underlayment($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
					</div>
					<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_thinest($roomTypeID, $areaTypeID, $section_inner);?>
						</div>
				   	</div>
				   	<div class="col-3">
						<div class="select-room-row">
						<?php echo AwFloorFields::floor_thinesttop($roomTypeID, $areaTypeID, $section_inner);?>
							
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- seventh  row ends-->
			</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	public static function getTubShower(){
		
		if(!empty(self::$sectionsData)){

		$roomTypeID 	= self::$sectionsData[0]->sectionMeta[0]->roomDID;
		$areaTypeID     = self::$sectionsData[0]->sectionMeta[0]->areaDID;
		$section_inner 	= self::$sectionsData[0]->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
		<div class="area-wrapper">
			<!-- first  row start-->
			<div class="row-wrapper">
				<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
				<div class="col-1">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_height($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- first  row ends-->
			<!-- second  row start-->
			<div class="row-wrapper">
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_edge($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_transition($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_amount($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- second  row ends-->

			<!-- third  row start-->
			<div class="row-wrapper">
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_instructions($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_edge_instructions($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-3">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_additional($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- third  row ends-->

			<!-- Fourth  row start-->
			<div class="row-wrapper">
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_corner($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_qty($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_location($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_shelve_height($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- Fourth  row ends-->

			<!-- Fifth  row start-->
			<div class="row-wrapper">
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_niche($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_qtys($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_niche_location($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_niche_height($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- Fifth  row ends-->

			<!-- Six  row start-->
			<div class="row-wrapper">
				<div class="col-1">
					<div class="select-room-row">
						<?php echo AwWainscotFields::wainscot_niche_instruction($roomTypeID, $areaTypeID, $section_inner);?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- Six  row ends-->
		</div>

		<?php
		$output = ob_get_clean();
		return $output;
	}

	public static function getFireplace(){
		
		
		if(!empty(self::$sectionsData)){

		$roomTypeID 	= self::$sectionsData[0]->sectionMeta[0]->roomDID;
		$areaTypeID     = self::$sectionsData[0]->sectionMeta[0]->areaDID;
		$section_inner 	= self::$sectionsData[0]->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
		<div class="area-wrapper">
		    <div class="row-9 row-wrapper" >
				<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
		        <div class="col-2">
		            <div class="select-room-row">
		               <?php echo AwFireplaceFields::fireplace_height($roomTypeID, $areaTypeID, $section_inner );?>
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <div class="row-10 row-wrapper" >
		    	<div class="col-4">
		            <div class="select-room-row">
		             
		             <?php echo AwFireplaceFields::fireplace_edge($roomTypeID, $areaTypeID, $section_inner );?>
		            
		            </div>
		        </div>
		        <div class="col-4">
		            <div class="select-room-row">

		             <?php echo AwFireplaceFields::fireplace_transition($roomTypeID, $areaTypeID, $section_inner );?>
		            
		                
		            </div>
		        </div>
		        <div class="col-4">
		            <div class="select-room-row">

		            <?php echo AwFireplaceFields::fireplace_amount($roomTypeID, $areaTypeID, $section_inner );?>
		            
		                
		            </div>
		        </div>
		        <div class="col-4">
		            <div class="select-room-row">

		            <?php echo AwFireplaceFields::fireplace_lf($roomTypeID, $areaTypeID, $section_inner );?>
		            
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <div class="row-11 row-wrapper" >
		    	<div class="col-1">
		            <div class="select-room-row">
		            <?php echo AwFireplaceFields::fireplace_eti($roomTypeID, $areaTypeID, $section_inner );?>
		            
		               
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <div class="row-12 row-wrapper" >
		    	<div class="col-1">
		            <div class="select-room-row">

		            <?php echo AwFireplaceFields::fireplace_instructions($roomTypeID, $areaTypeID, $section_inner );?>
		            
		                
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <div class="row-13 row-wrapper" >
		        <div class="col-1">
		            <div class="select-room-row">

		            <?php echo AwFireplaceFields::fireplace_sectionfire($roomTypeID, $areaTypeID, $section_inner );?>
		        		
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <div class="row-16 row-wrapper" >
		        <div class="col-1">
		            <div class="select-room-row">

		            <?php echo AwFireplaceFields::fireplace_accent($roomTypeID, $areaTypeID, $section_inner );?>
		        	

		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		 </div>
		<?php
		$output = ob_get_clean();
		return $output;
	}

	public static function getBacksplash(){


		if(!empty(self::$sectionsData)){

		$roomTypeID 	= self::$sectionsData[0]->sectionMeta[0]->roomDID;
		$areaTypeID     = self::$sectionsData[0]->sectionMeta[0]->areaDID;
		$section_inner 	= self::$sectionsData[0]->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		

		self::$sectionTypeID = $section_inner;
		ob_start();
	?>
	<div class="area-wrapper">
	    <!-- first  row start-->
	    <div class="row-wrapper">
			<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
	        <div class="col-1">
	        	<div class="select-room-row">
	        		<?php echo AwBacksplashFields::backsplash_height($roomTypeID, $areaTypeID, $section_inner );?>
		        </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <!-- first  row ends-->
	    <!-- second  row start-->
	    <div class="row-wrapper">
	        <div class="col-4">
	        	<div class="select-room-row">
	        		<?php echo AwBacksplashFields::backsplash_edge($roomTypeID, $areaTypeID, $section_inner );?>
	        	</div>
	        </div>
	        <div class="col-4">
	        	<div class="select-room-row">
	        	   <?php echo AwBacksplashFields::backsplash_transition($roomTypeID, $areaTypeID, $section_inner );?>
		        </div>
	        </div>
	        <div class="col-4">
	        	<div class="select-room-row">
					<?php echo AwBacksplashFields::backsplash_amount($roomTypeID, $areaTypeID, $section_inner );?>
		       	</div>
	        </div>
	        <div class="col-4">
	        	<div class="select-room-row">
	        		<?php echo AwBacksplashFields::backsplash_lf($roomTypeID, $areaTypeID, $section_inner );?>
		         </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <!-- second  row ends-->

	    <!-- third  row start-->
	    <div class="row-wrapper">
	        <div class="col-1">
	        	<div class="select-room-row">
	        		<?php echo AwBacksplashFields::backsplash_edge_instructions($roomTypeID, $areaTypeID, $section_inner );?>
 
	        	</div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <!-- third  row ends-->

	    <!-- Fourth  row start-->
	    <div class="row-wrapper">
	        <div class="col-1">
	        	<div class="select-room-row">
	        		<?php echo AwBacksplashFields::backsplash_instructions($roomTypeID, $areaTypeID, $section_inner );?>
		        </div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <!-- Fourth  row ends-->

	    <!-- Fifth  row start-->
	    <div class="row-wrapper">
	    	<div class="col-1">
	        	<div class="select-room-row">
	        	<?php echo AwBacksplashFields::backsplash_accent($roomTypeID, $areaTypeID, $section_inner );?> 
				</div>
	        </div>
	        <div class="clear"></div>
	    </div>
	    <!-- Fifth  row ends-->
	</div>
	<?php
	$output = ob_get_clean();
	return $output;
	}


	public static function getShower(){
		

		if(!empty(self::$sectionsData)){

		$roomTypeID 	= self::$sectionsData[0]->sectionMeta[0]->roomDID;
		$areaTypeID     = self::$sectionsData[0]->sectionMeta[0]->areaDID;
		$section_inner 	= self::$sectionsData[0]->sectionMeta[0]->sectionDID;

		}
		else{
		$roomTypeID =$_POST['roomID'];
		$areaTypeID =$_POST['areaID'];	
		$uniqid = uniqid();
		$section_inner 	= 'aw_inner_section_'.$uniqid;

		}

		self::$sectionTypeID = $section_inner;
		ob_start();
		?>
		<div class="area-wrapper">
		    <!-- first  row start-->
		    <div class="row-wrapper">
				<input type="hidden" name="sectionTypeID" value="<?php echo $section_inner;?>" />
		        <div class="col-1">
		        	<div class="select-room-row">
		        	<?php echo AwShowerFields::shower_height($roomTypeID, $areaTypeID, $section_inner );?>
			        </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <!-- first  row ends-->
		    <!-- second  row start-->
		    <div class="row-wrapper">
		        <div class="col-4">
		    	    <div class="select-room-row">
		    	    <?php echo AwShowerFields::shower_edge($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="col-4">
		        	<div class="select-room-row">
		        	<?php echo AwShowerFields::shower_transition($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="col-4">
		        	<div class="select-room-row">
		        	<?php echo AwShowerFields::shower_amount($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="col-4">
		        	<div class="select-room-row">
					<?php echo AwShowerFields::shower_lf($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <!-- second  row ends-->

		    <!-- third  row start-->
		    <div class="row-wrapper">
		        <div class="col-1">
		        	<div class="select-room-row">
					<?php echo AwShowerFields::shower_instructions($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
			    </div>
			    <div class="clear"></div>
		    </div>
		    <!-- third  row ends-->
		    <!-- Fourth  row start-->
		    <div class="row-wrapper">
		        <div class="col-1">
		        	<div class="select-room-row">
		        	<?php echo AwShowerFields::shower_instructions($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <!-- Fourth  row ends-->
		    <!-- Fifth  row start-->
		    <div class="row-wrapper">
		    	<div class="col-1">
		    		<div class="select-room-row">
		    		<?php echo AwShowerFields::shower_additional($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <!-- Fifth  row ends-->
		    <!-- Sixth  row start-->
		    <div class="row-wrapper">
		    	<div class="col-4">
		    		<div class="select-room-row">
		    		<?php echo AwShowerFields::shower_corner_shelf($roomTypeID, $areaTypeID, $section_inner );?>
		    		</div>
			    </div>
			    <div class="col-4">
			    	<div class="select-room-row">
			    	<?php echo AwShowerFields::shower_qty($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
			    </div>
			    <div class="col-4">
			    	<div class="select-room-row">
			    	<?php echo AwShowerFields::shower_location($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
			    </div>
			    <div class="col-4">
			    	<div class="select-room-row">
			    	<?php echo AwShowerFields::shower_shelve_height($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
			    </div>
			    <div class="clear"></div>
		    </div>
		    <!-- Sixthe  row ends-->
		    <!-- Seventh  row start-->
		    <div class="row-wrapper">
		    	<div class="col-4">
		    		<div class="select-room-row">
		    		<?php echo AwShowerFields::shower_niche_shelf($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="col-4">
		        	<div class="select-room-row">
		        	<?php echo AwShowerFields::shower_niche_qty($roomTypeID, $areaTypeID, $section_inner );?>
		    		</div>
		        </div>
		        <div class="col-4">
		            <div class="select-room-row">
		            <?php echo AwShowerFields::shower_niche_location($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
		        <div class="col-4">
		        	<div class="select-room-row">

		        	<?php echo AwShowerFields::shower_niche_height($roomTypeID, $areaTypeID, $section_inner );?>

		           		
		            </div>
		        </div>
		        <div class="clear"></div>
		    </div>
		    <!-- Seventh row ends-->
		    <!-- Eight  row start-->
		    <div class="row-wrapper">
		    	<div class="col-4">
		    		<div class="select-room-row">
		    		<?php echo AwShowerFields::shower_bench($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
		        </div>
				<div class="col-4">
					<div class="select-room-row">
					<?php echo AwShowerFields::shower_bench_qty($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
					<?php echo AwShowerFields::shower_bench_location($roomTypeID, $areaTypeID, $section_inner );?>
					
					</div>
				</div>
				<div class="col-4">
					<div class="select-room-row">
					<?php echo AwShowerFields::shower_bench_height($roomTypeID, $areaTypeID, $section_inner );?>
					</div>
				</div>
				<div class="clear"></div>
		    </div>
		    <!-- Eight row ends-->
		    <!-- Ninth  row start-->
		    <div class="row-wrapper">
		    	<div class="col-1">
					<div class="select-room-row">
					<?php echo AwShowerFields::shower_niche_instruction($roomTypeID, $areaTypeID, $section_inner );?>
					
					</div>
				</div>
				<div class="clear"></div>
		    </div>
		    <!-- Ninth row ends-->
		</div>
		<?php
		$output = ob_get_clean();
		return $output;
	}



	public static function getBrand() {
		global $wpdb;
		$series    = $wpdb->get_results( "SELECT  DISTINCT `meta_value`  FROM `wp_postmeta` WHERE `meta_key` LIKE 'series'" );
		$color     = $wpdb->get_results( "SELECT  DISTINCT `meta_value`  FROM `wp_postmeta` WHERE `meta_key` LIKE 'color'" );

		return json_encode(array('series' => $series,  'color' => $color));
	}


	public static function getPattern() {

		global $wpdb;
		$args 	= array( 
						'post_type' 	 => 'direction',
						'post_status'	 =>'publish', 
						'posts_per_page' =>-1
						);

		$latest_books = get_posts( $args );
		return json_encode($latest_books);
	}


	public static function getTransitions() {

		global $wpdb;
		$args = array( 
					'post_type'      => 'transitions_type',
					'post_status'    => 'publish',
					'posts_per_page' =>-1
				);

		$latest_books = get_posts( $args );
		return json_encode($latest_books);
	}


	public static function getThinset() {
		global $wpdb;
		$args 	= array(
							'post_type'      => 'thinset',
							'post_status' 	 =>'publish',
							'posts_per_page' =>-1
						);
		$latest_books 	= get_posts( $args );	
		return json_encode($latest_books);
	}


	public static function getProjectData() {


	$projectID =$_POST['projectid'];

	$html = '';	

	global $wpdb;


	$query = "SELECT * FROM `projects` WHERE `projectID` = $projectID";
	$project = $wpdb->get_results($query);

	$query = "SELECT * FROM `rooms` WHERE `project_ID` = $projectID";



	$projects = $wpdb->get_results($query);

		foreach($projects as $k => $p) {

			$query = "SELECT * FROM `areas` WHERE `room_ID` = $p->roomID";
			$areas = $wpdb->get_results($query);
			
			foreach($areas as $a => $area) {

				$query = "SELECT * FROM `area_meta` WHERE `area_ID` = $area->areaID";
				$areasmeta = $wpdb->get_results($query);
				if($areasmeta){
					$areas[$a]->areameta = $areasmeta;

				}
				

			    $query 		= "SELECT * FROM `sections`  WHERE `area_ID` = $area->areaID";
			    $sections 	= $wpdb->get_results($query);

				if($sections) {
					foreach($sections as $key => $section){
						$query 			= "SELECT * FROM `section_meta`  WHERE `sectionDID` = '$section->divID'";
						$sectionMeta 	= $wpdb->get_results($query);

						$sections[$key]->sectionMeta = $sectionMeta;
						$areas[$a]->section 		 = $sections;
						$projects[$k]->areas 		 = $areas;
					}
				}		
			}
			
		}	

		//return json_encode($projects);	
		ob_start();
		foreach($projects as $room) { 

			self::$roomTypeID = $room->divID;

			?>
				<div class="main-section">
					<div class="aw-toolbar">
						<input type="hidden" name="roomTypeID" value="<?php echo $room->divID;?>" />

						<input type="hidden" id="projecteditid" value="<?php echo $project[0]->divID;?>" />
						<input type="hidden" id="projecteditlocation" value="<?php echo $project[0]->location;?>" />
						<input type="hidden" id="projecteditname" value="<?php echo $project[0]->name;?>" />

						
						<a href="#" class="uk-button aw-toggle-btn" title="Collapse" data-uk-toggle="{target:'#<?php echo $room->roomID;?>', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}"><i class="uk-icon-chevron-down"></i></a>
						<!-- <a href="#" class="uk-button add-area-btn" title="Add Area"><i class="uk-icon-plus"></i></a>
						
						<a href="#" class="uk-button close-btn" title="close"><i class="uk-icon-times"></i></a>
						 -->
						<a href="#" class="uk-button add-area-btn" title="Add an Area to this room"><i class="uk-icon-plus"></i></a>
						<a href="#" class="uk-button close-btn" title="Remove Room"><i class="uk-icon-times"></i></a>
					</div>
					<div class="form-wrapper">
						<div class="form-wrapper-inner" id="<?php echo $room->roomID;?>" aria-hidden="false">
							<!-- inner section comes here-->

							<?php
							foreach($room->areas as $area){

								echo  AwComponents::getProjectInnerMainSection($area);
							}
							//echo 'hello';
							?>
						</div>
					</div>
				</div> <!-- main-section -->
			<?php
		}
		$output = ob_get_clean();
		return $output;
	}//Function ends here. 


	/*get inner-main-section*/
	public static function getProjectInnerMainSection($areas){
		
		$area_inner = $areas->divID;

		$html = '';

		self::$sectionsData = $areas->section;
		self::$areaTypeID = $areas->divID;

		self::$roomTypeValue = $areas->areameta[0]->area_value;
		self::$areaTypeValue = $areas->areameta[1]->area_value;
		//self::$areaTypeID = $area_inner;
		ob_start();
		?>
			<div class="form-wrapper-internal-collapse" style="margin-bottom: 5px;">
				<h3 class="inner-collapse-bar">
					<input type="hidden" name="areaTypeID" value="<?php echo $area_inner;?>" />
					<a href="#" class="btn-2 area-close" title="Remove Area"><i class="uk-icon-times"></i></a>
					<a href="#" class="btn-1 aw-area-toggle-btn" title="Collapse" data-uk-toggle="{target:'#<?php echo $area_inner;?>', animation:'uk-animation-slide-bottom, uk-animation-slide-bottom'}"><i class="uk-icon-chevron-down"></i></a>
				</h3>
				<div class="inner-main-section" id="<?php echo $area_inner;?>" aria-hidden="false">
					<div class="row-wrapper">
				    	<div class="col-2">
				            <div class="select-room-row">
				                   <?php echo AwComponents::getRoomType(); ?>
				            </div>
				        </div>
				        <div class="col-2">
				            <div class="select-room-row area-select-section">
				            	 <?php echo AwComponents::getArea('floor'); ?>
				            </div>
				        </div>
				        <div class="clear"></div>
				    </div>

				    
				 	<?php


						$fieldsArray = array();

						foreach($areas->section as $sec){
							
							if($sec->sectionMeta){
								foreach($sec->sectionMeta as $secmeta){
									$fieldsArray[$secmeta->section_key] = $secmeta->section_value;
								}
							}

						
							
						}
						// echo '<pre>';
						// print_r($fieldsArray);
				 	// 	echo '</pre>';
				 	// 	echo '/////////////////';
						
						self::$itemFirePlace = $fieldsArray;
						
						echo AwComponents::getInnerAreaSection();
						// echo '<pre>';
						 
						// print_r($fieldsArray);
				 	// 	echo '</pre>';

						//echo $html;
					?>					
				</div>
			</div>
		    
		<?php
		$output = ob_get_clean();
		return $output;
	}


	static public function getLocationsLists(){

		global $wpdb;

		/*---- Get all locations list------------*/
		   
		$locations = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE post_type = 'location' AND `post_status` = 'publish'");

		return $locations;
	}


	public static function getInnerAreaSection(){

		if(AwComponents::$areaTypeValue){

			$areaType 	= strtolower(AwComponents::$areaTypeValue);
			$areaType  	= str_replace(" ", "_", $areaType);
		}
		else{
			$areaType  	= trim($_POST['area_type']);
			$areaType  	= str_replace(" ", "_", $areaType);
			$areaType 	= strtolower($areaType);
		}
		

		// floor
		// tub_shower
		// shower
		// shower_floor
		// drop_in_tub
		// wainscot
		// backsplash
		// fireplace

		switch ($areaType) {
			case 'floor':
				echo AwComponents::getFloorHeader();
				break;

			case 'tub_shower':
				echo AwComponents::getTubShower();
				break;

			case 'shower':
				echo AwComponents::getShower();
				break;

			case 'shower_floor':
				echo AwComponents::getFloorHeader();
				break;

			case 'drop_in_tub':
				echo AwComponents::getTubShower();
				break;

			case 'wainscot':
				echo AwComponents::getTubShower();
				break;

			case 'backsplash':
				echo AwComponents::getBacksplash();
				break;

			case 'fireplace':
				echo AwComponents::getFireplace();
				break;

			default:
				echo '<div class="area-wrapper"><div class="row-wrapper"><div class="col-1"><div class="select-room-row"> <h1> Selected: '.$areaType.' </h1> </div></div><div class="clear"></div></div></div>';
				break;
		}

		
	}




}/* class ends here */

?>
