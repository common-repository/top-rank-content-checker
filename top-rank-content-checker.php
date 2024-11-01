<?php 
/**
 * Plugin Name: Top Rank Content Checker
 * Plugin URI: https://ruana.co.jp/top-rank-content-checker
 * Description: This is keyword rank checker in Classic Editor.You could view top rank contents rapidly.
 * Version: 1.0.1
 * Author: Ruana LLC
 * Author URI: https://ruana.co.jp
 * Text Domain: top-rank-content-checker
 * Domain Path: /languages/
 *
 * Copyright 2019 Ruana LLC (email : r.kurosu@ruana.co.jp)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require_once(  plugin_dir_path( __FILE__ )  . 'functions.php' );

define( 'TRCC_VERSION', '1.0.1' );
define( 'TRCC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'TRCC_PLUGIN_NAME', trim( dirname( TRCC_PLUGIN_BASENAME ), '/' ) );
define( 'TRCC_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'TRCC_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
define( 'TRCC_PREFIX', 'trcc_' );

/**
 * Main Class
 */
class TRCC_Main{
	protected $textdomain = 'top-rank-content-checker';
	public function __construct() {
		$this->init();
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'load_plugin_css' ) );
    add_action( 'admin_print_styles', array( $this, 'head_css' ) );
    add_action( 'admin_print_scripts', array( $this, "head_js" ) );
    add_action( 'add_meta_boxes', array($this,'add_editor_meta_box'),'post','normal','high');
    add_action( 'wp_ajax_main_check_run', array($this,'main_check_run') );

		/**
		 * プラグインの有効化・無効化・削除時
		 */
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );
		register_uninstall_hook(__FILE__, array( $this, 'plugin_uninstall' ) );
	}


  public function add_editor_meta_box() {
    add_meta_box('top-rank-content-checker',
      $this->_('Top Rank Content Checker','上位表示コンテンツチェッカー'),
      array($this,'top_rank_content_checker_main'),
      'post',
      'normal',
      'low');
  }

  public function admin_menu() {
    add_submenu_page( 'tools.php', 
      $this->_( 'Top Rank Content Checker','上位表示コンテンツチェッカー' ), 
      $this->_( 'Top Rank Content Checker','上位表示コンテンツチェッカー' ), 
      'level_7',
      TRCC_PLUGIN_NAME,
      array( $this, 'show_options_page', ) );
  }

	 /**
    * Admin Panel Rooting
    */
   public function setting_url($view = ''){
    $query = array(
      'page' => $this->textdomain
    );
    if( $view ){
      $query['view'] = $view;
    }
    return admin_url('tools.php?'.http_build_query($query));
  }

  /**
   * CSS
   */
  public function load_plugin_css() {

  }

  /**
   * 管理画面CSS追加
   */
  public function head_css() {
    if (  isset($_REQUEST["page"]) && $_REQUEST["page"] == TRCC_PLUGIN_NAME ) {
      wp_enqueue_style('bootstrap-style', TRCC_PLUGIN_URL . '/includes/css/bootstrap.min.css');
    }
    wp_enqueue_style( 'trcc_style', TRCC_PLUGIN_URL.'/includes/css/trcc_style.css' );
  }

  /*
   * 管理画面JS追加
   */
  public function head_js() {
    if (  isset($_REQUEST["page"]) && $_REQUEST["page"] == TRCC_PLUGIN_NAME ) {
      wp_enqueue_script( "bootstrap-script",TRCC_PLUGIN_URL . '/includes/js/bootstrap.min.js' );
    }
    wp_enqueue_script('trcc_js',TRCC_PLUGIN_URL.'/includes/js/trcc.js');
    wp_localize_script( 'trcc_js', 'objectL10n', array(
      'error'  => $this->_('Could not get data. Please use again after a while.','データが取得できませんでした。しばらく経って再度利用してください。'),
      'check_btn' => $this->_('Check Now','データを取得'),
      'spinner' => admin_url('images/spinner-2x.gif'),
      'ajaxurl' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce( "main_check_run_nonce" )
    ) );
  }




    /**
     * プラグインのメインページ
     */
    public function show_options_page() {
      require_once TRCC_PLUGIN_DIR . '/admin/index.php';
    }


	/**
	 * 多言語化
	 */
	private function init() {
		load_plugin_textdomain( $this->textdomain, false, basename( dirname( __FILE__ ) ) . '/languages/' );
    register_setting(TRCC_PREFIX . 'option_group',TRCC_PREFIX . 'google_custom_search_key');
    register_setting(TRCC_PREFIX . 'option_group',TRCC_PREFIX . 'google_cx');
  }

  public function top_rank_content_checker_main() {
    if(get_option(TRCC_PREFIX . 'google_custom_search_key') && get_option(TRCC_PREFIX . 'google_cx')){
      echo '<p>'. $this->_('Set Yor Keyword','キーワードを入力してください。') . '</p>';
      echo '<input class="form-input-tip ui-autocomplete-input" type="text" id="trcc_keyword" placeholder="'. $this->_('Set Yor Keyword','キーワードを入力してください。') . '">';
      echo '<div id="trcc_result">';
      echo '<center>';
      echo '<button class="button button-primary button-large" id="trcc_check_button">' . $this->_('Check Now','データを取得') . '</button>';
      echo '</center>';
      echo '</div>';
    }else{
      echo '<p>' . $this->_('You have not set Google search key yet.','あなたはまだ Google検索キー　を設定していません。') . '</p>';
      echo '<p><a href="' .$this->setting_url('setting').'">Setting Now</a></p>';
    }
  }
  /**
   * ロード時に読み込む初期設定用の関数
   */
  public function plugin_activation(){
    //
  }

  /**
   * 無効化時
   */
  public function plugin_deactivation() {
    //
  }
  /**
   * 削除時
   */
  public function plugin_uninstall() {
  	//
  }

  public function is_pro(){
    if( $options = get_option('trcc_options')){
      $is_pro = $options['pro'];
    }else{
      $is_pro = false;
    }
    return $is_pro;
  }

  public function need_pro_addons(){
    if($this->is_pro()){
      // no echo
    }else{
      echo "<a class=\"nav-link\" href=\"" .$this->setting_url('addon')."\"><u>";
      $this->e('This function needs addons.Please see Add-ons page');
      echo "</u></a>";
    }
  }

  public function main_check_run(){
    check_ajax_referer( 'main_check_run_nonce', 'nonce' );
    $keywords = $_POST['keywords'];
    if($keywords == ""){
      $result  = '<p>' . $this->_('No keywords have been set. Please reload after setting the keyword.','キーワードが設定されていません。キーワードを設定したら再読込してください。') .'</p>';
    }else{
      try {

        $key = get_option(TRCC_PREFIX . 'google_custom_search_key');
        $cx = get_option(TRCC_PREFIX . 'google_cx');
        if($key && $cx){
          $keywords = str_replace([' ','　'],'+',$keywords);
          $url = "https://www.googleapis.com/customsearch/v1?num=10&cx={$cx}&key={$key}&alt=json&q=".urlencode($keywords);
          $content = wp_remote_get( $url );

          /**
           * ERROR HANDLING
           */
          if ( ! is_wp_error( $content ) && $content['response']['code'] === 200 ) {
            $google_url_list = [];
            $data = json_decode($content['body'],true);
            foreach($data['items'] as $key => $value){
              $google_url_list[] = $value['link'];
              if(!$this->is_pro() && count($google_url_list) >= 3){
                break;
              }
            }
            $result = "";
            foreach($google_url_list as $key => $value){
              try{
                $remote_get = wp_remote_get($value);
                if ( ! is_wp_error( $remote_get ) && $remote_get['response']['code'] === 200 ) {
                  $html = $remote_get['body'];
                  $url = $value;


                  preg_match_all('/<title>(.+)<\/title>/u', $html, $title_matches);
                  $title = "";
                  if(!empty($title_matches)){
                    $title = $title_matches[1][0];
                  }

                  $plane_html = preg_replace('/<script.*?>(.*?)<\/script>/mis', "", $html);
                  $plane_html = preg_replace('/<style.*?>(.*?)<\/style>/mis', "", $plane_html);
                  $plane_html = preg_replace('/<iframe.*?>(.*?)<\/iframe>/mis', "", $plane_html);
                  $plane_html = strip_tags($plane_html);
                  $plane_html = $this->__trim($plane_html);
                  $str_count = mb_strlen($plane_html);

                  preg_match_all('/<h([1-6]).*?>(.+)<\/h([1-6])>/u', $html, $matches);
                  $matches_count = count($matches[0]);
                  if(empty($matches)){
                    $result  = '<p>' . $this->_('Could not get data. Please use again after a while.','データが取得できませんでした。しばらく経って再度利用してください。') .'</p>';
                    $result  .= '<center><button class="button button-primary button-large" id="trcc_check_button">' . $this->_('Check Now','データを取得') .'</button></center>';
                  }else{
                    $result .= '<p class="archive_rank"><b>検索順位：'.($key + 1).'位</b></p>';
                    $result .= '<p class="archive_title">[title]'.$title . " <a href='".$url."' target='_blank' rel='nofollow'>".$this->_('View this site','サイトを見る')."</a></p>";
                    $result .= '<small>文字数：'.$str_count.'</small>';
                    for ($i = 0; $i < $matches_count; $i++){
                      $matches[2][$i] = strip_tags($matches[2][$i]);
                      if($matches[2][$i] != ""){
                        if($this->is_pro()){
                          $result .= "<p class='archive_headline'><span class=\"dashicons dashicons-plus-alt add_headline\"></span>[h" . $matches[1][$i] . "]" . $matches[2][$i] . "</p>";
                        }else{
                          $result .= "<p class='archive_headline'>[h" . $matches[1][$i] . "]" . $matches[2][$i] . "</p>";
                        }
                      }
                    }
                    $result .= "<hr/>";
                    if(!$this->is_pro()){
                      $result .= "...<a href='" . $this->setting_url('addon') ."'>" .$this->_('And More','より多くの上位表示コンテンツを表示するには？') ."</a>";
                    }
                  }   
                }
              }catch(Exception $e){
          // echo $e->getMessage();
              } 
            }
          }
        }
      } catch (Exception $e) {
        // echo $e->getMessage();
      }
    }
    echo $result;
  }
  /**
   * esc_htmlの配列対応版
   */
  public function esc_htmls( $str ) {
   if ( is_array( $str ) ) {
    return array_map( "esc_html", $str );
  }else {
    return esc_html( $str );
  }
}

  /**
   * Load template file
   *
   * @param string $name
   */
  public function get_template($name){
   $path = TRCC_PLUGIN_DIR."{$name}.php";
   if( file_exists($path) ){
    include $path;
  }
}

  /**
   * return $_REQUEST
   *
   * @param string $key
   * @return mixed
   */
  public function request($key){
   if(isset($_REQUEST[$key])){
    return $_REQUEST[$key];
  }else{
    return null;
  }
}
public function __trim($str)
{
  $str = trim($str);
  $str = preg_replace('/[^ぁ-んァ-ヶーa-zA-Z0-9一-龠０-９\-\r、。]+/u','' ,$str);
  $str = preg_replace('/[\n\r\t]/', '', $str);
  $str = preg_replace('/\s(?=\s)/', '', $str);
  return $str;
}

    /**
     * 翻訳用
     */
    public function e( $text, $ja = null ) {
    	_e( $text, $this->textdomain );
    }
    public function _( $text, $ja = null ) {
    	return __( $text, $this->textdomain );
    }
  }
  $trcc = new TRCC_Main();