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
  <p>
    <?php echo $this->text('Generating will start immediately once you press a button. Status of generated entities will be set randomly, some of them will be available publicly!'); ?>
  </p>
  <div class="row">
    <?php foreach ($generators as $items) { ?>
    <div class="col-md-3">
      <?php foreach ($items as $id => $name) { ?>
      <button class="btn btn-default btn-block" name="generate" value="<?php echo $this->e($id); ?>"><?php echo $this->e($name); ?></button>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</form>