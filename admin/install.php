<div class="wrap">
	<ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $this->setting_url(''); ?>"><?php $this->e('Setting', '設定') ?></a>
    </li>
    <?php if(!$this->is_pro()): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo $this->setting_url('addon'); ?>"><?php $this->e('Add-ons', 'アドオン') ?></a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link active" href="#"><?php $this->e('Installation', 'インストール方法') ?></a>
    </li>
</ul>

	<h2 class="mt-4 mb-4">
		<?php $this->e('This is Installation guide','インストール方法の説明') ?>
	</h2>
	<h4>
		<?php $this->e('1.Get API key'); ?>
	</h4>
	<p>
		<?php $this->e('If you not have Google Account,Create Google Account'); ?>
	</p>
	<p><a href="https://accounts.google.com/signup/v2/webcreateaccount"><?php $this->e('Create Google Account') ?></a></p>

	<p>
		<?php $this->e('Next,access to <a href="https://console.cloud.google.com/">Google Cloud Console</a>') ?>
	</p>
	<p>
		<?php $this->e('Select "APIs and Services"-> "Dashboard" from the top left menu.') ?>
	</p>
	<p><?php $this->e('Click "Enable API and Service" on the screen.') ?></p>	
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_1.png' ?>">
	</p>
	<p><?php $this->e('I will move to the screen to search for the API, so I will search for "Custom Search" here, search for "Custom Search API" and activate it..') ?></p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_2.png' ?>">
	</p>
	<p>
		<?php $this->e('When activation is complete, from menu "API and service" → "Authentication information" → "Create authentication information" → "API key" and press to issue the API key.') ?>
	</p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_3.png' ?>">
	</p>
	<h4>
		<?php $this->e('2.Setting'); ?>
	</h4>
	<p>
		<?php $this->e('Please enter the API key from "Top Rank Content Checker"-> "Google auth key" for the previously acquired APi key.') ?>
	</p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_4.png' ?>">
	</p>
	<p>
		<?php $this->e('Next, go to Custom Search Engine.'); ?>
	</p>
	<p>
		<a href="https://cse.google.com/cse/all" target="_blank">Custom Search Engine（CSE）</a>
	</p>
	<p>
		<?php $this->e('And create New Search Engine.Enter information according to the reference below.'); ?>
	</p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_5.png' ?>">
	</p>
	<p>
		<?php $this->e('And go to edit page on this Custom Search Engine.Delete search site. And you can get Google Custom Search ID.'); ?>
	</p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_6.png' ?>">
	</p>
	<p>
		<?php $this->e('If you complete configuration,you could use top rank checker in post editor.'); ?>
	</p>
	<p>
		<img style="max-width:50%" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/install_guide_7.png' ?>">
	</p>
	<p>
		<?php $this->e('Price is based on <a href="https://developers.google.com/custom-search/v1/overview" target="_blank">Custom Search API</a> (100 request per 1day for free)'); ?>
	</p>
	
</div>