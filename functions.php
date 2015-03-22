<?php
/* 
 * Languages and Show functionality
 * Author: EDC Team
 * Since: 1.0
*/
include('files.php');

$books_languages = array(
"1"=>array("Afrikaans","za.png"),
"2"=>array("Albanian","al.png"),
"3"=>array("Amharic","amharic.png"),
"4"=>array("Arabic","arle.png"),
"5"=>array("Armenian","am.png"),
"6"=>array("Catalan","Catalan.png"),
"7"=>array("Awari","awari.png"),
"8"=>array("Azerbaijan","az.png"),
"9"=>array("Basaa","cm.png"),
"10"=>array("Bengali","bd.png"),
"11"=>array("Oromo","Oromo.png"),
"12"=>array("Bosnian","ba.png"),
"13"=>array("Brahui","Brahui.png"),
"14"=>array("Bulgarian","bg.png"),
"15"=>array("Burmese","mm.png"),
"16"=>array("Chechen","cc.png"),
"17"=>array("Chichewa","Chichewa.png"),
"18"=>array("Chinese","cn.png"),
"19"=>array("Comorian","comorian.png"),
"20"=>array("Czech","cs.png"),
"21"=>array("Danish","dk.png"),
"22"=>array("Deutsche","de.png"),
"23"=>array("Dutch","nl.png"),
"24"=>array("English","gb.png"),
"25"=>array("Estonian","ee.png"),
"26"=>array("Falatia","za.png"),
"27"=>array("Finlandian","fi.png"),
"28"=>array("French","fr.png"),
"29"=>array("Fulani","fulani.png"),
"30"=>array("Georgian","ge.png"),
"31"=>array("Greek","gr.png"),
"32"=>array("Hausa","hausa.png"),
"33"=>array("Hebrew","il.png"),
"34"=>array("Hindi","in.png"),
"35"=>array("Hungarian","hu.png"),
"36"=>array("Icelandic","ax.png"),
"37"=>array("Indonesia","id.png"),
"38"=>array("Italian","it.png"),
"39"=>array("Japanese","jp.png"),
"40"=>array("Kashmiri","Kashmiri.png"),
"41"=>array("Kazakh","kz.png"),
"42"=>array("Khmer","kh.png"),
"43"=>array("Korean","kr.png"),
"44"=>array("Kurdish","kd.png"),
"45"=>array("Kyrgyz","kg.png"),
"46"=>array("Latvian","lv.png"),
"47"=>array("Macedonian","mk.png"),
"48"=>array("Madagascan","mg.png"),
"49"=>array("Malay","my.png"),
"50"=>array("Maldivi","mv.png"),
"51"=>array("Malyalam","in.png"),
"52"=>array("Maranao","marano.png"),
"53"=>array("Nko","nko.png"),
"54"=>array("Nepali","np.png"),
"55"=>array("Norwegian","bv.png"),
"56"=>array("Pashto","poshto.png"),
"57"=>array("Persian","ir.png"),
"58"=>array("Polish","pl.png"),
"59"=>array("Portuguese","pt.png"),
"60"=>array("Romani-gypsy","romani.png"),
"61"=>array("Romania","ad.alt.png"),
"62"=>array("Russian","ru.png"),
"63"=>array("Sindhi","sindhi.png"),
"64"=>array("Sinhalese","lk.png"),
"65"=>array("Slovac","sk.png"),
"66"=>array("Somali","so.png"),
"67"=>array("Spanish","es.alt.png"),
"68"=>array("Swahili","swahili.png"),
"69"=>array("Swedish","se.png"),
"70"=>array("Tagalog","ph.png"),
"71"=>array("Tajik","tj.png"),
"72"=>array("Tamazight","tamazight.png"),
"73"=>array("Tamil","in.png"),
"74"=>array("Tashamiya","tashmanai.png"),
"75"=>array("Tatar","tt.png"),
"76"=>array("Telugu","in.png"),
"77"=>array("Thai","th.png"),
"78"=>array("Tigrinya","tigrinya.png"),
"79"=>array("Turkish","tr.png"),
"80"=>array("Turkmen","tk.png"),
"81"=>array("Ugandan","ug.png"),
"82"=>array("Ukrainian","ua.png"),
"83"=>array("Urdu","pk.png"),
"84"=>array("Uyghur","uyghur.png"),
"85"=>array("Uzbek","uz.png"),
"86"=>array("Vietnamese","vn.png"),
"87"=>array("Yoruba","yo.png"),
"88"=>array("Zulu","zulu.png")
);

class Free_Books_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Free_Books_Widget', // Base ID
			__('Islamic Books', 'edc_free_books_widget'), // Name
			array( 'description' => __( 'You can add 1 out of 88 languages', 'edc_free_books_widget' ), ) // Args
		);
	}
	
	function EDC_BOOKS($EDC_BOOK="",$language_id="",$booksrand="",$edc_free_books_allow_source="",$edc_free_books_allow_download="",$edc_free_books_allow_read="",$width="",$height="",$edc_slider_type=""){
global $books_languages;
//0 = $EDC_BOOK[$i][0] => id
//1 = $EDC_BOOK[$i][1] => title
//2 = $EDC_BOOK[$i][2] => author
//3 = $EDC_BOOK[$i][3] => file
//4 = $EDC_BOOK[$i][4] => image
//5 = $EDC_BOOK[$i][5] => category id
//6 = $EDC_BOOK[$i][6] => language shortname
//7 = $EDC_BOOK[$i][7] => source

$language_name = $books_languages[$language_id][0];
$EDC_BOOK = $EDC_BOOK[''.$language_name.''];
	
$books_count = count($EDC_BOOK);
$i = $booksrand;

if($EDC_BOOK[$i][1] == ""){ $title = ''; }else{ $title = $EDC_BOOK[$i][1]; }
if($EDC_BOOK[$i][2] == ""){ $author = ''; }else{ $author = 'Author: '.htmlspecialchars($EDC_BOOK[$i][2]).''; }
if($EDC_BOOK[$i][7] == ""){ $url = ''; }else{ $url = htmlspecialchars($EDC_BOOK[$i][7]); }
if($EDC_BOOK[$i][4] == ""){ $image = ''; }else{ $image = '<img class="edc_image_book" src="'.htmlspecialchars($EDC_BOOK[$i][4]).'" alt="'.htmlspecialchars($title).'" title="'.htmlspecialchars($title).'" />'; }

if($EDC_BOOK[$i][3] == ""){
$download = '';
}else{
if($edc_slider_type == 0){
$download = '<div class="edc_icons_content_for_just_link">';
}else{
$download = '<div class="edc_icons_content">';
}
if($edc_free_books_allow_source == 1){
$download .= '<a target="_blank" href="'.htmlspecialchars($EDC_BOOK[$i][7]).'"><img class="edc_icons" src="'.plugin_dir_url( __FILE__ ).'/images/link.png" alt="Go to '.htmlspecialchars($EDC_BOOK[$i][1]).'" title="'.htmlspecialchars($EDC_BOOK[$i][1]).'" /></a>';
}
if($edc_free_books_allow_read == 1){
$download .= '<a target="_blank" href="https://docs.google.com/viewer?url='.htmlspecialchars($EDC_BOOK[$i][3]).'"><img class="edc_icons" src="'.plugin_dir_url( __FILE__ ).'/images/pdf.png" alt="Read '.htmlspecialchars($EDC_BOOK[$i][1]).'" title="Read '.htmlspecialchars($EDC_BOOK[$i][1]).'" /></a>';
}
if($edc_free_books_allow_download == 1){
$download .= '<a target="_blank" href="'.htmlspecialchars($EDC_BOOK[$i][3]).'"><img class="edc_icons" src="'.plugin_dir_url( __FILE__ ).'/images/download.png" alt="Download '.htmlspecialchars($EDC_BOOK[$i][1]).'" title="Download '.htmlspecialchars($EDC_BOOK[$i][1]).'" /></a>';
}
$download .= '</div>';
}


	if($books_count == 0){
		$code = '<div id="books_content_widget">Sorry, Not found books in '.$language_name.' language.</div>';
	}else{
		if($edc_slider_type == 0){
			$code = '<li>'.$download.'<a target="_blank" href="'.$url.'" title="'.$author.'">'.$title.'</a><div style="clear:both;"></div></li>'."\n";
		}else{
			if($EDC_BOOK[$i][4] != ""){
				$code = '<li>'.$download.'<a target="_blank" href="'.$url.'">'.$image.'</a></li>';
			}else{
				$code = '';
			}
		}
	}

return $code;
}

	public function widget( $args, $instance ) {
		global $books_languages,$EDC_BOOK;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$edc_free_books_id = $instance['edc_free_books_id'];
		$edc_free_books_language_shortname = $instance['edc_free_books_language_shortname'];
		$edc_free_books_allow_source = $instance['edc_free_books_allow_source'];
		$edc_free_books_allow_download = $instance['edc_free_books_allow_download'];
		$edc_free_books_allow_read = $instance['edc_free_books_allow_read'];
		$edc_free_books_width = $instance['edc_free_books_width'];
		$edc_free_books_height = $instance['edc_free_books_height'];
		$edc_free_books_limit = $instance['edc_free_books_limit'];
		$edc_slider_type = $instance['edc_slider_type'];

		if(empty($edc_free_books_width)){ $width = 200; }else{ $width = $edc_free_books_width; }
		if(empty($edc_free_books_height)){ $height = 244; }else{ $height = $edc_free_books_height; }
		if(empty($edc_free_books_limit)){ $books_limit = 1; }else{ $books_limit = $edc_free_books_limit; }

$language_name = $books_languages[$edc_free_books_id][0];
$language_flag = $books_languages[$edc_free_books_id][1];

$rands = rand(0,999);
$languagescount = count($books_languages);

$bookscount = count($EDC_BOOK[''.$language_name.'']);
if($books_limit > $bookscount){ $limit = $bookscount; }else{ $limit = $books_limit; }

if($edc_free_books_id > $languagescount){
$code = '<p style="color:red; text-align:center; padding:10px;">Error ID!</p>';
}else{
$code_js = "<script type=\"text/javascript\">"."\n";
$code_js .= "(function($){	
  $(function(){";
$code_js .= "$('#bxslider".$edc_free_books_id."').bxSlider({"."\n";
if($edc_slider_type == 1){
$code_js .= "mode: 'fade',
  captions: true"."\n";
$extracode = '';
}elseif($edc_slider_type == 2){
$code_js .= "auto: true,
  autoControls: true"."\n";
$extracode = '';
}elseif($edc_slider_type == 3){
$code_js .= "infiniteLoop: false,
  hideControlOnEnd: true"."\n";
$extracode = '';
}elseif($edc_slider_type == 4){
$code_js .= "adaptiveHeight: true,
  mode: 'fade'"."\n";
$extracode = '';
}elseif($edc_slider_type == 5){
$code_js .= "slideWidth: 300,
    minSlides: 2,
    maxSlides: 2,
    slideMargin: 10"."\n";
$extracode = '';
}elseif($edc_slider_type == 6){
$code_js .= "minSlides: 2,
  maxSlides: 2,
  slideWidth: 360,
  slideMargin: 10"."\n";
$extracode = '';
}elseif($edc_slider_type == 7){
$code_js .= "minSlides: 3,
  maxSlides: 4,
  slideWidth: 170,
  slideMargin: 10"."\n";
$extracode = '';
}elseif($edc_slider_type == 8){
$code_js .= "mode: 'vertical',
  slideMargin: 5"."\n";
$extracode = '';
}elseif($edc_slider_type == 9){
$code_js .= "nextSelector: '#slider-next',
  prevSelector: '#slider-prev',
  nextText: 'Next &#8594;',
  prevText: '&#8592; Prev'"."\n";
$extracode = '<div class="outside">
<p><span id="slider-prev"></span> | <span id="slider-next"></span></p>
</div>';
}else{
$code_js .= "mode: 'fade',
  captions: true"."\n";
$extracode = '';
}
$code_js .= "});"."\n";
$code_js .= "});	
}(jQuery))";
$code_js .= "</script>"."\n";

if($edc_slider_type == 0){
$code = '';
}else{
$code = $code_js."\n";
}
$code .= '<div class="edcbooks">'."\n";
$code .= '<ul id="bxslider'.$edc_free_books_id.'">'."\n";
for($x=0; $x<$limit; ++$x){
$booksrand = rand(0,$bookscount-1);
$code .= $this->EDC_BOOKS($EDC_BOOK, $edc_free_books_id, $booksrand, $edc_free_books_allow_source, $edc_free_books_allow_download, $edc_free_books_allow_read, $width, $height, $edc_slider_type)."\n";
if(($x+1) == $limit){
$code .= '';
}else{
//$code .= '<div class="space_books"></div>';
}
}
$code .= '</ul>'."\n";
$code .= '</div>'."\n";
$code .= $extracode;
}

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo __( ''.$code.'', 'edc_free_books_widget' );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		global $books_languages;
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			$edc_free_books_id = $instance['edc_free_books_id'];
			$edc_free_books_language_shortname = $instance['edc_free_books_language_shortname'];
			$edc_free_books_allow_source = $instance['edc_free_books_allow_source'];
			$edc_free_books_allow_download = $instance['edc_free_books_allow_download'];
			$edc_free_books_allow_read = $instance['edc_free_books_allow_read'];
			$edc_free_books_width = $instance['edc_free_books_width'];
			$edc_free_books_height = $instance['edc_free_books_height'];
			$edc_free_books_limit = $instance['edc_free_books_limit'];
			$edc_slider_type = $instance['edc_slider_type'];
		}else{
			$title = __( 'Islamic Books', 'edc_free_books_widget' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
		<select id="<?php echo $this->get_field_id('edc_free_books_id'); ?>" name="<?php echo $this->get_field_name('edc_free_books_id'); ?>">
		<?php for($i = 1; $i <= count($books_languages); $i++): ?>
		<option title="<?php echo $books_languages[$i][0]; ?>" value="<?php echo $i; ?>" <?php echo ( $edc_free_books_id == $i ) ? 'selected="selected"' : ''; ?>><?php echo $i.'- '.$books_languages[$i][0]; ?></option>
		<?php endfor; ?>
		</select>
		<label for="<?php echo $this->get_field_id('edc_free_books_id'); ?>"> 
		<?php _e('Languages', 'edc_free_books_widget'); ?>
		</label>
		</p>
		 
		<p>
		<label for="<?php echo $this->get_field_id('edc_free_books_allow_source'); ?>"> 
		<input id="<?php echo $this->get_field_id('edc_free_books_allow_source'); ?>" name="<?php echo $this->get_field_name('edc_free_books_allow_source'); ?>" type="checkbox" <?php if($edc_free_books_allow_source) { echo 'checked="checked"'; } ?> /> 
		<?php _e('Source icon', 'edc_free_books_widget'); ?>
		</label>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('edc_free_books_allow_read'); ?>"> 
		<input id="<?php echo $this->get_field_id('edc_free_books_allow_read'); ?>" name="<?php echo $this->get_field_name('edc_free_books_allow_read'); ?>" type="checkbox" <?php if($edc_free_books_allow_read) { echo 'checked="checked"'; } ?> /> 
		<?php _e('Read icon', 'edc_free_books_widget'); ?>
		</label>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('edc_free_books_allow_download'); ?>"> 
		<input id="<?php echo $this->get_field_id('edc_free_books_allow_download'); ?>" name="<?php echo $this->get_field_name('edc_free_books_allow_download'); ?>" type="checkbox" <?php if($edc_free_books_allow_download) { echo 'checked="checked"'; } ?> /> 
		<?php _e('Download icon', 'edc_free_books_widget'); ?>
		</label>
		</p>
		<!--
		<p>
		<label for="<?php echo $this->get_field_id( 'edc_free_books_width' ); ?>"><?php _e( 'Image width:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'edc_free_books_width' ); ?>" name="<?php echo $this->get_field_name( 'edc_free_books_width' ); ?>" type="text" value="<?php if(empty($edc_free_books_width)){ echo 200; }else{ echo esc_attr( $edc_free_books_width ); } ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'edc_free_books_height' ); ?>"><?php _e( 'Image height:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'edc_free_books_height' ); ?>" name="<?php echo $this->get_field_name( 'edc_free_books_height' ); ?>" type="text" value="<?php if(empty($edc_free_books_height)){ echo 244; }else{ echo esc_attr( $edc_free_books_height ); } ?>" />
		</p>
		-->
		<p>
		<label for="<?php echo $this->get_field_id( 'edc_free_books_limit' ); ?>"><?php _e( 'Books limit:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'edc_free_books_limit' ); ?>" name="<?php echo $this->get_field_name( 'edc_free_books_limit' ); ?>" type="text" value="<?php if(empty($edc_free_books_limit)){ echo 1; }else{ echo esc_attr( $edc_free_books_limit ); } ?>" />
		</p>
		
		<p>
		<select id="<?php echo $this->get_field_id('edc_slider_type'); ?>" name="<?php echo $this->get_field_name('edc_slider_type'); ?>">
		<option value="1" <?php echo ( $edc_slider_type == 1 ) ? 'selected="selected"' : ''; ?>>1. Image slideshow with captions</option>
		<option value="2" <?php echo ( $edc_slider_type == 2 ) ? 'selected="selected"' : ''; ?>>2. Auto show with start / stop controls</option>
		<option value="3" <?php echo ( $edc_slider_type == 3 ) ? 'selected="selected"' : ''; ?>>3. Manual show without infinite loop</option>
		<option value="4" <?php echo ( $edc_slider_type == 4 ) ? 'selected="selected"' : ''; ?>>4. Slideshow using adaptiveHeight</option>
		<option value="5" <?php echo ( $edc_slider_type == 5 ) ? 'selected="selected"' : ''; ?>>5. Carousels demystified - in depth explanation with examples</option>
		<option value="6" <?php echo ( $edc_slider_type == 6 ) ? 'selected="selected"' : ''; ?>>6. Carousel - static number of slides showing</option>
		<option value="7" <?php echo ( $edc_slider_type == 7 ) ? 'selected="selected"' : ''; ?>>7. Carousel - dynamic number of slides showing</option>
		<option value="8" <?php echo ( $edc_slider_type == 8 ) ? 'selected="selected"' : ''; ?>>8. Vertical slideshow</option>
		<option value="9" <?php echo ( $edc_slider_type == 9 ) ? 'selected="selected"' : ''; ?>>9. Custom next / prev control selectors</option>
		<option value="0" <?php echo ( $edc_slider_type == 0 ) ? 'selected="selected"' : ''; ?>>10. Just Links</option>
		</select>
		<label for="<?php echo $this->get_field_id('edc_slider_type'); ?>"> 
		<?php _e('Slider Type', 'edc_free_books_widget'); ?>
		</label>
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['edc_free_books_id'] = $new_instance['edc_free_books_id'];
		$instance['edc_free_books_language_shortname'] = $new_instance['edc_free_books_language_shortname'];
		$instance['edc_free_books_width'] = $new_instance['edc_free_books_width'];
		$instance['edc_free_books_height'] = $new_instance['edc_free_books_height'];
		$instance['edc_free_books_limit'] = $new_instance['edc_free_books_limit'];
		$instance['edc_free_books_allow_source'] = ( isset( $new_instance['edc_free_books_allow_source'] ) ? 1 : 0 );
		$instance['edc_free_books_allow_read'] = ( isset( $new_instance['edc_free_books_allow_read'] ) ? 1 : 0 );
		$instance['edc_free_books_allow_download'] = ( isset( $new_instance['edc_free_books_allow_download'] ) ? 1 : 0 );
		$instance['edc_slider_type'] = intval($new_instance['edc_slider_type']);
		return $instance;
	}

}

function register_Free_Books_Widget() {
    register_widget( 'Free_Books_Widget' );
}
add_action( 'widgets_init', 'register_Free_Books_Widget' );

?>