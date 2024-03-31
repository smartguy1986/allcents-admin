<head>
	<!-- Required meta tags -->
	<?php header('Access-Control-Allow-Origin: *'); ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="<?php echo base_url(); ?>resources/admin/assets/images/favicon-32x32.png" type="image/png" />

	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css"
		rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
		rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/metismenu/css/metisMenu.min.css"
		rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/app.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>resources/admin/assets/css/icons.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/assets/css/dark-theme.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/assets/css/semi-dark.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/assets/css/header-colors.css" />
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/jquery.min.js"></script>
	<script src='https://cdn.tiny.cloud/1/hjee0wqrtemac3r27gydm2z5pl1123l4wfi9tgcjasoywfku/tinymce/5/tinymce.min.js'
		referrerpolicy="origin"></script>
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>resources/admin/assets/plugins/select2/css/select2-bootstrap4.css"
		rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>resources/admin/assets/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>

	<!-- <script>
		// tinymce.init({
		// selector: '.topictextarea',
		// height: 300
		// });
		tinymce.init({
			selector: '.topictextarea',
			plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
			tinydrive_token_provider: 'URL_TO_YOUR_TOKEN_PROVIDER',
			tinydrive_dropbox_app_key: 'YOUR_DROPBOX_APP_KEY',
			tinydrive_google_drive_key: 'YOUR_GOOGLE_DRIVE_KEY',
			tinydrive_google_drive_client_id: 'YOUR_GOOGLE_DRIVE_CLIENT_ID',
			mobile: {
				plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable'
			},
			menu: {
				tc: {
					title: 'Comments',
					items: 'addcomment showcomments deleteallconversations'
				}
			},
			menubar: 'file edit view insert format tools table tc help',
			toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
			autosave_ask_before_unload: true,
			autosave_interval: '30s',
			autosave_prefix: '{path}{query}-{id}-',
			autosave_restore_when_empty: false,
			autosave_retention: '2m',
			image_advtab: true,
			link_list: [
				{ title: 'My page 1', value: 'https://www.tiny.cloud' },
				{ title: 'My page 2', value: 'http://www.moxiecode.com' }
			],
			image_list: [
				{ title: 'My page 1', value: 'https://www.tiny.cloud' },
				{ title: 'My page 2', value: 'http://www.moxiecode.com' }
			],
			image_class_list: [
				{ title: 'None', value: '' },
				{ title: 'Some class', value: 'class-name' }
			],
			importcss_append: true,
			templates: [
				{ title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
				{ title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
				{ title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
			],
			template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
			template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
			height: 600,
			image_caption: true,
			quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
			noneditable_noneditable_class: 'mceNonEditable',
			toolbar_mode: 'sliding',
			spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
			tinycomments_mode: 'embedded',
			content_style: '.mymention{ color: gray; }, p{ line-height: 26px !important;}',
			contextmenu: 'link image imagetools table configurepermanentpen',
			a11y_advanced_options: true,
			content_css: "<?php echo base_url(); ?>resources/admin/assets/css/mycustomtinymce.css",
			remove_linebreaks: false,
			// skin: useDarkMode ? 'oxide-dark' : 'oxide',
			// content_css: useDarkMode ? 'dark' : 'default',
			/*
			The following settings require more configuration than shown here.
			For information on configuring the mentions plugin, see:
			https://www.tiny.cloud/docs/plugins/premium/mentions/.
			*/
			// mentions_selector: '.mymention',
			// // mentions_fetch: mentions_fetch,
			// mentions_menu_hover: mentions_menu_hover,
			// mentions_menu_complete: mentions_menu_complete,
			// mentions_select: mentions_select,
			// mentions_item_type: 'profile'
		});
	</script> -->
	<script src="https://cdn.tiny.cloud/1/ty1gurq04cs6sv9eu240cs3qjaxnub6aco05vlyhaknfl34p/tinymce/6/tinymce.min.js"
		referrerpolicy="origin"></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
			toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
			tinycomments_mode: 'embedded',
			tinycomments_author: 'Author name',
			mergetags_list: [
				{ value: 'First.Name', title: 'First Name' },
				{ value: 'Email', title: 'Email' },
			],
			ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
		});
	</script>
	<title>African Apostolic Church App Backend</title>
	<base href="<?php echo base_url(); ?>">
	<style>
		canvas {
			position: inherit !important;
		}

		.canvasjs-chart-canvas {
			width: 100% !important;
			max-height: 250px !important;
			overflow: hidden !important;
		}

		.canvasjs-chart-credit {
			display: none !important;
		}

		.tox-notifications-container {
			display: none !important;
		}
	</style>
</head>