<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>

<script>
	$(document).ready(function () {
		$('{{ $editor }}').summernote({
			height: 200
		});
	});
</script>
