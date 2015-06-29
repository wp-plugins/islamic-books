<?php
/**
 * @package Islamic Books by EDC
 * @version 2.1
 */
/*
 Plugin Name: Islamic Books by EDC
 Plugin URI: http://www.islam.com.kw/support
 Description: The Islamic Books Plugin by EDC endeavors to be a unique comprehensive online store of free downloadable PDF books about Islam, Muslims, and other faiths in different languages.
 Version: 2.1
 Author: EDC Team (E-Da`wah Committee)
 Author URI: http://www.islam.com.kw
 License: It is Free -_-
*/

include('functions.php');

function edc_free_books_plugin_install(){
     add_option( 'edc_category_id', 3, '', 'yes' ); 
     add_option( 'edc_view_js', 1, '', 'yes' ); 
}
register_activation_hook(__FILE__,'edc_free_books_plugin_install'); 

function edc_free_books_plugin_scripts(){
	if(get_option('edc_view_js') == 1){
	 wp_register_script('edc_free_books_plugin_scripts2',plugin_dir_url( __FILE__ ).'js/bxslider/jquery.min.js');
     wp_enqueue_script('edc_free_books_plugin_scripts2');
    }
     wp_register_script('edc_free_books_plugin_scripts',plugin_dir_url( __FILE__ ).'js/bxslider/jquery.bxslider.min.js');
     wp_enqueue_script('edc_free_books_plugin_scripts');
     //wp_enqueue_script( 'jquery-query' );
}
add_action('wp_enqueue_scripts','edc_free_books_plugin_scripts'); 

function edc_free_books_plugin_styles() {
	wp_register_style( 'edc-styles2', plugin_dir_url( __FILE__ ).'style.css' );
	wp_register_style( 'edc-styles', plugin_dir_url( __FILE__ ).'js/bxslider/jquery.bxslider.css' );
	wp_enqueue_style( 'edc-styles' );
	wp_enqueue_style( 'edc-styles2' );
}
add_action( 'wp_enqueue_scripts', 'edc_free_books_plugin_styles' );

function edc_books_adminHeader() {
	echo "<style type=\"text/css\" media=\"screen\">\n";
	echo "#free-books { width:100%; margin:0; border:0px solid #cccccc; padding:0; }\n";
	echo "#free-books .widget { margin:0; border:1px solid #cccccc; background-color:#fff; padding:10px; margin-top:0px; }\n";
	echo "#free-books .viewbook { margin:0; border:1px solid #cccccc; background-color:#fff; padding:10px; margin-top:15px; }\n";
	echo "#free-books .viewbook p { margin:0 0 5px 0; }\n";
	echo "#free-books .viewbook p.title span { color:#333; }\n";
	echo "#free-books .viewbook p.author span { color:blue; }\n";
	echo "#free-books .viewbook p.download span { color:green; }\n";
	echo "#free-books .viewbook p.title a, #free-books .viewbook p.download a { text-decoration:none; }\n";
	echo "#free-books .viewbook li { margin:0 0 15px 0; padding:0 0 10px 0; border-bottom:1px solid #cccccc; }\n";
	echo "#free-books .shortcode { margin:15px 0 0 0; padding:10px; border:1px solid #000000; background-color:#333333; text-align:center; color:#ffffff;; }\n";
	echo "#free-books .shortcode span { color:yellow; }\n";
	do_action('edc_css');
	echo "</style>\n";
}

add_action('admin_head','edc_books_adminHeader');
add_action( 'admin_menu', 'edc_books_plugin_menu' );

function edc_books_plugin_menu() {
	global $EDC_words;
	add_menu_page( $EDC_words['title'], $EDC_words['title'], 'manage_options', 'edc-free-books-edit', 'edc_free_books_options', ''.trailingslashit(plugins_url(null,__FILE__)).'/i/book.png' );
}

function EDC_Books_view_categories($type=0){
global $EDC_category;

$categories = count($EDC_category);

if($type == 1){
	$code = '<ul>';
	for($i=1; $i <= $categories; $i++){
		if($EDC_category[$i][4] == 0){
		$code .= '<li>'.$EDC_category[$i][1].'</li>';
		}else{
		$code .= '<li>-- '.$EDC_category[$i][1].'</li>';
		}
	}
	$code .= '</ul>';
}else{
	$code = '<select name="edc_category_id" id="edc_category_id">';
	for($i=1; $i <= $categories; $i++){
		if(get_option('edc_category_id') == $EDC_category[$i][0]){
		$selected = ' selected="selected"';
		}else{
		$selected = '';
		}
		
		if($EDC_category[$i][4] == 0){
		$code .= '<option value="'.intval($EDC_category[$i][0]).'"'.$selected.'>'.$EDC_category[$i][1].'</option>';
		}else{
		$code .= '<option value="'.intval($EDC_category[$i][0]).'"'.$selected.'>- '.$EDC_category[$i][1].'</option>';
		}
	}
	$code .= '</select>';
}

return $code;
}


function EDC_Books_view_books($category_id=0, $view_image=0){
global $post, $EDC_category_info, $EDC_books_id, $EDC_words, $_GET;

$books = count($EDC_books_id[$category_id]);

$page = (int) (!isset($_GET["pages"]) ? 1 : $_GET["pages"]);
$page = ($page == 0 ? 1 : $page);
$perpage = 20;
$startpoint = ($page * $perpage) - $perpage;
$endpoint = ($startpoint + $perpage);
$pagesnum = @ceil($books / $perpage);

if($page > $pagesnum){
$code = '<p>Error page!</p>';
}else{
$code = '<div id="free-books">';
$code .= '<h2>'.$EDC_words['category'].' '.$EDC_category_info[$category_id][1].' <span style="font-size:12px; color:green;">'.$books.' '.$EDC_words['books'].'</span></h2>';
$code .= '<ul>';
for($i=$startpoint; $i < $endpoint; $i++){
if($i >= $books){
$code .= '';
}else{
$book_id = $EDC_books_id[$category_id][$i];
$code .= '<li>';
if($view_image == 1){
$code .= EDC_Books_info_with_image($book_id);
}else{
$code .= EDC_Books_info($book_id);
}
$code .= '</li>';
}
}

$code .= '</ul>';
if($pagesnum > 1){
$code .= '<div class="perpage">';
for ($i=1; $i<=$pagesnum; $i++) {
if ($i != $page) {
if($view_image == 1){
$pagelink = add_query_arg( 'pages', $i, get_permalink($post->ID) );
$z = '[<a href="'.$pagelink.'">'.$i.'</a>] ';
}else{
$z = '[<a href="admin.php?page=edc-free-books-edit&pages='.$i.'">'.$i.'</a>] ';
}
} else {
$z = '[<u>'.$i.'</u>]';
}
$code .= $z;
}
$code .= '</div>';
}
$code .= '</div>';
}
return $code;
}

function EDC_Books_info($book_id=0){
global $EDC_category_info, $EDC_book_info, $EDC_words;

//$books = count($EDC_books_id[$category_id]);
$book_info = $EDC_book_info[$book_id];
$lang_string = explode("/", $book_info[5]);
if($lang_string[3] == ""){
$lang_title = '';
}else{
$lang_title = '?lang='.ucwords($lang_string[3]);
}

$code = '<p class="title">'.$EDC_words['booktitle'].' <a target="_blank" href="'.$book_info[5].''.$lang_title.'"><span>'.$book_info[0].'</span></a></p>';
if($book_info[1] == ""){
$code .= '';
}else{
$code .= '<p class="author">'.$EDC_words['bookauthor'].' <span>'.$book_info[1].'</span></p>';
}
$code .= '<p class="download">'.$EDC_words['bookdownload'].' <a target="_blank" href="'.$book_info[2].'"><span>'.$book_info[2].'</span></a></p>';
$code .= '<p class="download">'.$EDC_words['bookimage'].' <a target="_blank" href="'.$book_info[3].'"><span>'.$book_info[3].'</span></a></p>';

return $code;
}

function EDC_Books_info_with_image($book_id=0){
global $EDC_category_info, $EDC_book_info, $EDC_words;

//$books = count($EDC_books_id[$category_id]);
$book_info = $EDC_book_info[$book_id];
$lang_string = explode("/", $book_info[5]);
if($lang_string[3] == ""){
$lang_title = '';
}else{
$lang_title = '?lang='.ucwords($lang_string[3]);
}
$download_string = explode("/", $book_info[2]);
$code = '';
$code .= '<div class="image"><a target="_blank" href="'.$book_info[3].'"><img src="'.$book_info[3].'" alt="'.$book_info[0].'" title="'.$book_info[0].'" /></a></div>';
$code .= '<p class="title">'.$EDC_words['booktitle'].' <a target="_blank" href="'.$book_info[5].''.$lang_title.'"><span>'.$book_info[0].'</span></a></p>';
if($book_info[1] == ""){
$code .= '';
}else{
$code .= '<p class="author">'.$EDC_words['bookauthor'].' <span>'.$book_info[1].'</span></p>';
}
//$code .= '<p class="download">'.$EDC_words['bookdownload'].' <a target="_blank" href="'.$book_info[2].'"><span>'.$download_string[5].'</span></a></p>';
$code .= '<p class="download">'.$EDC_words['bookdownload'].' <a target="_blank" href="'.$book_info[2].'"><img src="'.plugin_dir_url( __FILE__ ).'/i/download.png" alt="" /></a></p>';
$code .= '<div style="clear:both;"></div>';
return $code;
}

function EDC_books_replace ($content){
$text = preg_replace('/EDC_books\[([0-9]*?)\]/e','EDC_Books_view_books(\\1,1)',$content);
return $text;
}
add_filter('the_content','EDC_books_replace');

function edc_free_books_options() {
	global $books_languages;
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

if(isset($_POST['submitted']) && $_POST['submitted'] == 1){
	if ( get_option( 'edc_category_id' ) !== false ) {
		update_option( 'edc_category_id', intval($_POST['edc_category_id']) );
		update_option( 'edc_categoty_title', addslashes($_POST['edc_categoty_title']) );
		update_option( 'edc_view_js', addslashes($_POST['edc_view_js']) );
	} else {
		add_option( 'edc_category_id', 3 );
		add_option( 'edc_categoty_title', $EDC_words['title'], null );
		add_option( 'edc_view_js', 1, null );
	}
}

$edc_category_id = intval(get_option('edc_category_id'));
$edc_categoty_title = strip_tags(get_option('edc_categoty_title'));
$edc_view_js = intval(get_option('edc_view_js'));
global $EDC_words;
?>
	<div id="free-books">
	
			<div class="widget">				
				<h2><?php echo $EDC_words['pluginname']; ?></h2>
				<p><?php echo $EDC_words['plugindescription']; ?></p>
				<p><a href="widgets.php"><?php echo $EDC_words['insertwidget']; ?></a></p>
			
				<form name="sytform" action="" method="post">
					<input type="hidden" name="submitted" value="1" />
					<h3><?php echo $EDC_words['bookscategories']; ?></h3>
					<div>
						<input id="edc_categoty_title" type="text" name="edc_categoty_title" value="<?php echo htmlentities($edc_categoty_title); ?>" />
						<label for="edc_categoty_title"><?php echo $EDC_words['ifempty']; ?></label>
					</div>
					
					<div>
						<select name="edc_view_js" id="edc_view_js">
						<?php
							if($edc_view_js == 1){
							echo '<option value="1" selected="selected">'.$EDC_words['activate'].'</option>';
							echo '<option value="0">'.$EDC_words['inactivate'].'</option>';
							}else{
							echo '<option value="1">'.$EDC_words['activate'].'</option>';
							echo '<option value="0" selected="selected">'.$EDC_words['inactivate'].'</option>';
							}
						?>
					</select>
						<label for="edc_view_js"><?php echo $EDC_words['js']; ?></label>
					</div>
					
					<div>
					<?php echo EDC_Books_view_categories(0); ?> <label for="edc_category_id"><?php echo $EDC_words['selectcategory']; ?></label>
					</div>
					
					<div style="padding: 1.5em 0;margin: 5px 0;">
							<input type="submit" name="Submit" value="<?php echo $EDC_words['update']; ?>" />
					</div>
				</form>
				
				<div class="shortcode"><?php echo $EDC_words['shortcode']; ?> <span>EDC_books[<?php echo $edc_category_id; ?>]</span></div>
			</div>
						
			<div class="viewbook">
			<?php echo EDC_Books_view_books($edc_category_id); ?>
			</div>
	<div style="clear:both;"></div>
		
		</div>
<?php
}
