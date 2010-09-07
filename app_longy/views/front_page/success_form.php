<div class="box success">
	<h2>Success! here is your new longer url!</h2>
	
	<div class="form_box">
		<form id="success_form" >
			<fieldset>
			<label for="hash" class="topper">Longy URL:</label>
			<textarea name="hash"><?=$hash_url?></textarea>
			</fieldset>
		</form>
	</div>
	<a class="add" href="<? URL::base();?>">Create another!</a>
</div>