<?php
/**
 *
 * @package Sticky Topbar
 * @author RainaStudio
 * @version 2.0.0
 */
?>
<style>
.topbar {
    background-color:<?php echo $bgcolor; ?>;
    height:<?php echo $t_height ?>;
    color:<?php echo $tcolor ?>;
}
.topbar p {
    font-size:<?php echo $font_size ?>;
}
.topbar a {
    color:<?php echo $tcolor ?>;
}
<?php if ( $hide_social_on_mob == 1 ){ ?>
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        .social-icons {
            display: none;
        }
    }
<?php } ?>

</style>