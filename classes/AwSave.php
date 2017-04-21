<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// div for divider.
// <div class="main-section-divider"></div>

class AwSave {
	
	public static function saveArchiveProject($projectDID){
		global $wpdb;

		$wpdb->update('projects', array('status' => 'archive'),array( 'divID' => $projectDID ));

		return 'update';


	}

	
	public static function deleteproject($deleteproject){
		global $wpdb;

		$projectDID = $deleteproject[0]['projectID'];
		
		$projectQueries =  "SELECT * FROM projects WHERE divID='".$projectDID."'";
        $projectQuerie  = $wpdb->get_results($projectQueries, OBJECT);

        

        $projectID = $projectQuerie[0]->projectID;

        /*-----delete project----*/ 
        $wpdb->delete( 'projects', array( 'projectID' => $projectID) );

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

			/*-----delete rooms----*/ 
			foreach($projects as $rooms){
				
				$wpdb->delete( 'rooms', array( 'roomID' => $rooms->roomID ) );
					/*-----delete area----*/ 
				foreach($rooms->areas as $areas){
					
					$wpdb->delete( 'areas', array( 'areaID' => $areas->areaID ) );
					/*-----delete area meta----*/ 
						foreach($areas->areameta as $areameta){

							
								$wpdb->delete( 'area_meta', array( 'areametaID' => $areameta->areametaID ) );
						}
							/*-----delete section----*/
						foreach($areas->section as $section){

						 
								$wpdb->delete( 'sections', array( 'sectionID' => $section->sectionID ) );
								/*-----delete sectionmeta----*/ 
							foreach($section->sectionMeta as $sectionmeta){

								$wpdb->delete( 'section_meta', array( 'sectionMetaID' => $sectionmeta->sectionMetaID ) );
							}

						}

				}

			}

			

	}

	public static function saveProject(){

	if($_POST['projectsave'] == 'update'){

		self::deleteproject($_POST['projectcreator']);

		
	}	

	

	 $projectcreator = 	$_POST['projectcreator'];

	 $status 		 = $_POST['status'];

		$project = array();
		$area    = array();
		$room    = array();
		$section = array();

	   foreach($projectcreator as $creators){
	   		global $wpdb;

			$name 		   		= $creators['name'];
			$value 		   		= $creators['value'];
			$projectDID 		= $creators['projectID'];
			$projectName 		= $creators['projectName'];
			$projectLocation 	= $creators['projectLocation'];
			$roomDID    		= $creators['roomID'];
			$areaDID    		= $creators['areaID'];
			$sectionDID 		= $creators['sectionID'];


/* for the project table*/
            if($name == 'projectDivID'){


            	if($_POST['projectsave'] == 'saveas'){

					$value = 'aw_project_' . uniqid();

					
				}

                $project_found = array_search($project,$value);

	            if($project_found == null){
	                array_push($project, $value);
	            }
                $currentUserId  = get_current_user_id();
                $projectQueries =  "SELECT `divID` FROM projects WHERE divID='".$value."'";
                $projectQuerie  = $wpdb->get_results($projectQueries, OBJECT);
                if(empty($projectQuerie)){
                    $wpdb->insert('projects', array(
					    'user_ID'    => $currentUserId,
					    'divID'      => $value,
					    'location'   => $projectLocation,
					    'name'       => $projectName,
					    'status' 	=> $status,// ... and so on
					));
			      }
            } //end of if

			/* for the room table*/
            if( $name == 'roomTypeID' ) {


            	if($_POST['projectsave'] == 'saveas'){

					$value = 'aw_' . uniqid();

					
				}

              	$room_found = array_search($room,$value);

	            if($room_found == null){
	                array_push($room, $value);
	            }

				$query = "SELECT `projectID` FROM projects WHERE divID='".$project[0]."'";
				$projectIDt = $wpdb->get_results($query, OBJECT);
                $currentProjectId = $projectIDt[0]->projectID;

                $roomQueries =  "SELECT `divID` FROM rooms WHERE divID='".$value."'";
                $roomQuerie  = $wpdb->get_results($roomQueries, OBJECT);
                if(empty($roomQuerie)){
	                 $wpdb->insert('rooms', array(
					    'project_ID' => $currentProjectId,
					    'divID'      => $value,
				    ));
                }
            } //end of if

			/* for the area table*/
            if($name == 'areaTypeID'){

            	if($_POST['projectsave'] == 'saveas'){

					$value = 'aw_inner_' . uniqid();

					
				}

                 $area_found = array_search($area,$value);

                if($area_found == null){
	                array_push($area, $value);
	            }

	            foreach($room as $roomvalue){
				    $query   = "SELECT `roomID` FROM rooms WHERE divID = '".$roomvalue."'";
				    $roomIDd = $wpdb->get_results($query, OBJECT);
				}

			    $query            = "SELECT `projectID` FROM projects WHERE divID = '".$project[0]."'";
			    $projectIDt       = $wpdb->get_results($query, OBJECT);
			    $currentProjectId = $projectIDt[0]->projectID;

                    //$currentProjectId = $projectIDt[0]->projectID;
                $areaQueries =  "SELECT `divID` FROM areas WHERE divID='".$value."'";
                $areaQuerie  = $wpdb->get_results($areaQueries, OBJECT);
                if(empty($areaQuerie)){ 

		            foreach($roomIDd as $roomIDds){
			            $wpdb->insert('areas', array(
						    'project_ID' => $currentProjectId,
						    'room_ID'    => $roomIDds->roomID,
						    'roomType'   => 'roomType',
						    'areaType'   => 'areaType',
						    'divID'      => $value
						));
					}
			    }
            } //end of if

			/* for the section table*/
            if( $name == 'sectionTypeID') {

            	if($_POST['projectsave'] == 'saveas'){

					$value = 'aw_inner_section_' . uniqid();

					$sectionDivID = $value;

					
				}
                $section_found = array_search($section,$value);
               	if($section_found == null){
                	array_push($section, $value);
               	}

               	foreach($room as $roomvalue){
                	$query = "SELECT `roomID` FROM rooms WHERE divID='".$roomvalue."'";
			    	$roomIDd = $wpdb->get_results($query, OBJECT);
               	}

	            foreach($area as $areavalue){
					$query = "SELECT `areaID` FROM areas WHERE divID='".$areavalue."'";
				    $areaIDd = $wpdb->get_results($query, OBJECT);
				}
                
                $sectionQueries =  "SELECT `divID` FROM sections WHERE divID='".$value."'";
                $sectionQuerie  = $wpdb->get_results($sectionQueries, OBJECT);
                if(empty($sectionQuerie)){ 

	               	foreach($roomIDd as $roomIDds){
						foreach($areaIDd as $areaIDds){
							$secID = $wpdb->insert('sections', array(
								'room_ID' => $roomIDds->roomID,
								'area_ID' => $areaIDds->areaID,
								'divID'   => $value,
							));

						
						}
				    }
			     }

            } //end of if
			/* for the section-meta table*/

			if(($name == 'room') || ($name == 'area')){

				
	            foreach($area as $areavalue){
					$query = "SELECT * FROM areas WHERE divID='".$areavalue."'";
				    $areaIDd = $wpdb->get_results($query, OBJECT);
				}


				
				foreach($areaIDd as $areaIDds){
					$query = "SELECT * FROM area_meta WHERE area_ID='".$areaIDds->areaID."' AND area_key = '".$name."'";
				    $area_meta = $wpdb->get_results($query, OBJECT);
				    
				    if(empty($area_meta)){
				    	$secID = $wpdb->insert('area_meta', array(
								'area_key' => $name,
								'area_value' => $value,
								'area_ID' => $areaIDds->areaID,
								'areaDID'   =>$areaIDds->divID,
							));


				    }
							
						
				}
			
			}

			if($sectionDivID){
				$sectionDID = $sectionDivID;

				$sectionkey = explode('aw_inner_section_',$name);
				$name = $sectionkey[0] . $sectionDID; 

			}
			
			$sectionid = self::getSectionID($sectionDID);
            $args = array(
				'section_ID'    => $sectionid,
				'section_key'   => $name,
				'section_value' => $value,
				'projectDID'    => $projectDID,
				'roomDID'       => $roomDID,
				'areaDID'       => $areaDID,
				'sectionDID'    => $sectionDID,
			);

			$wpdb->insert('section_meta', $args);
	    }

	    echo $currentProjectId;
		die();
	}

	public static function getSectionID( $sectionDID ){
		/*$sectionDID*/
		/*code to get the section ID*/
		global $wpdb;
		$sectionQueries =  "SELECT `sectionID` FROM sections WHERE divID='".$sectionDID."'";
        $sectionID  = $wpdb->get_results($sectionQueries, OBJECT);
		return $sectionID[0]->sectionID;
	}


	
/* class ends here */
}
?>
