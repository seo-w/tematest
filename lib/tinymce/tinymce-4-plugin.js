//http://www.wpexplorer.com/wordpress-tinymce-tweaks/
(function() {
	tinymce.PluginManager.add('tt_mce_button', function( editor, url ) {
		editor.addButton( 'tt_mce_button', {
		  //text: 'Real Estate Shortcodes',
			type: 'menubutton',
			icon: 'themetrail',
			menu: [
						{
							text: 'Section Title',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Section Title',
									body: [
										{
											type: 'listbox',
											name: 'heading',
											label: 'Heading',
											minWidth: 300,
											'values': [
												{text: 'h1', value: 'h1'},
												{text: 'h2', value: 'h2'},
												{text: 'h3', value: 'h3'}
											]
										},
										{
											type: 'listbox',
											name: 'style',
											label: 'Style',
											minWidth: 300,
											'values': [
												{text: 'Style 1', value: '1'},
												{text: 'Style 2', value: '2'},
												{text: 'Style 3', value: '3'}
											]
										},
										{
											type: 'listbox',
											name: 'text_align',
											label: 'Text Align',
											minWidth: 300,
											'values': [
												{text: 'Center', value: 'center'},
												{text: 'Left', value: 'left'},
												{text: 'Right', value: 'right'}
											]
										},
										{
											type: 'textbox',
											name: 'heading_text',
											label: 'Heading Text',
											value: 'Heading Text Here',
											minWidth: 300
										}
									],
									onsubmit: function( e ) {
										var shortcode_str = '[section_title';
										
										if (typeof e.data.heading != 'undefined' && e.data.heading.length)
											shortcode_str += ' heading="' + e.data.heading + '"';
											
										if (typeof e.data.style != 'undefined' && e.data.style.length)
											shortcode_str += ' style="' + e.data.style + '"';
											
										if (typeof e.data.text_align != 'undefined' && e.data.text_align.length)
											shortcode_str += ' text_align="' + e.data.text_align + '"';
																				
										shortcode_str += ']' + e.data.heading_text + '[/section_title]';
 
            							//insert shortcode to TinyMCE
										editor.insertContent(shortcode_str);
									}
								});
							}
						},
						{
							text: 'Testimonials',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Testimonials',
									body: [
										{
											type: 'listbox',
											name: 'columns_testimonials',
											label: 'Columns',
											minWidth: 300,
											'values': [
												{text: '2 Column', value: '2'},
												{text: '3 Column', value: '3'},
												{text: '4 Column', value: '4'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[testimonials columns="' + e.data.columns_testimonials + '"]');
									}
								});
							}
						},
						{
							text: 'Agents',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Agents',
									body: [
										{
											type: 'listbox',
											name: 'columns_agents',
											label: 'Columns',
											minWidth: 300,
											'values': [
												{text: '2 Column', value: '2'},
												{text: '3 Column', value: '3'},
												{text: '4 Column', value: '4'}
											]
										},
										{
											type: 'listbox',
											name: 'show_order',
											label: 'Choose Order',
											minWidth: 300,
											'values': [
												{text: 'Ascending', value: 'asc'},
												{text: 'Descending', value: 'desc'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[agents columns="' + e.data.columns_agents + '" order="' + e.data.show_order +'"]');
									}
								});
							}
						},
						{
							text: 'Agent Properies',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Agent Properties',
									body: [
										{
											type: 'textbox',
											name: 'amount_agent_properties',
											label: 'Amount ("-1" to display all)',
											minWidth: 300,
											value: '-1'
										},
										{
											type: 'listbox',
											name: 'order_agent_properties',
											label: 'Choose Order',
											minWidth: 300,
											'values': [
												{text: 'Newest First', value: 'desc'},
												{text: 'Random', value: 'random'}
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[agent_properties columns="' + e.data.amount_agent_properties + '" order="' + e.data.order_agent_properties +'"]');
									}
								});
							}
						},
						{
							text: 'Single Property',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Single Property',
									body: [
										{
											type: 'textbox',
											name: 'p_id',
											label: 'Enter Property ID',
											minWidth: 300,
											value: '1'
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[single_property id="' + e.data.p_id +'"]');
									}
								});
							}
						},
						{
							text: 'Featured Properties',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Featured Properties',
									body: [
										{
											type: 'listbox',
											name: 'columns_featured',
											label: 'Columns',
											minWidth: 300,
											'values': [
												{text: '2 Column', value: '2'},
												{text: '3 Column', value: '3'},
												{text: '4 Column', value: '4'}
											]
										},
										{
											type: 'listbox',
											name: 'featured_order',
											label: 'Choose Order',
											minWidth: 300,
											'values': [
												{text: 'Ascending', value: 'asc'},
												{text: 'Descending', value: 'desc'}
											]
										},
										{
											type: 'textbox',
											name: 'num_listings',
											label: 'Please Enter Number of Listings',
											value: '',
											minWidth: 300
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[featured_properties columns="' + e.data.columns_featured + '" order="' + e.data.featured_order + '" num_of_listings="' + e.data.num_listings + '"]');
									}
								});
							}
						},
						{
							text: 'Property Listing',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Property Listing Shortcode',
									body: [
										{
											type: 'listbox',
											name: 'columns_listings',
											label: 'Columns',
											minWidth: 300,
											'values': [
												{text: '2 Column', value: '2'},
												{text: '3 Column', value: '3'},
												{text: '4 Column', value: '4'}
											]
										},
										{
											type: 'textbox',
											name: 'per_page_listings',
											label: 'Properties Per Page',
											value: '9',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'location',
											label: 'Property Location (slug)',
											value: 'london',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'status',
											label: 'Property Status (slug)',
											value: 'rent',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'type',
											label: 'Property type (slug)',
											value: 'apartment',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'features',
											label: 'Property Features (slug)',
											value: 'balcony',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'max_price',
											label: 'Max Price',
											value: '3000',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'min_rooms',
											label: 'Min Rooms',
											value: '3',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'available_from',
											label: 'Available From',
											value: '20131231',
											minWidth: 300,
											
										},
										{
											type: 'listbox',
											name: 'show_sorting_toggle_view',
											label: 'Sorting Options',
											'values': [
												{text: 'Hide', value: 'hide'},
												{text: 'Show', value: 'show'},
												
											]
										},
										{
											type: 'listbox',
											name: 'sort_by',
											label: 'Sort By',
											'values': [
												{text: 'Select', value: ''},
												{text: 'Date New', value: 'date-new'},
												{text: 'Date Old', value: 'date-old'},
												{text: 'Price High', value: 'price-high'},
												{text: 'Price Low', value: 'price-low'},
												{text: 'Name Ascending', value: 'name-asc'},
												{text: 'Name Descending', value: 'name-desc'},
												{text: 'Featured', value: 'featured'},
												{text: 'Random', value: 'random'},
												
											]
										}
									],
									onsubmit: function( e ) {
										var shortcode_str = '[property_listing';
										
										if (typeof e.data.columns_listings != 'undefined' && e.data.columns_listings.length)
											shortcode_str += ' columns="' + e.data.columns_listings + '"';
											
										if (typeof e.data.per_page_listings != 'undefined' && e.data.per_page_listings.length)
											shortcode_str += ' per_page="' + e.data.per_page_listings + '"';
											
										if (typeof e.data.location != 'undefined' && e.data.location.length)
											shortcode_str += ' location="' + e.data.location + '"';
											
										if (typeof e.data.status != 'undefined' && e.data.status.length)
											shortcode_str += ' status="' + e.data.status + '"';
											
										if (typeof e.data.type != 'undefined' && e.data.type.length)
											shortcode_str += ' type="' + e.data.type + '"';
											
										if (typeof e.data.features != 'undefined' && e.data.features.length)
											shortcode_str += ' features="' + e.data.features + '"';
											
										if (typeof e.data.max_price != 'undefined' && e.data.max_price.length)
											shortcode_str += ' max_price="' + e.data.max_price + '"';
										
										if (typeof e.data.min_rooms != 'undefined' && e.data.min_rooms.length)
											shortcode_str += ' min_rooms="' + e.data.min_rooms + '"';
										
										if (typeof e.data.available_from != 'undefined' && e.data.available_from.length)
											shortcode_str += ' available_from="' + e.data.available_from + '"';
										
										if (typeof e.data.show_sorting_toggle_view != 'undefined' && e.data.show_sorting_toggle_view.length)
											shortcode_str += ' show_sorting_toggle_view="' + e.data.show_sorting_toggle_view + '"';
										
										if (typeof e.data.sort_by != 'undefined' && e.data.sort_by.length)
											shortcode_str += ' sort_by="' + e.data.sort_by + '"';
																				
										shortcode_str += ']';
 
            							//insert shortcode to TinyMCE
										editor.insertContent(shortcode_str);
										
									}
								});
							}
						},
						{
						text: 'Property Search Form',
						onclick: function() {
								editor.insertContent('[property_search_form]');
							}
						},
						{
							text: 'Custom Property Search Form',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Custom Property Search Form',
									body: [
										{
											type: 'textbox',
											name: 'sf_location',
											label: 'Label: Property Location',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_status',
											label: 'Label: Property Status',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_type',
											label: 'Label: Property Type',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_id',
											label: 'Label: Property ID',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_price',
											label: 'Label: Price',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_size',
											label: 'Label: Size',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_rooms',
											label: 'Label: Rooms',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_bedrooms',
											label: 'Label: Bedrooms',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_bathrooms',
											label: 'Label: Bathrooms',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_garages',
											label: 'Label: Garages',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_search_keyword',
											label: 'Label: Keyword',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_available_from',
											label: 'Label: Available From',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_minprice',
											label: 'Label: Min Price',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_maxprice',
											label: 'Label: Max Price',
											value: '',
											minWidth: 300,
											
										},
										{
											type: 'textbox',
											name: 'sf_pricerange',
											label: 'Label: Price Range',
											value: '',
											minWidth: 300,
											
										},
									],
									onsubmit: function( e ) {
										var shortcode_str = '[custom_property_search_form';
																				
										if (typeof e.data.sf_location != 'undefined' && e.data.sf_location.length)
											shortcode_str += ' location="' + e.data.sf_location + '"';
											
										if (typeof e.data.sf_status != 'undefined' && e.data.sf_status.length)
											shortcode_str += ' status="' + e.data.sf_status + '"';
											
										if (typeof e.data.sf_type != 'undefined' && e.data.sf_type.length)
											shortcode_str += ' type="' + e.data.sf_type + '"';
											
										if (typeof e.data.sf_id != 'undefined' && e.data.sf_id.length)
											shortcode_str += ' id="' + e.data.sf_id + '"';
											
										if (typeof e.data.sf_size != 'undefined' && e.data.sf_size.length)
											shortcode_str += ' size="' + e.data.sf_size + '"';
										
										if (typeof e.data.sf_rooms != 'undefined' && e.data.sf_rooms.length)
											shortcode_str += ' rooms="' + e.data.sf_rooms + '"';
										
										if (typeof e.data.sf_bedrooms != 'undefined' && e.data.sf_bedrooms.length)
											shortcode_str += ' bedrooms="' + e.data.sf_bedrooms + '"';
										
										if (typeof e.data.sf_bathrooms != 'undefined' && e.data.sf_bathrooms.length)
											shortcode_str += ' bathrooms="' + e.data.sf_bathrooms + '"';
										
										if (typeof e.data.sf_garages != 'undefined' && e.data.sf_garages.length)
											shortcode_str += ' garages="' + e.data.sf_garages + '"';
										
										if (typeof e.data.sf_search_keyword != 'undefined' && e.data.sf_search_keyword.length)
											shortcode_str += ' search_keyword="' + e.data.sf_search_keyword + '"';
											
										if (typeof e.data.sf_available_from != 'undefined' && e.data.sf_available_from.length)
											shortcode_str += ' available_from="' + e.data.sf_available_from + '"';
											
										if (typeof e.data.sf_price != 'undefined' && e.data.sf_price.length)
											shortcode_str += ' price="' + e.data.sf_price + '"';
											
										if (typeof e.data.sf_pricerange != 'undefined' && e.data.sf_pricerange.length)
											shortcode_str += ' pricerange="' + e.data.sf_pricerange + '"';
											
										if (typeof e.data.sf_minprice != 'undefined' && e.data.sf_minprice.length)
											shortcode_str += ' minprice="' + e.data.sf_minprice + '"';
											
										if (typeof e.data.sf_maxprice != 'undefined' && e.data.sf_maxprice.length)
											shortcode_str += ' maxprice="' + e.data.sf_maxprice + '"';
																				
										shortcode_str += ']';
 
            							//insert shortcode to TinyMCE
										editor.insertContent(shortcode_str);
										
									}
								});
							}
						},
						{
							text: 'Map',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Map Shortcode',
									body: [
										{
											type: 'textbox',
											name: 'map_address',
											label: 'Adress',
											value: 'London, UK',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_location',
											label: 'Properties Location',
											value: 'london',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_type',
											label: 'Properties Type',
											value: 'apartment',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_status',
											label: 'Properties Status',
											value: 'rent',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_feature',
											label: 'Properties Feature',
											value: 'balcony',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_lat',
											label: 'Center Latitude',
											value: '0',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_long',
											label: 'Center Longitude',
											value: '0',
											minWidth: 300,
										},
										
										{
											type: 'textbox',
											name: 'map_zoom',
											label: 'Zoom Level',
											value: '14',
											minWidth: 300,
										},
										{
											type: 'textbox',
											name: 'map_height',
											label: 'Map Height (px)',
											value: '500px',
											minWidth: 300,
										},
										
									],
									onsubmit: function( e ) {
										editor.insertContent( '[map address="' + e.data.map_address + '" location="' + e.data.map_location +  '" type="' + e.data.map_type + '" status="' + e.data.map_status + '" features="' + e.data.map_feature + '" latitude="' + e.data.map_lat + '" longitude="' + e.data.map_long + '" zoomlevel="' + e.data.map_zoom + '" height="' + e.data.map_height + '"]');
									}
								});
							}
						},
						{
							text: 'Latest Posts',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Latest Posts Shortcode',
									body: [
										{
											type: 'textbox',
											name: 'num_posts',
											label: 'Number Of Posts',
											value: '3',
											minWidth: 300,
										},
										{
											type: 'listbox',
											name: 'columns_latest_posts',
											label: 'Columns',
											minWidth: 300,
											'values': [
												{text: '2 Column', value: '2'},
												{text: '3 Column', value: '3'},
												{text: '4 Column', value: '4'}
											]
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[latest_posts posts="' + e.data.num_posts + '" columns="' + e.data.columns_latest_posts + '"]');
									}
								});
							}
						},
						{
						text: 'Membership Packages',
						onclick: function() {
								editor.insertContent('[membership_packages]');
							}
						},
						
						
					]
				
		});
	});
})();