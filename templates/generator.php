<?php

/**
 * @package Faker
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License 3.0
 */
 ?>
<form method="post" class="form-horizontal">
  <input type="hidden" name="token" value="<?php echo $_token; ?>">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="form-group">
        <div class="col-md-12">
          <?php echo $this->text('Generating will start immediately once you press a button. Status of generated entities will be set randomly, some of them will be available publicly!'); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <div class="btn-toolbar">
            <?php foreach($generators as $id => $model) { ?>
            <button class="btn btn-default" name="generate" value="<?php echo $this->e($id); ?>"><?php echo $this->e($model->getName()); ?></button>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>