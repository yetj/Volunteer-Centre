<!-- tinymce -->
<? if (!isset($next)): ?>
	<script src="/js/tinymce/tinymce.min.js"></script>
<? endif ?>

<script>
	tinymce.init({
		  selector: 'textarea<?= isset($id) ? "#".$id : "";  ?>',
		  height: <?= isset($height) ? $height : 500;  ?>,
		  plugins: [
		    "advlist autolink lists link image charmap preview anchor",
		    "searchreplace visualblocks code fullscreen",
		    "insertdatetime media table paste imagetools"
		  ],
		  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
</script>