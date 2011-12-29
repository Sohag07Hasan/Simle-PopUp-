<?php
/*
 *Controls the whole plugin
 *  
 */


if(!class_exists('Simple_Popup')) : 
    class Simple_Popup{
        function __construct(){
            add_action('wp_footer', array($this, 'PopupHTML'));
            add_action('wp_head', array($this, 'enqueue_css_js'));
          //  add_action('init',array($this,'check'));
            
            add_action('wp_ajax_nopriv_popup_email_send', array($this, 'ajax_processing'));
            add_action('wp_ajax_popup_email_send', array($this, 'ajax_processing'));
        }
        
        function check(){
            var_dump(POPUP_CSS);
            var_dump(POPUP_JS);
            exit;
        }
        
        function ajax_processing(){
           
            if(!function_exists('wp_mail')){
                include ABSPATH . 'wp-includes/pluggable.php';
            }
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $phone = $_REQUEST['phone'];
            
            $subject = $name . 'has searched in your site' ;            
            $blogname = get_option('blogname');	
            $to = 'daniel.tynski@voltierdigital.com';
            $headers = 'From : '.$blogname.' < '.$email.' >' . "\r\n" .
                'Reply-To: '. $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $msg = "Name: $name \n Email: $email \n Phone: $phone \n";
            if(wp_mail($to,$subject,$msg,$headers)){
                $time = time() + 30*24*60*60;
                setcookie('car_popup_info','sent',$time,'/');
                echo 'y';
            }
            else{
                echo 'n';
            }
           
            exit;
        }
        
     /*
         *  add css and javascript for popup
         */   
        function enqueue_css_js(){
            
            if($_COOKIE['car_popup_info'] == 'sent') return;
            if($_REQUEST['custom_search_submit'] == 'Y') :
                $css = POPUP_CSS . '/popup.css';
                $js = POPUP_JS . '/popup.js';
                $ajax = admin_url( 'admin-ajax.php' );
                echo "<link rel='stylesheet' type='text/css' href='$css'></link>";
                echo "<script type='text/javascript' src='$js'></script>";
                echo "<script type='text/javascript'>var ajax_url = '$ajax'</script>";
            endif;
           
           
           /*
                    wp_register_style('simple_popup_css', POPUP_CSS . '/popup.css');
                    wp_enqueue_style('simple_popup_css', POPUP_CSS . '/popup.css');
                    wp_enqueue_script('jquery');
                    wp_register_script('simple_popup_js', POPUP_JS . '/popup.js');
                    wp_enqueue_script('simple_popup_js', POPUP_JS . '/popup.js');

                     */
            
        }
    
        //the html form
        function PopupHTML(){
             if($_COOKIE['car_popup_info'] == 'sent') return;
              if($_REQUEST['custom_search_submit'] == 'Y') :
        ?>
                                <div id="popup">
                                       <div style="display:none;" id="popup-content" class="window"> 
                                               <h2> Please provide some information </h2>
                                                <p>Name: <input id="popup-name" size='40' type='text' name='popup_name' value='' /></p>
                                                <p>Email: <input id="popup-email" size='40' type='text' name='popup_email' value='' /></p>
                                                <p>Phone: <input id="popup-phone" size='40' type='text' name='popup_phone' value='' /></p>
                                                <p> <button id='popup-info-submit'>Send</button> </p>
                                                 <a href="#" class="close"></a>
                                      </div> 
                                        <div id="blanket"></div>
                                </div>            
                <?
             endif; 
        }
    
    }
    $popup_simple = new Simple_Popup();
endif;

?>
