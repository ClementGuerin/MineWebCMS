	<div class="row-fluid">

		<div class="span12">

			<div class="top-bar">
				<h3><i class="icon-cog"></i> <?= $Lang->get('CUSTOMIZATION') ?></h3>
			</div>

			<div class="well no-padding">
				<?= $this->Form->create(false, array(
					'class' => 'form-horizontal'
				)); ?>
					<div class="control-group">
						<label class="control-label"><?= $Lang->get('SLIDER') ?></label>
						<div class="controls">
							<?php 
							if($config['slider'] == 'true') {
								$checked = true;
							} else {
								$checked = false;
							}
							?>
							<?= $this->Form->checkbox(false, array(
								'div' => false,
			    				'name' => 'slider',
			    				'id' => 'slider',
			    				'class' => 'span6 m-wrap',
			    				'value' => $config['slider'],
			    				'checked' => $checked
							)); ?>
						</div>
					</div>

					<script>
						$('#slider').change(function(){
							if($('#slider').is(':checked')) {
								$('#slider').attr('value', 'true');
							} else {
								$('#slider').attr('value', 'false');
							}
						});
					</script>

					<div class="control-group">
						<label class="control-label"><?= $Lang->get('BACKGROUND_URL') ?></label>
						<div class="controls">
							<?= $this->Form->input(false, array(
								'div' => false,
							    'type' => 'text',
			    				'name' => 'background_url',
			    				'class' => 'span6 m-wrap',
			    				'placeholder' => $Lang->get('DEFAULT').' : http://subtlepatterns.com/patterns/geometry2.png',
			    				'value' => $config['background_url']
							)); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label"><?= $Lang->get('FAVICON_URL') ?></label>
						<div class="controls">
							<?= $this->Form->input(false, array(
								'div' => false,
							    'type' => 'text',
			    				'name' => 'favicon_url',
			    				'class' => 'span6 m-wrap',
			    				'value' => $config['favicon_url']
							)); ?>
						</div>
					</div>

					<div class="form-actions">
						<?= $this->Form->button($Lang->get('SUBMIT'), array(
							'type' => 'submit',
							'class' => 'btn btn-primary'
						)); ?>
						<a href="<?= $this->Html->url(array('controller' => 'theme', 'action' => 'index', 'admin' => true)) ?>" type="button" class="btn"><?= $Lang->get('CANCEL') ?></a>     
					</div>

				</form>          

			</div>

		</div>

	</div>