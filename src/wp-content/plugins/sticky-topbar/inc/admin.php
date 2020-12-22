<?php
/**
 *
 * @package Sticky Topbar
 * @author RainaStudio
 * @version 2.0.0
 */

// Register Subpage
add_action('admin_menu', 'register_stopbar_submenu');
    
function register_stopbar_submenu() {
    add_submenu_page( 'options-general.php', 'Sticky Topbar Options', 'Sticky Topbar', 'administrator', 'topbar-options', 'stopbar_metabox' );
    
    //call register settings function
    add_action( 'admin_init', 'stopbar_opitions_settings' );
}


// Create topbar metabox
function stopbar_metabox() {
    ?>
    <div class="wrap">
        <h2><?php _e( 'Topbar Settings' ); ?></h2>
        <p><?php _e("<em>Enter your topbar text, button URL & text, including HTML if desired.</em>", 'studio_player_footer'); ?></p>
            <form method="post" action="options.php" class="sticky_topbar">
                <?php settings_fields( 'stopbar-options-settings-group' ); ?>
                <?php do_settings_sections( 'stopbar-options-settings-group' ); ?>
                <div class="sticky_topbar_toggle">
                    <div class="sticky_topbar_toggle_title">
                        <h4><?php _e( 'General Settings' ); ?></h4>
                        <i class="sticky_topbar_toggle_icon"></i>
                    </div>
                    <div class="sticky_topbar_toggle_content">
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Topbar Background Color', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_bg" class="bg-color-field" id="sticky_topbar_bg" value="<?php echo htmlspecialchars( get_option('sticky_topbar_bg') ); ?>" data-default-color="#4872cb" /></p>
                                        <p><span class="description">Select color for topbar background</span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Topbar Text Color', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_tcolor" class="bg-color-field" id="sticky_topbar_tcolor" value="<?php echo htmlspecialchars( get_option('sticky_topbar_tcolor') ); ?>" data-default-color="#4872cb" /></p>
                                        <p><span class="description">Select color for topbar background</span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Button Background Color', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_bbg" class="bg-color-field" id="sticky_topbar_bbg" value="<?php echo htmlspecialchars( get_option('sticky_topbar_bbg') ); ?>" data-default-color="#333333" /></p>
                                        <p><span class="description">Select color for button background</span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Button Text Color', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_tc" class="bg-color-field" id="sticky_topbar_tc" value="<?php echo htmlspecialchars( get_option('sticky_topbar_tc') ); ?>" data-default-color="#000000" /></p>
                                        <p><span class="description">Select color for button background</span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Topbar Paragraph Font Size', 'sticky_topbar' ); ?></th>
                                    <td>
                                    <input name="sticky_topbar_font_size" id="sticky_topbar_font_size" type="text" value="<?php echo htmlspecialchars( get_option('sticky_topbar_font_size') ); ?>" class="small-text">
                                    <p class="description" id="sticky_topbar_font_size-description">inherit or 16px</p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Set Topbar Height', 'sticky_topbar' ); ?></th>
                                    <td>
                                    <input name="sticky_topbar_height" id="sticky_topbar_height" type="text" value="<?php echo htmlspecialchars( get_option('sticky_topbar_height') ); ?>" class="small-text">
                                    <p class="description" id="sticky_topbar_height-description">Default is 50px</p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Show Topbar', 'TEXT_DOMAIN' ); ?></th>
                                    <td>
                                        <fieldset>
                                        <legend class="screen-reader-text"><?php esc_html_e( 'Show Topbar', 'TEXT_DOMAIN' ); ?></legend>
                                                <p><label for="sticky_topbar_show_on"><input type="checkbox" name="sticky_topbar_show_on" id="sticky_topbar_show_on" value="1"<?php checked( 1, get_option( 'sticky_topbar_show_on' ) ); ?>/>Yes, Enable</label></p>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="sticky_topbar_toggle">
                    <div class="sticky_topbar_toggle_title">
                        <h4><?php _e( 'CTA(call-to-action) Text & Button' ); ?></h4>
                        <i class="sticky_topbar_toggle_icon"></i>
                    </div>
                    <div class="sticky_topbar_toggle_content">
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><label><strong>Topbar Text</strong></label></th>
                                        <td>
                                            <p><textarea name="sticky_topbar_text" class="large-text" id="sticky_topbar_text" cols="40" rows="5" maxlength="180"><?php echo htmlspecialchars( get_option('sticky_topbar_text') ); ?></textarea></p>
                                            <p><span class="description">ie. Get 30% OFF on StudioPlayer Genesis WordPress theme </span><code>Limit 180 characters</code></p>
                                        </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><label><strong>Topbar Button URL</strong></label></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_url" class="large-text" id="sticky_topbar_url" placeholder="http//" size="40" value="<?php echo esc_attr( get_option('sticky_topbar_url') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//rainastudio.com/themes/studioplayer</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><label><strong>Topbar Button Text</strong></label></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_btn_text" class="regular-text" id="sticky_topbar_btn_text" value="<?php echo esc_attr( get_option('sticky_topbar_btn_text') ); ?>"/></p>
                                        <p><span class="description">ie. Subscribe, Buy Now, Get Now, Check Out, 30% OFF, Best Deal, Learn More, Live Demo</span></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="sticky_topbar_toggle">
                    <div class="sticky_topbar_toggle_title">
                        <h4><?php _e( 'Social Media URLs' ); ?></h4>
                        <i class="sticky_topbar_toggle_icon"></i>
                    </div>
                    <div class="sticky_topbar_toggle_content">
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Facebook URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_facebook" class="large-text" id="sticky_topbar_facebook" value="<?php echo htmlspecialchars( get_option('sticky_topbar_facebook') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//www.facebook.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Twitter URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_twitter" class="large-text" id="sticky_topbar_twitter" value="<?php echo htmlspecialchars( get_option('sticky_topbar_twitter') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//twitter.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'LinkedIn URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_linkedIn" class="large-text" id="sticky_topbar_linkedIn" value="<?php echo htmlspecialchars( get_option('sticky_topbar_linkedIn') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//www.linkedin.com/in/a3ashif/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Pinterest URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_pinterest" class="large-text" id="sticky_topbar_pinterest" value="<?php echo htmlspecialchars( get_option('sticky_topbar_pinterest') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//www.pinterest.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Instagram URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_instagram" class="large-text" id="sticky_topbar_instagram" value="<?php echo htmlspecialchars( get_option('sticky_topbar_instagram') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//www.instagram.com/ashif_devs/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'YouTube URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_youtube" class="large-text" id="sticky_topbar_youtube" value="<?php echo htmlspecialchars( get_option('sticky_topbar_youtube') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//youtube.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Dribbble URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_dribbble" class="large-text" id="sticky_topbar_dribbble" value="<?php echo htmlspecialchars( get_option('sticky_topbar_dribbble') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//dribbble.com/ashif/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Medium URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_medium" class="large-text" id="sticky_topbar_medium" value="<?php echo htmlspecialchars( get_option('sticky_topbar_medium') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//medium.com/@anwerashif/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Tumblr URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_tumblr" class="large-text" id="sticky_topbar_tumblr" value="<?php echo htmlspecialchars( get_option('sticky_topbar_tumblr') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//tumblr.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Vimeo URL', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="text" name="sticky_topbar_vimeo" class="large-text" id="sticky_topbar_vimeo" value="<?php echo htmlspecialchars( get_option('sticky_topbar_vimeo') ); ?>"/></p>
                                        <p><span class="description">ie.<code>https//vimeo.com/rainastudio/</code></span></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Cell or Phone Number', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <p><input type="tel" name="sticky_topbar_cell" class="large-text" id="sticky_topbar_cell" value="<?php echo htmlspecialchars( get_option('sticky_topbar_cell') ); ?>"/></p>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Remove Social Icons & Phone Number', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <fieldset>
                                        <legend class="screen-reader-text"><?php esc_html_e( 'Remove Social Icons and Phone Number', 'sticky_topbar' ); ?></legend>
                                                <p><label for="sticky_topbar_social_off"><input type="checkbox" name="sticky_topbar_social_off" id="sticky_topbar_social_off" value="1"<?php checked( 1, get_option( 'sticky_topbar_social_off' ) ); ?>/>Yes, Hide</label></p>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php esc_html_e( 'Hide on Mobile', 'sticky_topbar' ); ?></th>
                                    <td>
                                        <fieldset>
                                        <legend class="screen-reader-text"><?php esc_html_e( 'Hide on Mobile', 'sticky_topbar' ); ?></legend>
                                                <p><label for="sticky_topbar_social_hide_on_mob"><input type="checkbox" name="sticky_topbar_social_hide_on_mob" id="sticky_topbar_social_hide_on_mob" value="1"<?php checked( 1, get_option( 'sticky_topbar_social_hide_on_mob' ) ); ?>/>Yes, Hide</label></p>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="sticky_topbar_toggle">
                    <div class="sticky_topbar_toggle_title">
                        <h4><?php _e( 'Sticky CTA with Countdown' ); ?></h4>
                        <i class="sticky_topbar_toggle_icon"></i>
                    </div>
                    <div class="sticky_topbar_toggle_content">
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Count Down Date', 'sticky_topbar' ); ?></th>
                                <td>
                                <fieldset><legend class="screen-reader-text"><span>Count Down Date</span></legend>
                                <p><label for="sticky_cd_mth">Month and Day</label>
                                    <select name="sticky_cd_mth" id="sticky_cd_mth" class="sticky_cd_mth_select">
                                        <option value="Jan"<?php selected(get_option('sticky_cd_mth'), "Jan"); ?>>Jan</option>
                                        <option value="Feb"<?php selected(get_option('sticky_cd_mth'), "Feb"); ?>>Feb</option>
                                        <option value="Mar"<?php selected(get_option('sticky_cd_mth'), "Mar"); ?>>Mar</option>
                                        <option value="Apr"<?php selected(get_option('sticky_cd_mth'), "Apr"); ?>>Apr</option>
                                        <option value="May"<?php selected(get_option('sticky_cd_mth'), "May"); ?>>May</option>
                                        <option value="Jun"<?php selected(get_option('sticky_cd_mth'), "Jun"); ?>>Jun</option>
                                        <option value="Jul"<?php selected(get_option('sticky_cd_mth'), "Jul"); ?>>Jul</option>
                                        <option value="Aug"<?php selected(get_option('sticky_cd_mth'), "Aug"); ?>>Aug</option>
                                        <option value="Sept"<?php selected(get_option('sticky_cd_mth'), "Sept"); ?>>Sept</option>
                                        <option value="Oct"<?php selected(get_option('sticky_cd_mth'), "Oct"); ?>>Oct</option>
                                        <option value="Nov"<?php selected(get_option('sticky_cd_mth'), "Nov"); ?>>Nov</option>
                                        <option value="Dec"<?php selected(get_option('sticky_cd_mth'), "Dec"); ?>>Dec</option>
                                    </select> 
                                    <select name="sticky_cd_date" id="sticky_cd_date" class="sticky_cd_date_select">
                                        <option value="01"<?php selected(get_option('sticky_cd_date'), "01"); ?>>01</option>
                                        <option value="02"<?php selected(get_option('sticky_cd_date'), "02"); ?>>02</option>
                                        <option value="03"<?php selected(get_option('sticky_cd_date'), "03"); ?>>03</option>
                                        <option value="04"<?php selected(get_option('sticky_cd_date'), "04"); ?>>04</option>
                                        <option value="05"<?php selected(get_option('sticky_cd_date'), "05"); ?>>05</option>
                                        <option value="06"<?php selected(get_option('sticky_cd_date'), "06"); ?>>06</option>
                                        <option value="07"<?php selected(get_option('sticky_cd_date'), "07"); ?>>07</option>
                                        <option value="08"<?php selected(get_option('sticky_cd_date'), "08"); ?>>08</option>
                                        <option value="09"<?php selected(get_option('sticky_cd_date'), "09"); ?>>09</option>
                                        <option value="10"<?php selected(get_option('sticky_cd_date'), "10"); ?>>10</option>
                                        <option value="11"<?php selected(get_option('sticky_cd_date'), "11"); ?>>11</option>
                                        <option value="12"<?php selected(get_option('sticky_cd_date'), "12"); ?>>12</option>
                                        <option value="13"<?php selected(get_option('sticky_cd_date'), "13"); ?>>13</option>
                                        <option value="14"<?php selected(get_option('sticky_cd_date'), "14"); ?>>14</option>
                                        <option value="15"<?php selected(get_option('sticky_cd_date'), "15"); ?>>15</option>
                                        <option value="16"<?php selected(get_option('sticky_cd_date'), "16"); ?>>16</option>
                                        <option value="17"<?php selected(get_option('sticky_cd_date'), "17"); ?>>17</option>
                                        <option value="18"<?php selected(get_option('sticky_cd_date'), "18"); ?>>18</option>
                                        <option value="19"<?php selected(get_option('sticky_cd_date'), "19"); ?>>19</option>
                                        <option value="20"<?php selected(get_option('sticky_cd_date'), "20"); ?>>20</option>
                                        <option value="21"<?php selected(get_option('sticky_cd_date'), "21"); ?>>21</option>
                                        <option value="22"<?php selected(get_option('sticky_cd_date'), "22"); ?>>22</option>
                                        <option value="23"<?php selected(get_option('sticky_cd_date'), "23"); ?>>23</option>
                                        <option value="24"<?php selected(get_option('sticky_cd_date'), "24"); ?>>24</option>
                                        <option value="25"<?php selected(get_option('sticky_cd_date'), "25"); ?>>25</option>
                                        <option value="26"<?php selected(get_option('sticky_cd_date'), "26"); ?>>26</option>
                                        <option value="27"<?php selected(get_option('sticky_cd_date'), "27"); ?>>27</option>
                                        <option value="28"<?php selected(get_option('sticky_cd_date'), "28"); ?>>28</option>
                                        <option value="29"<?php selected(get_option('sticky_cd_date'), "29"); ?>>29</option>
                                        <option value="30"<?php selected(get_option('sticky_cd_date'), "30"); ?>>30</option>
                                        <option value="31"<?php selected(get_option('sticky_cd_date'), "31"); ?>>31</option>
                                    </select>
                                    </p>
                                    <p><label for="sticky_cd_yer">Year</label>
                                    <input name="sticky_cd_yer" type="text" placeholder="2019" id="sticky_cd_yer" value="<?php echo htmlspecialchars( get_option('sticky_cd_yer') ); ?>" class="small-text">
                                    </p>
                                    <p><label for="sticky_cd_time">Time</label>
                                    <select name="sticky_cd_time_hr" id="sticky_cd_time_hr" class="sticky_cd_time_hr_select">
                                        <option value="00"<?php selected(get_option('sticky_cd_time_hr'), "00"); ?>>00</option>
                                        <option value="01"<?php selected(get_option('sticky_cd_time_hr'), "01"); ?>>01</option>
                                        <option value="02"<?php selected(get_option('sticky_cd_time_hr'), "02"); ?>>02</option>
                                        <option value="03"<?php selected(get_option('sticky_cd_time_hr'), "03"); ?>>03</option>
                                        <option value="04"<?php selected(get_option('sticky_cd_time_hr'), "04"); ?>>04</option>
                                        <option value="05"<?php selected(get_option('sticky_cd_time_hr'), "05"); ?>>05</option>
                                        <option value="06"<?php selected(get_option('sticky_cd_time_hr'), "06"); ?>>06</option>
                                        <option value="07"<?php selected(get_option('sticky_cd_time_hr'), "07"); ?>>07</option>
                                        <option value="08"<?php selected(get_option('sticky_cd_time_hr'), "08"); ?>>08</option>
                                        <option value="09"<?php selected(get_option('sticky_cd_time_hr'), "09"); ?>>09</option>
                                        <option value="10"<?php selected(get_option('sticky_cd_time_hr'), "10"); ?>>10</option>
                                        <option value="11"<?php selected(get_option('sticky_cd_time_hr'), "11"); ?>>11</option>
                                        <option value="12"<?php selected(get_option('sticky_cd_time_hr'), "12"); ?>>12</option>
                                        <option value="13"<?php selected(get_option('sticky_cd_time_hr'), "13"); ?>>13</option>
                                        <option value="14"<?php selected(get_option('sticky_cd_time_hr'), "14"); ?>>14</option>
                                        <option value="15"<?php selected(get_option('sticky_cd_time_hr'), "15"); ?>>15</option>
                                        <option value="16"<?php selected(get_option('sticky_cd_time_hr'), "16"); ?>>16</option>
                                        <option value="17"<?php selected(get_option('sticky_cd_time_hr'), "17"); ?>>17</option>
                                        <option value="18"<?php selected(get_option('sticky_cd_time_hr'), "18"); ?>>18</option>
                                        <option value="19"<?php selected(get_option('sticky_cd_time_hr'), "19"); ?>>19</option>
                                        <option value="20"<?php selected(get_option('sticky_cd_time_hr'), "20"); ?>>20</option>
                                        <option value="21"<?php selected(get_option('sticky_cd_time_hr'), "21"); ?>>21</option>
                                        <option value="22"<?php selected(get_option('sticky_cd_time_hr'), "22"); ?>>22</option>
                                        <option value="23"<?php selected(get_option('sticky_cd_time_hr'), "23"); ?>>23</option>
                                        <option value="24"<?php selected(get_option('sticky_cd_time_hr'), "24"); ?>>24</option>
                                    </select>:
                                    <select name="sticky_cd_time_min" id="sticky_cd_time_min" class="sticky_cd_time_min_select">
                                        <option value="00"<?php selected(get_option('sticky_cd_time_min'), "00"); ?>>00</option>
                                        <option value="01"<?php selected(get_option('sticky_cd_time_min'), "01"); ?>>01</option>
                                        <option value="02"<?php selected(get_option('sticky_cd_time_min'), "02"); ?>>02</option>
                                        <option value="03"<?php selected(get_option('sticky_cd_time_min'), "03"); ?>>03</option>
                                        <option value="04"<?php selected(get_option('sticky_cd_time_min'), "04"); ?>>04</option>
                                        <option value="05"<?php selected(get_option('sticky_cd_time_min'), "05"); ?>>05</option>
                                        <option value="06"<?php selected(get_option('sticky_cd_time_min'), "06"); ?>>06</option>
                                        <option value="07"<?php selected(get_option('sticky_cd_time_min'), "07"); ?>>07</option>
                                        <option value="08"<?php selected(get_option('sticky_cd_time_min'), "08"); ?>>08</option>
                                        <option value="09"<?php selected(get_option('sticky_cd_time_min'), "09"); ?>>09</option>
                                        <option value="10"<?php selected(get_option('sticky_cd_time_min'), "10"); ?>>10</option>
                                        <option value="11"<?php selected(get_option('sticky_cd_time_min'), "11"); ?>>11</option>
                                        <option value="12"<?php selected(get_option('sticky_cd_time_min'), "12"); ?>>12</option>
                                        <option value="13"<?php selected(get_option('sticky_cd_time_min'), "13"); ?>>13</option>
                                        <option value="14"<?php selected(get_option('sticky_cd_time_min'), "14"); ?>>14</option>
                                        <option value="15"<?php selected(get_option('sticky_cd_time_min'), "15"); ?>>15</option>
                                        <option value="16"<?php selected(get_option('sticky_cd_time_min'), "16"); ?>>16</option>
                                        <option value="17"<?php selected(get_option('sticky_cd_time_min'), "17"); ?>>17</option>
                                        <option value="18"<?php selected(get_option('sticky_cd_time_min'), "18"); ?>>18</option>
                                        <option value="19"<?php selected(get_option('sticky_cd_time_min'), "19"); ?>>19</option>
                                        <option value="20"<?php selected(get_option('sticky_cd_time_min'), "20"); ?>>20</option>
                                        <option value="21"<?php selected(get_option('sticky_cd_time_min'), "21"); ?>>21</option>
                                        <option value="22"<?php selected(get_option('sticky_cd_time_min'), "22"); ?>>22</option>
                                        <option value="23"<?php selected(get_option('sticky_cd_time_min'), "23"); ?>>23</option>
                                        <option value="24"<?php selected(get_option('sticky_cd_time_min'), "24"); ?>>24</option>
                                        <option value="25"<?php selected(get_option('sticky_cd_time_min'), "25"); ?>>25</option>
                                        <option value="26"<?php selected(get_option('sticky_cd_time_min'), "26"); ?>>26</option>
                                        <option value="27"<?php selected(get_option('sticky_cd_time_min'), "27"); ?>>27</option>
                                        <option value="28"<?php selected(get_option('sticky_cd_time_min'), "28"); ?>>28</option>
                                        <option value="29"<?php selected(get_option('sticky_cd_time_min'), "29"); ?>>29</option>
                                        <option value="30"<?php selected(get_option('sticky_cd_time_min'), "30"); ?>>30</option>
                                        <option value="31"<?php selected(get_option('sticky_cd_time_min'), "31"); ?>>31</option>
                                        <option value="32"<?php selected(get_option('sticky_cd_time_min'), "32"); ?>>32</option>
                                        <option value="33"<?php selected(get_option('sticky_cd_time_min'), "33"); ?>>33</option>
                                        <option value="34"<?php selected(get_option('sticky_cd_time_min'), "34"); ?>>34</option>
                                        <option value="35"<?php selected(get_option('sticky_cd_time_min'), "35"); ?>>35</option>
                                        <option value="36"<?php selected(get_option('sticky_cd_time_min'), "36"); ?>>36</option>
                                        <option value="37"<?php selected(get_option('sticky_cd_time_min'), "37"); ?>>37</option>
                                        <option value="38"<?php selected(get_option('sticky_cd_time_min'), "38"); ?>>38</option>
                                        <option value="39"<?php selected(get_option('sticky_cd_time_min'), "39"); ?>>39</option>
                                        <option value="40"<?php selected(get_option('sticky_cd_time_min'), "40"); ?>>40</option>
                                        <option value="41"<?php selected(get_option('sticky_cd_time_min'), "41"); ?>>41</option>
                                        <option value="42"<?php selected(get_option('sticky_cd_time_min'), "42"); ?>>42</option>
                                        <option value="43"<?php selected(get_option('sticky_cd_time_min'), "43"); ?>>43</option>
                                        <option value="44"<?php selected(get_option('sticky_cd_time_min'), "44"); ?>>44</option>
                                        <option value="45"<?php selected(get_option('sticky_cd_time_min'), "45"); ?>>45</option>
                                        <option value="46"<?php selected(get_option('sticky_cd_time_min'), "46"); ?>>46</option>
                                        <option value="47"<?php selected(get_option('sticky_cd_time_min'), "47"); ?>>47</option>
                                        <option value="48"<?php selected(get_option('sticky_cd_time_min'), "48"); ?>>48</option>
                                        <option value="49"<?php selected(get_option('sticky_cd_time_min'), "49"); ?>>49</option>
                                        <option value="50"<?php selected(get_option('sticky_cd_time_min'), "50"); ?>>50</option>
                                        <option value="51"<?php selected(get_option('sticky_cd_time_min'), "51"); ?>>51</option>
                                        <option value="52"<?php selected(get_option('sticky_cd_time_min'), "52"); ?>>52</option>
                                        <option value="53"<?php selected(get_option('sticky_cd_time_min'), "53"); ?>>53</option>
                                        <option value="54"<?php selected(get_option('sticky_cd_time_min'), "54"); ?>>54</option>
                                        <option value="55"<?php selected(get_option('sticky_cd_time_min'), "55"); ?>>55</option>
                                        <option value="56"<?php selected(get_option('sticky_cd_time_min'), "56"); ?>>56</option>
                                        <option value="57"<?php selected(get_option('sticky_cd_time_min'), "57"); ?>>57</option>
                                        <option value="58"<?php selected(get_option('sticky_cd_time_min'), "58"); ?>>58</option>
                                        <option value="59"<?php selected(get_option('sticky_cd_time_min'), "59"); ?>>59</option>
                                    </select>:
                                    <select name="sticky_cd_time_sec" id="sticky_cd_time_sec" class="sticky_cd_time_sec_select">
                                        <option value="00"<?php selected(get_option('sticky_cd_time_sec'), "00"); ?>>00</option>
                                        <option value="01"<?php selected(get_option('sticky_cd_time_sec'), "01"); ?>>01</option>
                                        <option value="02"<?php selected(get_option('sticky_cd_time_sec'), "02"); ?>>02</option>
                                        <option value="03"<?php selected(get_option('sticky_cd_time_sec'), "03"); ?>>03</option>
                                        <option value="04"<?php selected(get_option('sticky_cd_time_sec'), "04"); ?>>04</option>
                                        <option value="05"<?php selected(get_option('sticky_cd_time_sec'), "05"); ?>>05</option>
                                        <option value="06"<?php selected(get_option('sticky_cd_time_sec'), "06"); ?>>06</option>
                                        <option value="07"<?php selected(get_option('sticky_cd_time_sec'), "07"); ?>>07</option>
                                        <option value="08"<?php selected(get_option('sticky_cd_time_sec'), "08"); ?>>08</option>
                                        <option value="09"<?php selected(get_option('sticky_cd_time_sec'), "09"); ?>>09</option>
                                        <option value="10"<?php selected(get_option('sticky_cd_time_sec'), "10"); ?>>10</option>
                                        <option value="11"<?php selected(get_option('sticky_cd_time_sec'), "11"); ?>>11</option>
                                        <option value="12"<?php selected(get_option('sticky_cd_time_sec'), "12"); ?>>12</option>
                                        <option value="13"<?php selected(get_option('sticky_cd_time_sec'), "13"); ?>>13</option>
                                        <option value="14"<?php selected(get_option('sticky_cd_time_sec'), "14"); ?>>14</option>
                                        <option value="15"<?php selected(get_option('sticky_cd_time_sec'), "15"); ?>>15</option>
                                        <option value="16"<?php selected(get_option('sticky_cd_time_sec'), "16"); ?>>16</option>
                                        <option value="17"<?php selected(get_option('sticky_cd_time_sec'), "17"); ?>>17</option>
                                        <option value="18"<?php selected(get_option('sticky_cd_time_sec'), "18"); ?>>18</option>
                                        <option value="19"<?php selected(get_option('sticky_cd_time_sec'), "19"); ?>>19</option>
                                        <option value="20"<?php selected(get_option('sticky_cd_time_sec'), "20"); ?>>20</option>
                                        <option value="21"<?php selected(get_option('sticky_cd_time_sec'), "21"); ?>>21</option>
                                        <option value="22"<?php selected(get_option('sticky_cd_time_sec'), "22"); ?>>22</option>
                                        <option value="23"<?php selected(get_option('sticky_cd_time_sec'), "23"); ?>>23</option>
                                        <option value="24"<?php selected(get_option('sticky_cd_time_sec'), "24"); ?>>24</option>
                                        <option value="25"<?php selected(get_option('sticky_cd_time_sec'), "25"); ?>>25</option>
                                        <option value="26"<?php selected(get_option('sticky_cd_time_sec'), "26"); ?>>26</option>
                                        <option value="27"<?php selected(get_option('sticky_cd_time_sec'), "27"); ?>>27</option>
                                        <option value="28"<?php selected(get_option('sticky_cd_time_sec'), "28"); ?>>28</option>
                                        <option value="29"<?php selected(get_option('sticky_cd_time_sec'), "29"); ?>>29</option>
                                        <option value="30"<?php selected(get_option('sticky_cd_time_sec'), "30"); ?>>30</option>
                                        <option value="31"<?php selected(get_option('sticky_cd_time_sec'), "31"); ?>>31</option>
                                        <option value="32"<?php selected(get_option('sticky_cd_time_sec'), "32"); ?>>32</option>
                                        <option value="33"<?php selected(get_option('sticky_cd_time_sec'), "33"); ?>>33</option>
                                        <option value="34"<?php selected(get_option('sticky_cd_time_sec'), "34"); ?>>34</option>
                                        <option value="35"<?php selected(get_option('sticky_cd_time_sec'), "35"); ?>>35</option>
                                        <option value="36"<?php selected(get_option('sticky_cd_time_sec'), "36"); ?>>36</option>
                                        <option value="37"<?php selected(get_option('sticky_cd_time_sec'), "37"); ?>>37</option>
                                        <option value="38"<?php selected(get_option('sticky_cd_time_sec'), "38"); ?>>38</option>
                                        <option value="39"<?php selected(get_option('sticky_cd_time_sec'), "39"); ?>>39</option>
                                        <option value="40"<?php selected(get_option('sticky_cd_time_sec'), "40"); ?>>40</option>
                                        <option value="41"<?php selected(get_option('sticky_cd_time_sec'), "41"); ?>>41</option>
                                        <option value="42"<?php selected(get_option('sticky_cd_time_sec'), "42"); ?>>42</option>
                                        <option value="43"<?php selected(get_option('sticky_cd_time_sec'), "43"); ?>>43</option>
                                        <option value="44"<?php selected(get_option('sticky_cd_time_sec'), "44"); ?>>44</option>
                                        <option value="45"<?php selected(get_option('sticky_cd_time_sec'), "45"); ?>>45</option>
                                        <option value="46"<?php selected(get_option('sticky_cd_time_sec'), "46"); ?>>46</option>
                                        <option value="47"<?php selected(get_option('sticky_cd_time_sec'), "47"); ?>>47</option>
                                        <option value="48"<?php selected(get_option('sticky_cd_time_sec'), "48"); ?>>48</option>
                                        <option value="49"<?php selected(get_option('sticky_cd_time_sec'), "49"); ?>>49</option>
                                        <option value="50"<?php selected(get_option('sticky_cd_time_sec'), "50"); ?>>50</option>
                                        <option value="51"<?php selected(get_option('sticky_cd_time_sec'), "51"); ?>>51</option>
                                        <option value="52"<?php selected(get_option('sticky_cd_time_sec'), "52"); ?>>52</option>
                                        <option value="53"<?php selected(get_option('sticky_cd_time_sec'), "53"); ?>>53</option>
                                        <option value="54"<?php selected(get_option('sticky_cd_time_sec'), "54"); ?>>54</option>
                                        <option value="55"<?php selected(get_option('sticky_cd_time_sec'), "55"); ?>>55</option>
                                        <option value="56"<?php selected(get_option('sticky_cd_time_sec'), "56"); ?>>56</option>
                                        <option value="57"<?php selected(get_option('sticky_cd_time_sec'), "57"); ?>>57</option>
                                        <option value="58"<?php selected(get_option('sticky_cd_time_sec'), "58"); ?>>58</option>
                                        <option value="59"<?php selected(get_option('sticky_cd_time_sec'), "59"); ?>>59</option>
                                    </select></p>
                                </fieldset>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e( 'Remove Countdown', 'sticky_topbar' ); ?></th>
                                <td>
                                    <fieldset>
                                    <legend class="screen-reader-text"><?php esc_html_e( 'Remove Countdown', 'sticky_topbar' ); ?></legend>
                                            <p><label for="topbar_countdown_off"><input type="checkbox" name="topbar_countdown_off" id="topbar_countdown_off" value="1"<?php checked( 1, get_option( 'topbar_countdown_off' ) ); ?>/>Yes, Hide</label></p>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                    <?php submit_button(); ?>
            </form>
        </div>
    <?php
}

// Sanitization
function stopbar_opitions_settings() {
    //register our settings
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_text' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_url' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_btn_text' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_facebook' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_twitter' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_linkedIn' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_pinterest' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_instagram' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_youtube' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_dribbble' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_medium' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_tumblr' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_vimeo' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_cell' );		
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_bg' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_bbg' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_tcolor' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_tc' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_font_size' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_height' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_social_off' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_social_hide_on_mob' );
    register_setting( 'stopbar-options-settings-group', 'sticky_topbar_show_on' );
    register_setting( 'st-options-settings-group', 'sticky_cd_mth' );
    register_setting( 'st-options-settings-group', 'sticky_cd_yer' );
    register_setting( 'st-options-settings-group', 'sticky_cd_time_hr' );
    register_setting( 'st-options-settings-group', 'sticky_cd_time_min' );
    register_setting( 'st-options-settings-group', 'sticky_cd_time_sec' );
    register_setting( 'st-options-settings-group', 'sticky_cd_date' );
    register_setting( 'st-options-settings-group', 'topbar_countdown_off' );
}