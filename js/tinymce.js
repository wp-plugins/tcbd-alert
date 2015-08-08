(function() {
	tinymce.PluginManager.add('tcbd_alert_mce_button', function( editor, url ) {
		editor.addButton( 'tcbd_alert_mce_button', {
			icon: false,
			type: 'button',
			title: 'TCBD Alert',
			image : url + '/icon.png',
			onclick: function() {
				editor.windowManager.open( {
					title: 'TCBD Alert',
					body: [
						{
							type: 'textbox',
							name: 'alertcontentBox',
							label: 'Alert Text',
							multiline: true,
							minWidth: 300,
							minHeight: 60
						},
						{
							type: 'listbox',
							name: 'alerttypebox',
							label: 'Alert Type',
							'values': [
								{text: 'Success', value: 'success'},
								{text: 'Info', value: 'info'},
								{text: 'Warning', value: 'warning'},
								{text: 'Danger', value: 'danger'}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[tcbd-alert type="' + e.data.alerttypebox + '"]' + e.data.alertcontentBox + '[/tcbd-alert]');
					}
				});
			}
		});
	});
})();