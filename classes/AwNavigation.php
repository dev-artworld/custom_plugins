<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// div for divider.
// <div class="main-section-divider"></div>

class AwNavigation {
	

	
	public static function leftsidebar(){


		$PATH_TO_PLUGIN_DIR = plugins_url()."/aw_calculations/";
		$projectDivID     = "aw_project_".uniqid();

		$userid = get_current_user_id();

		global $wpdb;

		/*---- Get all projects of current user------------*/

		   
		$locations = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE post_type = 'location' AND `post_status` = 'publish'");

		$templocations = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE post_type = 'location' AND `post_status` = 'publish'");

        $archives = $wpdb->get_results("SELECT * FROM `projects` WHERE status = 'archive' AND user_ID = $userid");

		foreach($locations as $k => $loc){

		$projects = $wpdb->get_results("SELECT * FROM `projects` WHERE location = $loc->ID AND status = 'project' AND user_ID = $userid");

		$locations[$k]->projects = $projects;
		}
		  
		foreach($templocations as $k => $loc){

		$projects = $wpdb->get_results("SELECT * FROM `projects` WHERE location = $loc->ID AND status = 'template' AND user_ID = $userid");

		$templocations[$k]->projects = $projects;
		}

		ob_start();?>


		<div class="add-project-btn" data-uk-modal="{target:'#add_location',bgclose:false}"><a class="uk-button uk-button-primary" href="javascript:void(0);">Add New Projects</a></div>
            <!--<div class="add-item-row add_location" data-uk-modal="{target:'#add_location'}"><a class="uk-button uk-button-primary" href="">Add New Location</a></div>-->
                <ul class="aw-project uk-nav uk-nav-parent-icon left-navigation" data-uk-nav>
                    <li class="uk-parent">
                        <a href="#">Templates</a>
                        <ul class="uk-nav-sub">
                             <?php 
                             foreach($templocations as $location){ 
                                 $subdivision   = get_post_meta($location->ID,  'subdivision', false );
                                 $address       = get_post_meta($location->ID,  'address', false );

                               
                                if($location->projects){

                                  foreach($location->projects as $project){ ?>
                                <li><a class="aw_project" href="<?php echo $project->projectID;?>"><?php echo $project->name;?></a></li>
                                    <?php } ?>

                                <?php }    ?>

                            <?php }  ?>                            
                            
                        </ul>
                    </li>


                    
                    <li class="uk-parent">
                        <a href="#">Current Projects</a>
                        <ul class="uk-nav-sub">
                             <?php 
                             foreach($locations as $location){ 
                                 $subdivision   = get_post_meta($location->ID,  'subdivision', false );
                                 $address       = get_post_meta($location->ID,  'address', false );

                                 ?>

                                <li> 
                                <?php if($subdivision[0] != ''){?>
                                <a class="aw_project" href="#"><?php echo $location->post_title . ' ' . $subdivision[0];?></a>

                                <?php } else{ ?>
                                <a class="aw_project" href="#"><?php echo $address[0];?></a>

                                <?php }

                                if($location->projects){?>
                                
                                <ul >
                                    <?php 
                                  foreach($location->projects as $project){ ?>
                                <li data-uk-dropdown style="position: relative;"><a class="aw_project" href="<?php echo $project->projectID;?>"><?php echo $project->name;?></a>

                                <div class="uk-dropdown" >
                                    <ul class="uk-nav-dropdown">
                                       <li class="aw_delete_project" ><a href="<?php echo $project->divID;?>">Delete</a></li>
                                       <li class="aw_archive_project" ><a href="<?php echo $project->divID;?>">Archive</a></li>
                                    </ul>
                                </div>

                                </li>
                                    <?php } ?>

                                </ul>
                                <?php }    ?>

                                </li>
                            <?php }  ?>                            
                            
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <a href="#">External Users</a>
                        <ul class="uk-nav-sub">
                            <li>
                            	<a href="#">External User A</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="#">Abc Project</a></li>
                                    <li><a href="#">DEF Project</a></li>
                                </ul>
                            </li>
                            <li>
                            	<a href="#">External User B</a>
                                <ul class="uk-nav-sub">
                                    <li><a href="#">Abc Project</a></li>
                                    <li><a href="#">DEF Project</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <a href="#">Tables</a>
                    </li>
                    <li class="uk-parent">
                        <a href="#">Archives</a>
                        <ul class="uk-nav-sub">
                        <?php foreach($archives as $archive){?>

                            <li>
                                <a href="<?php echo $archive->projectID;?>"><?php echo $archive->name;?></a>
                                   
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                </ul>

	<?php
		$output = ob_get_clean();
		return $output;
	}
	
/* class ends here */
}
?>
