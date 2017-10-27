(function () {
	// create tt_shortcodes plugin
	tinymce.create("tinymce.plugins.tt_mce_button",
	{
		init: function ( ed, url )
		{

		},
		createControl: function ( btn, e )
		{
			if ( btn == "tt_mce_button" ) {	
			
				var a = this;

				var btn = e.createSplitButton('tt_mce_button', {
	      	//title: 'Real Estate Shortcodes',
					image: abspath.template_url + '/lib/tinymce/tinymce-icon.png',
					icons: false
        });

        btn.onRenderMenu.add(function (c, b) {	
				
					a.addImmediate( b, 'Section Title', '[section_title heading="h2" style="2" text_align="center"]My Section Title[/section_title]' );
					a.addImmediate( b, 'Testimonials', '[testimonials columns="2"]' );
					a.addImmediate( b, 'Agents', '[agents columns="2" order="DESC"]' );
					a.addImmediate( b, 'Single Property', '[single_property id="1"]' );
					a.addImmediate( b, 'Featured Properties', '[featured_properties columns="2" order="desc" num_of_listings="3"]' );
					a.addImmediate( b, 'Property Listing', '[property_listing columns="3" per_page="10" location="london" status="rent" type="apartment" features="balcony" max_price="3000" min_rooms="3" available_from="20131231" show_sorting_toggle_view="show" sort_by="date-new"]' );
					a.addImmediate( b, 'Multiple Property Search Form', '[property_search_form]' );
					a.addImmediate( b, 'Property Search Form', '[property_multiple_search_form  location="Location" status="Status" type="Type" id="ID" size="Size" rooms="Rooms" bedrooms="Bedrooms" bathrooms="Bathrooms" garages="Garages" search_keyword="Search Key" available_from="Available From" price="Price" price="Price" pricerange="From" minprice="Min Price" maxprice="Max Price"]' );
					a.addImmediate( b, 'Map', '[map address="London, UK" zoomlevel="14" height="500px"]' );
					a.addImmediate( b, 'Latest Posts', '[latest_posts posts="3" columns="2"]' );
					a.addImmediate( b, 'Membership Packages', '[membership_packages]' );
					
				});
                
        return btn;
        
			}
			
			return null;
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname 	: "ThemeTrail",
        author 		: 'ThemeTrail',
        authorurl : 'http://themetrail.com',
        infourl 	: 'http://tinymce.com/wiki.php',
        version 	: "1.0"
			}
		}
	});
	
	// Register plugin
	tinymce.PluginManager.add("tt_mce_button", tinymce.plugins.tt_mce_button);
})();