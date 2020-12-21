// Frontend scripts
jQuery( window ).on( 'elementor:init', function() {


var ueepbselect2ItemView = elementor.modules.controls.BaseData.extend({
	getSelect2Placeholder: function getSelect2Placeholder() {
	    return this.ui.select.children('option:first[value=""]').text();
	  },
	  getSelect2DefaultOptions: function getSelect2DefaultOptions() {
	    return {
	      allowClear: true,
	      placeholder: this.getSelect2Placeholder(),
	      dir: elementorCommon.config.isRTL ? 'rtl' : 'ltr'
	    };
	  },
	  getSelect2Options: function getSelect2Options() {
	    return jQuery.extend(this.getSelect2DefaultOptions(), this.model.get('select2options'));
	  },


    onReady: function () {
        // ueepb-woo-single-product
        // alert((this.ui.select.$element.attr('data-setting')));
        // console.log(this.model.attributes.ueepb_class);
        var ajax_action = '';
        switch(this.model.attributes.ueepb_class){
          case 'ueepb-woo-single-product':
            ajax_action = 'ueepb_load_woo_single_product';
            break;
        }

        this.ui.select.select2({
          ajax: {
            url: UEEPBFront.AdminAjax,
            dataType: 'json',
            delay: 250,
            method: "POST",
            data: function (params) {
              return {
                q: params.term, // search term
                action: ajax_action,
                verify_nonce: UEEPBFront.nonce,
              };
            },
            processResults: function (data, page) {
              
              return {
                results: data.items
              };
            },
            cache: true
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1,
          templateResult: ueepb_formatRepo, // omitted for brevity, see the source of this page
          templateSelection: ueepb_formatRepoSelection // omitted for brevity, see the source of this page
        });
    },

    onBeforeDestroy: function onBeforeDestroy() {
	    // We always destroy the select2 instance because there are cases where the DOM element's data cache
	    // itself has been destroyed but the select2 instance on it still exists
	    this.ui.select.select2('destroy');
	    this.$el.remove();
	  },
	  onAfterExternalChange: function onAfterExternalChange() {
	    this.ui.select.select2('destroy');
	    this.onReady();
	    ControlBaseDataView.prototype.onAfterExternalChange.apply(this, arguments);
	  }
});

elementor.addControlView('ueepb_select2', ueepbselect2ItemView);

});

