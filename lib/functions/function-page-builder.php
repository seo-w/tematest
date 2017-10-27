<?php
/* SITEORIGIN PAGE BUILDER
https://siteorigin.com/docs/page-builder/widget-groups/
============================== */

if ( ! function_exists( 'tt_add_widget_tabs' ) ) {
	
	function tt_add_widget_tabs( $tabs ) {
		
		//$tabs['recommended'] = array();
		
		$tabs[] = array(
			'title' => __( 'Realty Widgets', 'tt' ),
			'filter' => array(
				'groups' => array( 'realty-widgets' )
			)
		);
		
		return $tabs;
	}

}
add_filter( 'siteorigin_panels_widget_dialog_tabs', 'tt_add_widget_tabs', 21 );

if ( ! function_exists( 'tt_add_widget_icons' ) ) {
	
	function tt_add_widget_icons( $widgets ) {
		$widgets['widget_agent_properties']['groups'] = array( 'realty-widgets' );
		$widgets['widget_custom_property_search_form']['groups'] = array( 'realty-widgets' );
		$widgets['widget_agents']['groups'] = array( 'realty-widgets' );
		$widgets['widget_featured_properties']['groups'] = array( 'realty-widgets' );
		$widgets['widget_latest_posts']['groups'] = array( 'realty-widgets' );
		$widgets['widget_membership_packages']['groups'] = array( 'realty-widgets' );
		$widgets['widget_property_listing']['groups'] = array( 'realty-widgets' );
		$widgets['widget_property_map']['groups'] = array( 'realty-widgets' );
		$widgets['widget_property_search']['groups'] = array( 'realty-widgets' );
		$widgets['widget_single_property']['groups'] = array( 'realty-widgets' );
		$widgets['widget_testimonials']['groups'] = array( 'realty-widgets' );
		return $widgets;
	}

}
add_filter( 'siteorigin_panels_widgets', 'tt_add_widget_icons' );


/**
 * Enqueue all my widget's admin scripts
 * https://siteorigin.com/docs/page-builder/widget-compatibility/
 */

function mywidget_enqueue_scripts(){
   //add script here if needed
}
add_action( 'admin_enqueue_scripts', 'mywidget_enqueue_scripts');