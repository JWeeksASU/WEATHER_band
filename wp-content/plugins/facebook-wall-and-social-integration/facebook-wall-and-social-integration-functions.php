<?php 
/* facebook wall version 1.4 */ 
// Example Use: [facebook_wall_and_social_integration_replace_com post_title="true" excerpt_length="true" categories="all" thumbnail="true" img_width="250" img_height="150" rows="2" columns="1" pages_number="2" template="amaz-columns.php"]
function facebook_wall_and_social_integration_replace_scode($atts) { 
	
	//function microtime_float() { list($usec, $sec) = explode(" ", microtime()); return ((float)$usec + (float)$sec); }	$time_start = microtime_float();			
	$msfb_options = get_option('ms_fbwall_plugin_general_settings');
	$options_layout = get_option('ms_fbwall_plugin_postlayout_settings');
	$options_color = get_option('ms_fbwall_plugin_color_settings');	
		    	  
  	  $show_post_items = ''; 
  	  //each string should not appear in another string as sub string 
  	  if($options_layout["msfb_showauthavatar"]) $show_post_items .= 'pauthavatar,';
  	  if($options_layout["msfb_showauthname"]) $show_post_items .= 'authname,';
  	  if($options_layout["msfb_showposttext"]) $show_post_items .= 'posttxt,';  	  
  	  if($options_layout["msfb_showdate"]) $show_post_items .= 'date,';
  	  if($options_layout["msfb_postlikebutton"]) $show_post_items .= 'postlikebtn,';  
  	  //get short code attributes, if any attribute not present then right hand side default value will be set
	  $atts = shortcode_atts( array(
	    'id' => ''.$msfb_options['msfb_fbid'].'',  	
		'num' => ''. $msfb_options['msfb_postnum'] .'',
	  	'width' => ''. $msfb_options['msfb_facebookwidth'] .'',
	  	'height' => ''. $msfb_options['msfb_facebookheight'] .'', 
	  	//'ajax_comments' => ''. ($msfb_options['msfb_ajaxcomments']) ? "true" : '', 
	  	'guest_posts' => ''. ($msfb_options['msfb_guestentries']) ? "true" : '', 
	  	'border' => ''. ($msfb_options['msfb_showborder']) ? "true" : '', 
	  	'cache_time' => ''. $msfb_options['msfb_cache_time'].'', 
	  	'cache_unit' => ''. $msfb_options['msfb_cache_time_unit'] .'', 
	  	'post_items' => ''.$show_post_items.'',	  	
	  	 
	  	'backg_color' => ''. $options_color["msfb_backcolor"] .'', 
	  	'post_brd_color' => ''. $options_color["msfb_postbordercolor"].'', 
	  	'author_text_color' => ''. $options_color["msfb_postauthorcolor"] .'',  
	  	'post_text_color' => ''. $options_color["msfb_posttextcolor"] .'', 
	  	'date_color' => ''. $options_color["msfb_datecolor"] .'', 
	  	'like_link_color' => ''. $options_color["msfb_likecommenttextcolor"].'',   		  				             
    ), $atts);
	  
/////////////check critical errors first 
$msfb_accesstoken=$msfb_options['msfb_accesstoken'];
	  
$error_flag=false;	
if (trim($msfb_accesstoken) == '') {
	
	$msfb_html_content_first.= 'Please enter a valid Access Token in settings page.<br /><br />';
    $error_flag=true;
}  
//Check if page id has been defined
if ((trim($atts['id']) == '')) {
	$msfb_html_content_first.= "facebook page/group id is empty. Enter id in facebook id box in setting page or in short code(see instructions at bottom)<br /><br />";
	$error_flag=true;
} else { $msfb_fbid= trim($atts['id']); }
//Check if number of posts has been defined
if (count(trim($atts['num']))<=0) {
	$msfb_html_content_first.= "Please enter the number of posts value. Enter in show number of posts box setting page or in short code(see instructions at bottom)<br /><br />";
	$error_flag=true;
} else { $msfb_postnum= trim($atts['num']); }

if(!$error_flag)
{
//general from short codes	
$msfb_toplikebox  = $atts['like_btn']=="true" ? true : false ; //from short code
$msfb_facebookwidth = $atts['width'];
$msfb_facebookheight = $atts['height'];
$msfb_guestentries = $atts['guest_posts'] =="true" ? true : false ; 
$msfb_showborder = $atts['border'] =="true" ? true : false ; 
$msfb_cache_time = $atts['cache_time'];
$msfb_cache_time_unit = $atts['cache_unit'];
//general not from short codes
$msfb_accesstoken = $msfb_options['msfb_accesstoken'];

/******************/
//post layouts //from short codes
$msfb_post_layout=$atts["post_pic_size"];
$post_items=$atts['post_items'];
if (stripos($post_items, 'pauthavatar') !== false ) $msfb_showauthavatar = true;
if (stripos($post_items, 'authname') !== false ) $msfb_showauthname = true;
if (stripos($post_items, 'posttxt') !== false ) $msfb_showposttext = true;
if (stripos($post_items, 'date') !== false )  $msfb_showdate = true;
if (stripos($post_items, 'postlikebtn') !== false ) $msfb_postlikebutton = true;
//post layouts //not from short codes 
$msfb_dateformat=$options_layout["msfb_dateformat"]; 
$msfb_timezone=$options_layout["msfb_timezone"]; 
$msfb_timezone = (!empty($msfb_timezone))? $msfb_timezone : "Europe/London";
$msfb_postlikebtntxt=$options_layout["msfb_postlikebtntxt"]; 

/******************/
 //color
	  $msfb_backcolor=$atts["backg_color"]; 
	   $msfb_postbordercolor=$atts["post_brd_color"];
	   $msfb_postauthorcolor=$atts["author_text_color"];
	   $msfb_posttextcolor=$atts["post_text_color"];
	  $msfb_datecolor=$atts["date_color"];
	   $msfb_likecommenttextcolor=$atts["like_link_color"];
 
////////////define other variables 	
$re_facebookwidth="11"; $temp_width=(int)$msfb_facebookwidth; 
if(is_int($temp_width)) { if(($temp_width>90)&&($temp_width<=100)){ $re_facebookwidth="12"; } if(($temp_width>80)&&($temp_width<=90)){ $re_facebookwidth="11"; } if(($temp_width>70)&&($temp_width<=80)){ $re_facebookwidth="10"; } if(($temp_width>60)&&($temp_width<=70)){ $re_facebookwidth="9"; } if(($temp_width>50)&&($temp_width<=60)){ $re_facebookwidth="8"; } if(($temp_width>40)&&($temp_width<=50)){ $re_facebookwidth="7"; } if(($temp_width>30)&&($temp_width<=40)){ $re_facebookwidth="6"; } if(($temp_width>20)&&($temp_width<=30)){ $re_facebookwidth="5"; } if(($temp_width>10)&&($temp_width<=20)){ $re_facebookwidth="4"; } if($temp_width<=10){ $re_facebookwidth="3"; } if($temp_width>100){ $re_facebookwidth="11"; }} 
$msfb_type=""; $msfb_source_id=""; 
//feed or posts
$msfb_type = ($msfb_guestentries) ? 'feed' : 'posts'; //if showGuest false = posts
//graph api url
$msfb_posts_url = 'https://graph.facebook.com/'. $msfb_fbid.'/' . $msfb_type . '?access_token='.$msfb_accesstoken.'&limit='. $msfb_postnum;
//set time zone for date calculation //check if empty function is appropriate when string is empty check done
date_default_timezone_set($msfb_timezone);

$msfb_cache_time = trim($msfb_cache_time);
if($msfb_cache_time_unit == 'minutes') $msfb_cache_time_unit = 60;
if($msfb_cache_time_unit == 'hours') $msfb_cache_time_unit = 60*60;
if($msfb_cache_time_unit == 'days') $msfb_cache_time_unit = 60*60*24;
if(trim($msfb_cache_time_unit) == '') $msfb_cache_time_unit = 60; //if empty
$cache_in_seconds = $msfb_cache_time * $msfb_cache_time_unit;

////////////Now get data from Graph api
/* function microtime_float2(){  list($usec, $sec) = explode(" ", microtime()); return ((float)$usec + (float)$sec); }
$time_start2 = microtime_float2(); */
if (($msfb_cache_time != 0)&&(($msfb_cache_time !=""))){
	// Get any existing copy of our transient data
	$transient_name = 'msfb_cache_'.$msfb_fbid;
	if ( false === ( $msfb_data_objs_first = get_transient( $transient_name ) ) || $msfb_data_objs_first === null ) {
		//Get the contents of the Facebook page
		$msfb_data_objs_first = Msfb_Wall_Get_Graph_API_Data($msfb_posts_url);
		//Cache the JSON
		$msfb_data_objs = $msfb_data_objs_first;
        //json decode of data
        $msfbData = json_decode($msfb_data_objs);
        if(isset($msfbData->error)) { } else { if(count($msfbData->data)<=0){ } else { set_transient( $transient_name, $msfb_data_objs_first, $cache_in_seconds ); } }  
		/*goto skip; not works php v <5.3*/
	} else {
		$msfb_data_objs_first = get_transient( $transient_name ); $msfb_html_content_first.="<!-- getting data from cache -->";
		//If we can't find the transient then fall back to just getting the json from the api
		if ($msfb_data_objs_first == false)
		{ 
			$msfb_data_objs_first = Msfb_Wall_Get_Graph_API_Data($msfb_posts_url); $msfb_html_content_first.="<!-- transient not found -->";
			$msfb_data_objs = $msfb_data_objs_first; $msfbData = json_decode($msfb_data_objs);
		}
		else 
		{
			$msfb_data_objs = $msfb_data_objs_first; $msfbData = json_decode($msfb_data_objs);
		}
	}
} else {
	$msfb_data_objs_first = Msfb_Wall_Get_Graph_API_Data($msfb_posts_url);
	$msfb_data_objs = $msfb_data_objs_first; $msfbData = json_decode($msfb_data_objs);
}
$msfb_counter=0;

/////////////data extraction.Check error first
if(isset($msfbData->error)){ $msfb_html_content_first.= $msfbData->error->message ; $error_flag=true; } else {   
// check if no record found
$msfb_max = count($msfbData->data);
if($msfb_max==0){			
	$msfb_html_content_first .= '<div class="msfb-wall-box-first">';
	$msfb_html_content_first .= '<img class="msfb-wall-avatar" src="'. Msfb_Wall_Get_Avatar_Url($msfb_fbid) .'" />';
	$msfb_html_content_first .= '<div class="msfb-wall-data">';
	$msfb_html_content_first .= '<span class="msfb-wall-message">Call to Facebook API failed or no records returned. Make sure system requirements are met(look for the tab in settings page), facebook id and access token(<a target="_blank" href="https://developers.facebook.com/tools/debug/">check here</a>) are right. Finally, make sure there are no restrictions set in facebook page/group/profile settings and compare with another page/group feed display to find the exact problem.</span>';
	$msfb_html_content_first .= '</div>';
	$msfb_html_content_first .= '</div>'; $error_flag=true;
}   
else 
{	
	//get like info per post seperately because of the hassle of first call don't show like count.
	if(msfb_exists($msfbData->data[0]->id)) { $msfb_source_id = explode("_",$msfbData->data[0]->id);}			   
	$random_length = 3;
	//generate a random id encrypt it and store it in $rnd_id
	$rnd_id = crypt(uniqid(rand(),1));
	//to remove any slashes that might have come
	$rnd_id = strip_tags(stripslashes($rnd_id));
	//Removing any . or / and reversing the string
	$rnd_id = str_replace(".","",$rnd_id);
	$rnd_id = strrev(str_replace("/","",$rnd_id));
	//finally I take the first 2 characters from the $rnd_id
	$rnd_id = substr($rnd_id,0,$random_length);
//////////////////////sample test post start ////use cache instaed
////use cached data for test post   
/////////////////////testpost ends
 foreach ($msfbData->data as $fdata) 
 { 
 		
 	$msfb_show_post = true;
    if($msfb_show_post)
    {	
	//try block level elements not child of inline elements
	$msfb_html_content_first .= ($msfb_counter==0) ? '<div class="msfb-layout msfb-wall-box msfb-wall-box-first">' : '<div class="msfb-layout msfb-wall-box">';
	/////////show avatar
	if($msfb_showauthavatar){ 
		$msfb_html_content_first .= '<div class="avatar"><a href="https://www.facebook.com/profile.php?id='.$fdata->from->id.'" target="_blank">';
		$msfb_html_content_first .= '<img class="msfb-wall-avatar" src="'. Msfb_Wall_Get_Avatar_Url($fdata->from->id) .'" />';
		$msfb_html_content_first .= '</a></div>';
	}
	$msfb_html_content_first .= '<div class="msfb-wall-data">';
	$msfb_html_content_first .= '<span class="msfb-wall-message">';
	if($msfb_showauthname) { $msfb_html_content_first .= '<a href="https://www.facebook.com/profile.php?id='. $fdata->from->id .'" class="msfb-wall-message-from" target="_blank">'. $fdata->from->name .'</a> '; } 
	
	if($msfb_showposttext) {
	if(msfb_exists($fdata->message))
	{
	    $msfb_html_content_first .= '<span style="display:block;margin-top:4px;">'. msfb_modText($fdata->message) .'</span>'; 		
	}
	if(msfb_exists($fdata->story))
	{		
		$msfb_html_content_first .= '<span style="display:block;margin-top:4px;">'. msfb_modText($fdata->story) .'</span>'; 
	} } 
	$msfb_html_content_first .= '</span>';	
	//////////////media
	/////////////////////////////////////
	//date, share, link section	
		$msfb_html_content_first .= '<span class="msfb-wall-date">';
		if(msfb_exists($fdata->icon)){ $msfb_html_content_first .= '<img class="msfb-wall-icon" src="'.$fdata->icon.'" title="'.$fdata->type.'" alt="" />'; }
		if($msfb_showdate){ $msfb_html_content_first .= Msfb_FormatDate($fdata->created_time, "at", $msfb_dateformat); }		
		if($msfb_postlikebutton)
		{						
			if(msfb_exists($fdata->actions)) { $msfb_html_content_first .= '<a style="margin-left:3px;cursor:pointer;cursor:hand; font-weight:normal;" href="'. $fdata->actions[0]->link .'" target="_blank" >'.$msfb_postlikebtntxt.'</a>'; }
			else {
				$mspost_id = explode("_",$fdata->id);
				$msfb_html_content_first .= '<a style="margin-left:3px;cursor:pointer;cursor:hand; font-weight:normal;" href="https://www.facebook.com/'.$mspost_id[0].'/posts/'.$mspost_id[1].'" target="_blank" >'.$msfb_postlikebtntxt.'</a>';
			} 
		}
		
		$msfb_html_content_first .='</span>';	
	// Likes -------------------------------------------------------------------------------------------------------------------------------
	
	 // Comments -------------------------------------------------------------------------------------------------------------------------------
    
	 $msfb_html_content_first .= '</div><div class="msfb-wall-clean"></div>';
	 $msfb_html_content_first .='</div>';	
	}// show post type ends
	$msfb_counter++;
  } //for each ends  
  
  ///////////construct current plugin styles start 
  //try adding inherit so that it inherit color and font from parent
  $curmod_styles="";
  $heightop="";
  $heightop='height:'.$msfb_facebookheight.'px;'; 
  $curmod_styles.= "\r\n#msfbmain-div$rnd_id .scroll-content  { overflow: auto; margin:7px 1px 2px 0; $heightop }";
  
  $showborder="";
  if($msfb_showborder){ $showborder='border: 1px solid buttonface;'; }
  $curmod_styles.="\r\n#msfbmain-div$rnd_id { background-color: $msfb_backcolor; $showborder }";
  
  $curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall { background-color: $msfb_backcolor; }";
  
  $curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-layout { border: 1px solid $msfb_postbordercolor;}";
  if( !$msfb_showauthavatar) { $curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-data { margin-left:0px; }"; }
  
  if($msfb_showposttext) {
  	$curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-message{ font-size: 13px; color: $msfb_posttextcolor;}";
  }
  
  if($msfb_showauthname) {
  	$curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-message-from { font-size: 13px !important; color:$msfb_postauthorcolor !important; }";
  	$curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-message-from:hover,#msfbmain-div$rnd_id .msfb-wall-message-from:active,#msfbmain-div$rnd_id .msfb-wall-message-from:focus
  	{ font-size:13px !important; color:$msfb_postauthorcolor !important; }";
  }  
  
  $curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-date { font-size:11px !important; color:$msfb_datecolor;}";
  
  if($msfb_postlikebutton) {
  	$curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-date a { font-size:11px !important;  color: $msfb_likecommenttextcolor !important; }";
  	$curmod_styles.="\r\n#msfbmain-div$rnd_id .msfb-wall-date a:hover,#msfbmain-div$rnd_id .msfb-wall-date a:active,#msfbmain-div$rnd_id .msfb-wall-date a:focus
  	{ font-size:11px !important; color:$msfb_likecommenttextcolor !important; }";
  }
  //////////////styles end  
 } //records !=0 condition ends
} //no errors condition ends   

} //no error on fbid, token... condition ends at first  
$msfb_source_id = explode("_",$msfbData->data[0]->id); //if not define here, things get messed up
/* If we want to create more complex html code it's easier to capture the output buffer and return it */ 
 ob_start();  
 ?>
 
<?php global $ms_fbwall_main_style_1578;   
if(!$ms_fbwall_main_style_1578){ ?>
<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>/wp-content/plugins/facebook-wall-and-social-integration/css/jquery.mitsol.fbookwall.css" />
<?php $ms_fbwall_main_style_1578 = true; } ?>
 		
<style type="text/css">      
 <?php echo $curmod_styles; ?>
</style> 
   
<?php if($re_facebookwidth!=""){ $fb_width=$re_facebookwidth; } ?>
<div class="msfb-wall-main"> <div class="msfb-container"> <div class="msfb-row"> <div class="span_len<?php echo $fb_width; ?>">
<div id="msfbmain-div<?php echo $rnd_id; ?>">
<div id="msfb-content-main-<?php echo $rnd_id; ?>" class="scroll-content" style="overflow: auto;margin:7px 1px 2px 0;"><div class="msfb-wall"><!-- version1.4 --><?php echo $msfb_html_content_first; ?></div></div>  
</div> 
</div></div></div></div>
 <?php  
    /* Return the buffer contents into a variable */
    $msfb_html_content = ob_get_contents(); 
    /* Empty the buffer without displaying it. We don't want the previous html shown */
    ob_end_clean(); 
    /* The text returned will replace our shortcode matching text */       
    return $msfb_html_content;
}
//format date from facebook per post
function Msfb_FormatDate($dateStr,$atTranslated, $dateFormat){				
	
	$unixtime=strtotime($dateStr);
	$day=date("d",$unixtime);
	$month=date("m",$unixtime);
	$year=date("Y",$unixtime);
	$hour=date("h",$unixtime);
	$minutes=date("i",$unixtime);
	$ampm= ((date("H",$unixtime))<12) ? 'am' : 'pm';
	if($dateFormat=="us") { return $month.'.'.$day.'.'.$year.' '.$atTranslated.' '.$hour.':'.$minutes.' '.$ampm; }
	return $day.'.'.$month.'.'.$year.' '.$atTranslated.' '.$hour.':'.$minutes.' '.$ampm;
	
}
function msfb_exists($data){
	if(!$data || $data==null || $data=='undefined') return false;
	else return true;
}
function msfb_modText($text){	
	//return msfb_nl2br(msfb_autoLink(msfb_escapeTags($text)));
	return msfb_nl2br(msfb_escapeTags($text));
}
	
function msfb_escapeTags($str){	
	$new_str1=str_replace("<","&lt;",$str);
	$new_str2=str_replace(">","&gt;",$new_str1);
	return  $new_str2;
}
	
function msfb_nl2br($str){	
	return str_replace(array("\r\n","\n\r","\r","\n","\n\n"),"<br>", $str);
} 
function Msfb_Wall_Get_Avatar_Url($id){ $msfbAvURL='https://graph.facebook.com/'.$id.'/picture?type=square'; return $msfbAvURL; }
//Get JSON object of feed data
function Msfb_Wall_Get_Graph_API_Data($url){
	//if cURL is available and enabled in server
 if(is_callable('curl_init')){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);//addition
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$msfbJsonData = curl_exec($ch);
	curl_close($ch);
//curl is not available use file_get_contents
} else { if ( ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') === TRUE ) {
	$msfbJsonData = @file_get_contents($url);	
	//If above ways fails use wordpress HTTP API
} else {
	if( !class_exists( 'WP_Http' ) ) include_once( ABSPATH . WPINC. '/class-http.php' );
	$request = new WP_Http;
	$result = $request->request($url);
	$msfbJsonData = $result1['body'];
} }
	return $msfbJsonData;
}		






