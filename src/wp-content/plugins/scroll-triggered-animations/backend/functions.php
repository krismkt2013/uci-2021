<?php function get_toast_sta_premium_advert(){ ?>
 <a class="toast-metabox premium-advert" href="https://www.toastplugins.co.uk/plugins/scroll-triggered-animations/" target="_blank">
<h3>Massive <span class="rainbow">sale</span> now on!</h3>
	<p>Get premium for only <span class="rainbow">£19.99</span> now!</p>
<div class="get-premium">Get premium now!</div>
</a>

<?php } ?>
<?php function toast_sta_advert(){ ?>


<div class="toast-sta-popup-background">
</div>

<div class="toast-sta-popup">
<i class="dashicons-no-alt close"></i>

<h3>Massive <span class="rainbow">sale</span> now on!</h3>
	<p>Get premium for only <span class="rainbow">£19.99</span> now!</p>
<a href="https://www.toastplugins.co.uk/plugins/scroll-triggered-animations/" target="_blank" class="get-premium">Get premium now!</a>
</div>

<script>
jQuery(window).ready(function(){

//ACTIVATE CHRISTMAS POPUP
setTimeout(function(){

if(sessionStorage.getItem('toast-sta-popup') !== 'true'){
jQuery('.toast-sta-popup-background, .toast-sta-popup').addClass('active');
sessionStorage.setItem('toast-sta-popup', 'true');
}
}, 5000)

//CLOSE POPUP
jQuery('.toast-sta-popup .close, .toast-sta-christmas-advert-background').on('click', function(){

jQuery('.toast-sta-popup, .toast-sta-popup-background').remove();

})

})
</script>


<?php } ?>