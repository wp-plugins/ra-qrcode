

(function() {
    tinymce.PluginManager.add('ra_qrcode_button', function( editor, url ) {

	var myOptions = {
	    // you can declare a default color here,
	    // or in the data-default-color attribute on the input
	    defaultColor: false,
	    // a callback to fire whenever the color changes to a valid color
	    change: function(event, ui){},
	    // a callback to fire when the input is emptied or an invalid color
	    clear: function() {},
	    // hide the color picker controls on load
	    hide: true,
	    // show a group of common colors beneath the square
	    // or, supply an array of colors to customize further
	    palettes: true
	};

    	function onPanelClick(){
    		alert('ok');
    	}

        editor.addButton( 'ra_qrcode_button', {
            title: 'ra-QRcode',
            icon: 'icon ra-code-icon',
            onclick: function() {
			    editor.windowManager.open( {
			        title: 'Insert QRCode',
			        body: [{
			            type: 'textbox',
			            name: 'content',
			            label: 'Content',
			            tooltip: 'Leave it blank to use actual URL',
			            multiline: true,
			            minWidth: 300,
						minHeight: 100,
						value: ''
			        },
					{
			            type: 'textbox',
			            name: 'size',
			            label: 'Size in pixel',
			            tooltip: 'Write only 1 value',
						value: '100'
			        },
					{
			            type: 'textbox',
			            name: 'alt',
			            label: 'Alternative text',
			            tooltip: 'It indicates the alternative text for the image',
						value: 'scan QR code'
			        },			        
					{
						type: 'listbox',
						name: 'click',
						label: 'QRCode clickable?',
						'values': [
							{text: 'Yes', value: 'yes'},
							{text: 'No', value: 'no'}
						]
					},
					{
			            type: 'textbox',
			            name: 'foreground',
			            label: 'Foregroundcolor',
						value: '#000000',
						classes: 'color1',
					},
					{
			            type: 'textbox',
			            name: 'background',
			            label: 'Backgroundcolor',
						value: '#ffffff',
						classes: 'color2',
						//onclick: onButtonClick
						onPostRender: function() {
							jQuery('.mce-color1').wpColorPicker(myOptions);
							jQuery('.mce-color2').wpColorPicker(myOptions);
							jQuery('.wp-picker-container').css('padding-left', '150px');
							jQuery('.wp-picker-holder').css('padding-top', '10px');
							
							jQuery('.wp-color-result').css('padding-left', '50px');
							jQuery('.wp-picker-holder').css('position', 'relative');
							jQuery('.wp-picker-holder').css('z-index', '9999999');
							jQuery('.iris-picker').css('background-color', '#ccc');
							jQuery('.iris-picker').css('border', '30px solid #ccc');

						}

					}

			        ],
			        onsubmit: function( e ) {
			       		var output = '[qrcode';
			       		if(e.data.content != '') {
			       			output += ' content="' + e.data.content + '"';
			       		}

			       		output += ' size="' + e.data.size + '"';
			       		output += ' alt="' + e.data.alt + '"';
			       		output += ' click="' + e.data.click + '"';
			       		output += ' fgcolor="' + e.data.foreground + '"';
			       		output += ' bgcolor="' + e.data.background + '"';
			       		output += ' ]';

			            editor.insertContent( output) ;
			        }
			    });
			}
        });
    });


})();
