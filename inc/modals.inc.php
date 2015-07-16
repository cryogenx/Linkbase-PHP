<?php 
//
// -- ADD LINK MODAL WINDOWS --
//
?>
<div id="linkModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>New Link</h3>
  </div>
  <div class="modal-body">
    <form action="processlinkform.php" method="get">
		<fieldset>
			<input type="hidden" name="lid" value="<?php echo $linker;?>"/>
			<input type="hidden" name="ut" value="<?php echo $user_token;?>"/>
			<div class="input-prepend">
				<span class="add-on">Link Category</span>
				<select name="cat">
					<option value="">Select One&#8230;</option>
					<?php linker_get_cats($linker); ?>
				</select>
			</div>
			<span class="help-block">Category to file link under</span>
			<div class="input-prepend">
				<span class="add-on">Link Title</span>
   				<input type="text" name="title" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">What you want the link to display as.</span>
			<div class="input-prepend">
				<span class="add-on">Link Description</span>
   				<input type="text" name="desc" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">Descriptive text about your link (optional).</span>
			<div class="input-prepend">
				<span class="add-on">Link URL</span>
				<input type="text" name="url" placeholder="http://&#8230;">
			</div>
    		<span class="help-block">The Actual URL to your link (include the HTTP or HTTPS).</span>
			<div class="input-prepend">
				<span class="add-on">Target Window</span>
				<select name="target">
					<option value="">Select One&#8230;</option>
					<?php linker_get_targets(); ?>
				</select>
			</div>
    		<span class="help-block">The window to launch your link in.</span>
		</fieldset>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
			<button type="button" class="btn" data-dismiss="modal">Cancel</button>
		</div>
	</form>
  </div>
</div>
<?php 
//
// -- ADD CATEGORY MODAL WINDOWS --
//
?>
<div id="catModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>New Category</h3>
  </div>
  <div class="modal-body">
	  <form action="processcatform.php" method="get">
		<fieldset>
			<input type="hidden" name="lid" value="<?php echo $linker;?>"/>
			<input type="hidden" name="ut" value="<?php echo $user_token;?>"/>
			<div class="input-prepend">
				<span class="add-on">Category Name</span>
   				<input type="text" name="title" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">What you want the category named.</span>
		</fieldset>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save changes</button>
			<button type="button" class="btn" data-dismiss="modal">Cancel</button>
		</div>
	</form>
  </div>
</div>
<?php
//
// -- ADD NEW linkbase MODAL WINDOWS --
//
?>
<div id="newModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Linkbase Sign-up</h3>
    <span class="help-block">thanks for taking an interest in linkbase!.</span>
  </div>
  <div class="modal-body">
	  <form action="processnewform.php" method="get">
		<fieldset>
			<div class="input-prepend">
				<span class="add-on">User Name</span>
   				<input type="text" name="un" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">What you want your username to be.</span>
    		<div class="input-prepend">
				<span class="add-on">Email Address</span>
   				<input type="text" name="email" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">your email address.</span>
    		<div class="input-prepend">
				<span class="add-on">Linkbase Title</span>
   				<input type="text" name="title" placeholder="Type something&#8230;">
			</div>
    		<span class="help-block">What you want your linkbase to be called.</span>
		</fieldset>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Sign Up</button>
			<button type="button" class="btn" data-dismiss="modal">Cancel</button>
		</div>
		<input type="hidden" name="pass" value="<?php echo generatePassword(8, 3);?>"/>
		<input type="hidden" name="key" value="<?php echo generatePassword(20, 7);?>"/>
	</form>
  </div>
</div>
<?php ?> 