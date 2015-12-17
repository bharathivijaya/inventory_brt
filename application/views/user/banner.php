<?php
/**
 * Created by PhpStorm.
 * User: Tan4ik
 * Date: 17.04.15
 * Time: 22:36
 */
?>
<div class="page-content" style="margin-left:230px;margin-top:-20px;background-color:white;">
                          
                                <div class="panel">
                                    <div class="panel-body">
<img src="<?=base_url()?>images/banners/<?=$banner['b_image']?>" alt="Advertisement" width="<?=$banner['size']['w']?>" height="<?=$banner['size']['h']?>">
<br/>
<? if($this->session->userdata('type') == 'admin') {?>
    <a href="<?=base_url()?>admin/" class="btn btn-lg btn-success">Continue</a>
<?} else {?>
<a href="<?=base_url()?>user/profile" class="btn btn-lg btn-success">Continue</a>
<?}?>
</div>
</div></div>