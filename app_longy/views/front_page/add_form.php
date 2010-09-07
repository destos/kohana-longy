<div class="box">
	<h2>Longyfy a url!</h2>
	
	<div class="form_box">
		<form action="" method="post" id="add_form" >
			<fieldset>
			<label for="url" class="topper">URL:</label>
			<input type="text" name="url" id="url" value="<?=$post['url'];?>"/>
			
			<div>
				<label class="topper">Length:</label>
				<label for="long" ><input type="radio" id="long" name="length" value="1" checked="checked" />Longer</label>
				<label for="verylong" ><input type="radio" id="verylong" name="length" value="2" />Very long<sup>(1)</sup></label>
				<label for="longest" ><input type="radio" id="longest" name="length" value="3" />As long as possible<sup>(1)</sup></label>
				<input type="submit" value="Longyfy!"/>
			</div>
			</fieldset>
<?php if ( ! empty($errors)): ?>

<ul class="errors">
<?php foreach ($errors as $error): ?>
<li><?php echo __($error) ?></li>
<?php endforeach ?>
</ul>

<?php endif ?>

		</form>
	</div>
</div>