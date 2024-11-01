<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * @package wp-steps
 * @version 1.0
 */
/*
Plugin Name: WP Steps
Plugin URI: https://webitizer.de/plugin/wp-steps
Description: WP Steps shows your content step by step. There is no limit how many steps you use.
Author: webitizer | Christian Kosan
Version: 1.0
Author URI: https://webitizer.de
*/

add_filter("the_content", "the_wpsteps_content_filter");
function the_wpsteps_content_filter($content)
 {
	$block = join("|",array("wpsteps"));
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
	return $rep;
}
function wpstepsadd()
{
    if(wp_script_is("quicktags"))
    {
        ?>
            <script type="text/javascript">
                QTags.addButton(
                    "wpstepsadd",
                    "wpsteps",
                    callback_wpstepsadd
                );

                function callback_wpstepsadd()
                {
                    QTags.insertContent('[wpsteps step="" last="0" goback="0" gobacktxt="" gonexttxt="" buttonclass="btn btn-default"]your content[/wpsteps]');
                }
            </script>
        <?php
    }
}

add_action("admin_print_footer_scripts", "wpstepsadd");
function go_wpsteps( $atts , $content = null ) 
{
	wp_enqueue_script( 'wp-steps', plugin_dir_url( __FILE__ ) . '/wp-steps.js', array(), '1.0.0', true );
	extract(shortcode_atts(array(
 
                    "step" => '',
					"last" => false,
					"goback"=> false,
					"gobacktxt"=> 'zurück',
 					"gonexttxt"=> 'weiter',
					"buttonclass"=> '',
                    ), $atts));
	$visible=false;	
	$buttongonext = $buttongoback = '';
	if($step && $step==1){
		$visible=true;
		$goback=0;
	}
	$togo = $step+1;
	$gobackstep = $step-1;
	if(!$last || $last==0){
		$buttongonext ='<button class="'.$buttonclass.' gonextstep" data-step2go="'.($togo).'" data-step2hide="'.($step).'" type="button">'.$gonexttxt.'</button>';
	}
	if($goback || $goback==1){
		$buttongoback ='<button class="'.$buttonclass.' gobackstep" data-step2go="'.($gobackstep).'" data-step2hide="'.($step).'" type="button">'.$gobacktxt.'</button>';
	}
	return '<div class="wpsteps_step_'.$step.'" '.($visible?'':'style="display:none;"').'>'.$buttongoback.do_shortcode($content).$buttongonext.'</div>';
}
add_shortcode( 'wpsteps', 'go_wpsteps' );