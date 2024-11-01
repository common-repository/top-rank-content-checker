 <div class="wrap plugin-wrap">

    <div class="plugin-main-area">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->setting_url(''); ?>"><?php $this->e('Setting', '設定') ?></a>
        </li>
        <?php if(!$this->is_pro()): ?>
        <li class="nav-item">
            <a class="nav-link active" href="#"><?php $this->e('Add-ons', 'アドオン') ?></a>
        </li>
    <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->setting_url('install'); ?>"><?php $this->e('Installation', 'インストール方法') ?></a>
        </li>
    </ul>
    <h2 class="mt-4 mb-4"><?php $this->e('Top Rank Content Checker','上位表示コンテンツチェッカー') ?></h2>
    <p>
        <?php $this->e('Top Rank Content Checker','上位表示コンテンツチェッカー'); $this->e('Add-Ons' ); ?>
    </p>
    <div class="plugin_contents">

        <div class="plugin_content">
            <form action="" method="post" id="form">
                <?php wp_nonce_field( 'auto-youtube-summarize' );?>
                <div class="mt-4">
                    <h3><?php $this->e('Addon\'s Feature','アドオン') ?></h3>
                    <p>
                        <?php $this->e( 'Add-Ons will enable you to do this.', 'アドオンを購入すると以下のことが行えるようになります。' ) ?>
                    </p>
                    <ul class="list-group">
                        <li class="list-group-item"><?php $this->e('Content with search ranking 4 to 10 is also displayed.','検索順位が4~10位のコンテンツも表示されます。') ?></li>
                        <li class="list-group-item"><?php $this->e('You can easily add headings from the editor (in Classic Editor only).','エディターから簡単に見出しを追加できます（クラシックエディターのみ）。') ?></li>
                    </ul>  
                    <img style="max-width:80%;" src="<?php echo TRCC_PLUGIN_URL . '/includes/image/addon_1.png' ?>" alt="">
                </div>
                <div class="mt-4">
                    <h3><?php $this->e('How to get Addon','アドオンの購入方法') ?></h3>
                    <p class="lead">- <a href="https://gum.co/eQCka" target="_blank">Gumroad</a>
                        <small>$9.8</small>
                    </p>
                    <p class="lead">- <a href="https://ruana-wp.stores.jp/items/5cf4c2190b921128ba9e064b" target="_blank">STORES.JP (Japan)</a>
                        <small>¥980</small></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>