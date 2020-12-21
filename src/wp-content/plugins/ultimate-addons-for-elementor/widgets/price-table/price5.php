<div class="<?php echo $settings['style']; ?> uae_pricing_table  wow bounce" data-wow-duration="1's" style="visibility: visible; animation-name: bounce;">
  <div class="pricing-table">
    <div class="plan featured <?php echo $settings['ribbon_style']; ?>" style="background: <?php echo $settings['body_bg']; ?>; border: 2px solid <?php echo $settings['header_bg']; ?>; transform: scale(1.0<?php echo $settings['zoom']; ?>);">
      <?php if ($settings['ribbon_style'] == 'awsfrg') { ?>
        <div class="ribbon-right">
          <span style="background: <?php echo $settings['rib_clr']; ?>;"><?php echo $settings['rib_title']; ?></span>
        </div>
      <?php } ?>
      <div class="header" style="background-color: <?php echo $settings['header_bg']; ?>">
        <h4 class="plan-title price_title" style="color: <?php echo $settings['title_clr']; ?>;">
          <?php echo $settings['price_title']; ?>
        </h4>
        <div class="plan-cost">
          <span class="plan-price amount" style="color: <?php echo $settings['title_clr']; ?>;">
            <?php echo $settings['price_sign']; ?><?php echo $settings['price_value']; ?>
          </span>
          <span class="plan-type month" style="color: <?php echo $settings['title_clr']; ?>;">
            <?php echo $settings['price_plan']; ?>
          </span>
        </div>
        <span class="price-title5-span" style="border-color: <?php echo $settings['header_bg']; ?> transparent transparent transparent;"></span>
      </div>
      <div class="price-content">
        <ul>
          <?php foreach ($settings['list_items'] as $list_items) { ?>
            <li class="<?php if ($list_items['disable_item'] == 'yes') { ?> disable_item <?php } ?>" style="color: <?php echo $settings['feature_clr']; ?>;"><i style="color: <?php echo $list_items['icon_color']; ?>;padding-right:6px;" class="<?php echo $list_items['list_icon']['value']; ?>"></i> <?php echo $list_items['list_name']; ?></li>
          <?php } ?>
        </ul>
      </div>
      <div class="plan-select">
        <a href="<?php echo $settings['btn_link']['url']; ?>" <?php echo $target.$nofollow; ?> class="price-btn" style="font-size: <?php echo $btnsize; ?>px; background: <?php echo $settings['header_bg']; ?>;"><?php echo $settings['btn_title']; ?></a>
      </div>
    </div>
  </div>
</div>