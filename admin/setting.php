<style>
    small{display: block;}
    textarea{min-width:60%;}
</style>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#"><?php $this->e('Setting', '設定') ?></a>
        </li>
        <?php if(!$this->is_pro()): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $this->setting_url('addon'); ?>"><?php $this->e('Add-ons', 'アドオン') ?></a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $this->setting_url('install'); ?>"><?php $this->e('Installation', 'インストール方法') ?></a>
        </li>
    </ul>
    <h2 class="mt-4 mb-4"><?php $this->e('Top Rank Content Checker','上位表示コンテンツチェッカー') ?></h2>
    <form method="post" action="options.php">
         <?php 
         settings_fields( 'trcc_option_group' ); 
         do_settings_sections( 'trcc_option_group' );
        ?>
        <div class="row mt-4">
            <div class="col-md-2">
                <?php $this->e('Google Auth Key','Google auth キー') ?>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="text" name="trcc_google_custom_search_key" value="<?php echo esc_attr( get_option('trcc_google_custom_search_key') ); ?>" />
                <p>
                    <a href="https://console.cloud.google.com/?hl=ja" target="_blank">Go To Google Cloud Console</a>
                </p>
                <small>
                    <a href="<?php echo $this->setting_url('install'); ?>">
                        <?php $this->e('If you don\'t know how to get Google Auth key,please look at installation guide.','Google Auth キーの取得方法が分からない方は、こちらのインストール方法をみてください。') ?> 
                    </a>
                </small>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-2">
                <?php $this->e('Google Custom Search ID','Googleカスタム検索ID'); ?>
            </div>
            <div class="col-md-8">
                <input class="form-control" type="text" name="trcc_google_cx" value="<?php echo esc_attr( get_option('trcc_google_cx') ); ?>" />
                <p>
                    <small>
                        <a href="<?php echo $this->setting_url('install'); ?>">
                            <?php $this->e('where Google Custom Search ID','Googleカスタム検索IDの調べ方が分からない方はこちら') ?> 
                        </a>
                    </small>
                </p>
            </div>
        </div>
        <?php submit_button(); ?>
    </form>
</div>