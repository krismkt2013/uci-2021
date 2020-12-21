<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget_UEEPB_Business_Hours extends Widget_Base {

	public function get_name() {
		return 'ueepb-business-hours';
	}

	public function get_title() {
		return __( 'Business Hours', 'ueepb' );
	}

	public function get_icon() {
		return 'eicon-clock ueepb-element-icon';
	}

	public function get_categories() {
		return [ 'ueepb-business-elements' ];
	}

	public function get_style_depends() {
        return [
            'ueepb-business-style',
            'ueepb-front'
        ];
    }

    public function get_script_depends() {
        return [
            'ueepb-business-script'
        ];
    }

	protected function _register_controls() {
		global $ueepb_woo_product,$wp_roles,$ueepb_business_params;
		
		$this->start_controls_section(
			'section_ueepb_business_hours',
			[
				'label' => __( 'Business Hours', 'ueepb' ),
			]
		);

        $business_hours_designs = array('design_1' => __( 'Design 1', 'ueepb' ), 'design_2' => __( 'Design 2', 'ueepb' ), 'design_3' => __( 'Design 3', 'ueepb' ) , 'design_4' => __( 'Design 4', 'ueepb' ) );      

        $this->add_control(
            'ueepb_business_hours_design',
            [
                'label' => __( 'Design', 'ueepb' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'design_1',
                'options' => $business_hours_designs,
            ]
        );        

        $business_hours_list = $this->business_hours_list();
	
        $this->add_control(
            'ueepb_business_hours',
            [
                'label'          => '',
                'type'           => Controls_Manager::REPEATER,
                'default'        => [
                    ['ueepb_business_hours_day' => __('Monday','ueepb')],
                    ['ueepb_business_hours_day' => __('Tuesday','ueepb')],
                    ['ueepb_business_hours_day' => __('Wednesday','ueepb'),
                    ],
                    ['ueepb_business_hours_day' => __('Thursday','ueepb'),
                    ],
                    [
                        'ueepb_business_hours_day' => __('Friday','ueepb'),
                    ],
                    [
                        'ueepb_business_hours_day'          => __('Saturday','ueepb'),
                    ],
                    [
                        'ueepb_business_hours_day'          => __('Sunday','ueepb'),
                    ],
                ],
                'fields'         => [
                    [
                        'name'           => 'ueepb_business_hours_day',
                        'label'          => __( 'Day', 'ueepb' ),
                        'type'              => Controls_Manager::TEXT,
                        'default'           => 'Monday',
                        
                        
                    ],
                    [
                        'name'           => 'ueepb_business_hours_closed',
                        'label'          => __( 'Closed?', 'ueepb' ),
                        'type'           => Controls_Manager::SWITCHER,
                        'default'        => 'no',
                        'label_on'       => __( 'No', 'ueepb' ),
                        'label_off'      => __( 'Yes', 'ueepb' ),
                        'return_value'   => 'no',
                    ],
                    [
                        'name'           => 'ueepb_business_hours_opening_time',
                        'label'          => __( 'Opening Time', 'ueepb' ),
                        'type'           => Controls_Manager::SELECT,
                        'default'        => '09:00',
                        'options'        => $business_hours_list,
                        'condition'      => [
                            'ueepb_business_hours_closed' => 'no',
                        ],
                    ],
                    [
                        'name'           => 'ueepb_business_hours_closing_time',
                        'label'          => __( 'Closing Time', 'ueepb' ),
                        'type'           => Controls_Manager::SELECT,
                        'default'        => '17:00',
                        'options'        => $business_hours_list,
                        'condition'      => [
                            'ueepb_business_hours_closed' => 'no',
                        ],
                    ],
                ],
                'title_field'    => '{{{ ueepb_business_hours_day }}}',
                
            ]
        );
		    $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_business_hours_panel',
            [
                'label'             => __( 'Main Panel', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_business_hours_panel_background',
            [
                'label'          => __( 'Background Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-business-hours-panel' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_business_hours_panel_border',
            [
                'label'          => __( 'Show Border', 'ueepb' ),
                'type'           => Controls_Manager::SWITCHER,
                'default'        => 'no',
                'label_on'       => __( 'No', 'ueepb' ),
                'label_off'      => __( 'Yes', 'ueepb' ),
                'return_value'   => 'no',                
            ]
        );

        $this->add_control(
            'ueepb_business_hours_panel_border_color',
            [
                'label'          => __( 'Border Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'conditions'        => [
                            'terms' => [
                                [
                                    'name' => 'ueepb_business_hours_panel_border',
                                    'operator' => '!=',
                                    'value' => 'no',
                                ],
                            ],
                        ],
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-business-hours-panel' => 'border-color: {{VALUE}}',
                ],
            ]
        ); 

        $this->add_control(
            'ueepb_business_hours_panel_title_color',
            [
                'label'          => __( 'Title Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'ueepb_business_hours_day_time',
            [
                'label'             => __( 'Days and Times', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'ueepb_business_hours_day_background',
            [
                'label'          => __( 'Day - Background Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-day-name' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_business_hours_day_color',
            [
                'label'          => __( 'Day - Text Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-day-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_business_hours_day_border',
            [
                'label'          => __( 'Day - Border Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-day' => 'border-color: {{VALUE}}',
                ],
                'conditions'        => [
                    'terms' => [
                        [
                            'name' => 'ueepb_business_hours_design',
                            'operator' => '!=',
                            'value' => 'design_1',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'ueepb_business_hours_time_background',
            [
                'label'          => __( 'Time - Background Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-day-time' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ueepb_business_hours_time_color',
            [
                'label'          => __( 'Time - Text Color', 'ueepb' ),
                'type'           => Controls_Manager::COLOR,
                'default'        => '',
                'selectors'      => [
                    '{{WRAPPER}} .ueepb-bh-day-time' => 'color: {{VALUE}}',
                ],
            ]
        );

        

        $this->end_controls_section();

        $this->start_controls_section(
            'ueepb_business_hours_fonts',
            [
                'label'             => __( 'Font Styles', 'ueepb' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_business_hours_title_typography',
                'label'             => __( 'Title Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-bh-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_business_hours_day_typography',
                'label'             => __( 'Day Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-bh-day-name',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'ueepb_business_hours_time_typography',
                'label'             => __( 'Time Typography', 'ueepb' ),
                'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
                'selector'          => '{{WRAPPER}} .ueepb-bh-day-time',
            ]
        );

        

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

    $business_hours_list = $this->business_hours_list();


		$id_int = substr( $this->get_id_int(), 0, 3 );
		$this->add_render_attribute( 'shortcode', 'id_int', $id_int );

		if ( isset($settings['ueepb_business_hours_design'] ) ) {
            $design = $settings['ueepb_business_hours_design'];
            $this->add_render_attribute( 'ueepb_business_hrs_design', 'class', ' ueepb-business-hours-panel ueepb-business-hours-'.$design );
        ?>

       <!--  <div class='ueepb-business-hours-panel ueepb-business-hours-design_1'  > -->
        <div <?php echo $this->get_render_attribute_string( 'ueepb_business_hrs_design' ); ?>  >
            <div class="ueepb-bh-title">
                <span>Business Hours</span>
            </div>
            <div class="ueepb-bh-pre-days">
                <span></span>
            </div>
            <div class="ueepb-bh-days">
            <?php foreach ( $settings['ueepb_business_hours'] as $key => $business_hours_day ) { ?>

                <div class="ueepb-bh-day-mon ueepb-bh-day">
                    <div class="ueepb-bh-day-name">
                        <?php echo esc_attr($business_hours_day['ueepb_business_hours_day']); ?>
                    </div>
                    <div class="ueepb-bh-day-time">
                        <?php   if( $business_hours_day['ueepb_business_hours_closed'] != 'no') { 
                                    echo __('Closed','ueepb'); 
                                }else{
                                    echo esc_attr($business_hours_list[$business_hours_day['ueepb_business_hours_opening_time']]). ' - '. esc_attr($business_hours_list[$business_hours_day['ueepb_business_hours_closing_time']]);
                                }
                        ?>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="ueepb-clear"></div>
             
            </div>

            <?php
		}
	} 

  public function business_hours_list(){
    $business_hours_list = [
            '00:00' => '12:00 AM',
            '00:30' => '12:30 AM',
            '01:00' => '1:00 AM',
            '01:30' => '1:30 AM',
            '02:00' => '2:00 AM',
            '02:30' => '2:30 AM',
            '03:00' => '3:00 AM',
            '03:30' => '3:30 AM',
            '04:00' => '4:00 AM',
            '04:30' => '4:30 AM',
            '05:00' => '5:00 AM',
            '05:30' => '5:30 AM',
            '06:00' => '6:00 AM',
            '06:30' => '6:30 AM',
            '07:00' => '7:00 AM',
            '07:30' => '7:30 AM',
            '08:00' => '8:00 AM',
            '08:30' => '8:30 AM',
            '09:00' => '9:00 AM',
            '09:30' => '9:30 AM',
            '10:00' => '10:00 AM',
            '10:30' => '10:30 AM',
            '11:00' => '11:00 AM',
            '11:30' => '11:30 AM',
            '12:00' => '12:00 PM',
            '12:30' => '12:30 PM',
            '13:00' => '1:00 PM',
            '13:30' => '1:30 PM',
            '14:00' => '2:00 PM',
            '14:30' => '2:30 PM',
            '15:00' => '3:00 PM',
            '15:30' => '3:30 PM',
            '16:00' => '4:00 PM',
            '16:30' => '4:30 PM',
            '17:00' => '5:00 PM',
            '17:30' => '5:30 PM',
            '18:00' => '6:00 PM',
            '18:30' => '6:30 PM',
            '19:00' => '7:00 PM',
            '19:30' => '7:30 PM',
            '20:00' => '8:00 PM',
            '20:30' => '8:30 PM',
            '21:00' => '9:00 PM',
            '21:30' => '9:30 PM',
            '22:00' => '10:00 PM',
            '22:30' => '10:30 PM',
            '23:00' => '11:00 PM',
            '23:30' => '11:30 PM',
            '24:00' => '12:00 PM',
            '24:30' => '12:30 PM',
        ];

      return $business_hours_list;
  }
	
}

