<h2>CMS</h2>

<?if (!@empty($page)){?>
    <form action="<?=base_url()?>admin/save" method="post">
        <input type="hidden" name="pg_id" value="<?=$page['pg_id']?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" value="<?=$page['pg_title']?>" name="pg_title" class="form-control">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="pg_content" rows="15"><?=$page['pg_content']?></textarea>
        </div>
        <input type="submit" value="Save" class="btn btn-primary">
    </form>
<?} else {?>
    <form action="" method="post" class="middle">
        <div class="form-group">
            <label>Select the page to edit</label>
            <select name="page" class="form-control">
                <?foreach ($pages as $one) {?>
                    <option value="<?=$one['pg_id']?>"><?=$one['pg_title']?></option>
                <?}?>
            </select>
        </div>
        <input type="submit" value="Continue" class="btn btn-primary">
    </form>
<?}?>

<form id="my_form" action="/admin/uploadImage/" method="post" enctype="multipart/form-data" style="width:0px; height:0; overflow:hidden;">
	<input name="image" type="file" onchange="$('#my_form').submit();">
</form>

<script>
	$(document).ready(function() {
		tinymce.init({
			selector: "textarea:not(.noMCE)",
			menubar: false,
		 	plugins: "textcolor link image imagetools",
		 	toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link | image upload_image",
			setup : function(ed) {
				ed.addButton('upload_image', {
					title: 'Upload image',
					image: '/assets/js/editor/skins/upload_image.png',
					onclick: function () {
						ed.focus();
						$('#my_form input').click();
					}
				});
			}
		});
	});

	$('#my_form').on('submit',(function(e) {
		e.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			type:'POST',
			url: $(this).attr('action'),
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success:function(data){
				console.log("success");
				console.log(data);
				tinymce.activeEditor.execCommand('mceInsertContent', false, '<img style="width: 25%;" src="<?=base_url()?>/assets/files/images/' + data + '">');
				//$('.mce-i-browse').parent().parent().parent().find('input').first().val('/assets/files/'+data);
			},
			error: function(data){
				console.log("error");
				console.log(data);
			}
		});

		return false;
	}));
</script>
