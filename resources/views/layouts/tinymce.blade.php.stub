<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
	let editor_config = {
		path_absolute: '{{ url('/') }}',
		selector: '{{ $editor }}',
		valid_elements: '*[*]',
		plugins: [
			'advlist autolink autoresize lists link image imagetools charmap hr anchor',
			'searchreplace wordcount visualblocks visualchars code codesample fullscreen',
			'insertdatetime media nonbreaking table contextmenu directionality',
			'emoticons autosave paste textcolor colorpicker textpattern toc',
		],
		toolbar: 'undo redo restoredraft | styleselect forecolor backcolor emoticons | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent charmap insertdatetime toc | anchor link image media | code codesample visualchars visualblocks',
		imagetools_cors_hosts: ['*'],
		insertdatetime_formats: ['%H:%M:%S', '%Y-%m-%d', '%I:%M:%S %p', '%D', '%A, %b %d, %Y'],
		relative_urls: false,
		force_br_newlines: false,
		force_p_newlines: false,
		forced_root_block: '',
		file_browser_callback: function(field_name, url, type, win) {
			let x = window.innerWidth || document.documentElement.clientWidth ||
					document.getElementsByTagName('body')[0].clientWidth;
			let y = window.innerHeight || document.documentElement.clientHeight ||
					document.getElementsByTagName('body')[0].clientHeight;

			let cmsURL = editor_config.path_absolute + '/file-manager?field_name=' + field_name;
			if (type === 'image') {
				cmsURL = cmsURL + '&type=Images';
			} else {
				cmsURL = cmsURL + '&type=Files';
			}

			tinyMCE.activeEditor.windowManager.open({
				file: cmsURL,
				title: 'File Manager',
				width: x * 0.8,
				height: y * 0.8,
				resizable: 'yes',
				close_previous: 'no',
			});
		},
	};
	// Initialize TinyMCE
	// tinymce.init(editor_config);


	tinymce.init({
    selector: "textarea",
    toolbar: "mybutton | undo redo restoredraft | styleselect forecolor backcolor emoticons | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent charmap insertdatetime toc | anchor link  media | code codesample visualchars visualblocks",
		path_absolute: '{{ url('/') }}',
		selector: '{{ $editor }}',
		valid_elements: '*[*]',
		plugins: [
			'advlist autolink autoresize lists link  imagetools charmap hr anchor',
			'searchreplace wordcount visualblocks visualchars code codesample fullscreen',
			'insertdatetime media nonbreaking table contextmenu directionality',
			'emoticons autosave paste textcolor colorpicker textpattern toc',
		],
		// toolbar: 'undo redo restoredraft | styleselect forecolor backcolor emoticons | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent charmap insertdatetime toc | anchor link image media | code codesample visualchars visualblocks',
		imagetools_cors_hosts: ['*'],
		insertdatetime_formats: ['%H:%M:%S', '%Y-%m-%d', '%I:%M:%S %p', '%D', '%A, %b %d, %Y'],
		relative_urls: false,
		force_br_newlines: false,
		force_p_newlines: false,
		forced_root_block: '',
    setup: function(editor) {
        editor.addButton('mybutton', {
            icon: 'image',
						tooltip: 'Upload Image On Your Local File',
            onclick: function(e) {
                console.log($(e.target));
                if($(e.target).prop("tagName") == 'BUTTON'){

if($(e.target).parent().parent().find('input').attr('id') != 'tinymce-uploader') {
                $(e.target).parent().parent().append('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
                    }
                $('#tinymce-uploader').trigger('click');
                $('#tinymce-uploader').change(function(){
                 var input, file, fr, img;

            if (typeof window.FileReader !== 'function') {
                write("The file API isn't supported on this browser yet.");
                return;
            }

            input = document.getElementById('tinymce-uploader');
            if (!input) {
                write("Um, couldn't find the imgfile element.");
            }
            else if (!input.files) {
                write("This browser doesn't seem to support the `files` property of file inputs.");
            }
            else if (!input.files[0]) {
                write("Please select a file before clicking 'Load'");
            }
            else {
                file = input.files[0];
                fr = new FileReader();
                fr.onload = createImage;
                fr.readAsDataURL(file);
            }

            function createImage() {
                img = new Image();
                img.src = fr.result;
                 editor.insertContent('<img src="'+img.src+'"/>');

            }

                });

            }
                         if($(e.target).prop("tagName") == 'DIV'){
                             if($(e.target).parent().find('input').attr('id') != 'tinymce-uploader') {
 console.log($(e.target).parent().find('input').attr('id'));
                $(e.target).parent().append('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
                             }
                $('#tinymce-uploader').trigger('click');
                $('#tinymce-uploader').change(function(){
                 var input, file, fr, img;

            if (typeof window.FileReader !== 'function') {
                write("The file API isn't supported on this browser yet.");
                return;
            }

            input = document.getElementById('tinymce-uploader');
            if (!input) {
                write("Um, couldn't find the imgfile element.");
            }
            else if (!input.files) {
                write("This browser doesn't seem to support the `files` property of file inputs.");
            }
            else if (!input.files[0]) {
                write("Please select a file before clicking 'Load'");
            }
            else {
                file = input.files[0];
                fr = new FileReader();
                fr.onload = createImage;
                fr.readAsDataURL(file);
            }

            function createImage() {
                img = new Image();
                img.src = fr.result;
                 editor.insertContent('<img src="'+img.src+'"/>');

            }

                });

            }
                                if($(e.target).prop("tagName") == 'I'){
console.log($(e.target).parent().parent().parent().find('input').attr('id')); if($(e.target).parent().parent().parent().find('input').attr('id') != 'tinymce-uploader') {               $(e.target).parent().parent().parent().append('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
                                                                                           }
                $('#tinymce-uploader').trigger('click');
                $('#tinymce-uploader').change(function(){
                 var input, file, fr, img;

            if (typeof window.FileReader !== 'function') {
                write("The file API isn't supported on this browser yet.");
                return;
            }

            input = document.getElementById('tinymce-uploader');
            if (!input) {
                write("Um, couldn't find the imgfile element.");
            }
            else if (!input.files) {
                write("This browser doesn't seem to support the `files` property of file inputs.");
            }
            else if (!input.files[0]) {
                write("Please select a file before clicking 'Load'");
            }
            else {
                file = input.files[0];
                fr = new FileReader();
                fr.onload = createImage;
                fr.readAsDataURL(file);
            }

            function createImage() {
                img = new Image();
                img.src = fr.result;
                 editor.insertContent('<img src="'+img.src+'"/>');

            }

                });

            }

            }
        });
    }});




</script>
