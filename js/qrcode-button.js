(function() {
    tinymce.PluginManager.add('ra_qrcode_button', function( editor, url ) {
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
			       		output += ' ]';

			            editor.insertContent( output) ;
			        }
			    });
			}
        });
    });
})();