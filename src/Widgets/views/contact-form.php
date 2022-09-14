<?php

use Maslosoft\Staple\Widgets\ContactForm;

/*
  This should be in language specific file:
  $label = (object) [
  'name' => 'Full name',
  'email' => 'E-mail',
  'subject' => 'Message subject',
  'body' => 'Message body',
  'submit' => 'Send',
  'success' => 'Message has been send, thank you %s'
  ];
  $errorLabels = [
  'name' => 'Full name is required',
  'email' => 'E-mail is required',
  'emailFormat' => 'E-mail is not properly formatted',
  'subject' => 'Message subject is required',
  'body' => 'Message body is required',
  ];
 */
/* @var $this ContactForm */
/* @var $errorLabels array */
/* @var $label object */
$error = new stdClass;
foreach ($this->error as $errId)
{
	$error->$errId = $errorLabels[$errId];
}
var_dump($error, $label, $this->isSuccess());
$value = (object)@$_POST['ContactForm'];
?>

<div class="form">
	<?php if ($this->isSuccess()): ?>
        <div class="alert alert-success">
			<?= sprintf($label->success, htmlspecialchars(@$value->name)); ?>
        </div>
		<?php
		// Reset values upon successfully send
		$value = new stdClass;
		?>
	<?php endif; ?>
	<?php if (!empty($this->error)): ?>
        <div class="alert alert-danger">
			<?= implode("<br />", (array)$error); ?>
        </div>
	<?php endif; ?>
    <form action="" method="post">
        <div class="form-group" id="msff_k_gid">
            <label class="control-label" for="msff_k"></label>
            <input id="msff_k" name="email" class=" form-control" type="text" autocomplete="off"
                   value="<?= @$_POST['email']; ?>"/>
        </div>
		<?php if ($this->hasField('name')): ?>
            <div class="form-group" id="msff_l_gid">
                <label class="control-label" for="msff_l"><?= $label->name; ?></label>
                <input id="msff_l" name="ContactForm[name]" value="<?= @$value->name; ?>" class=" form-control"
                       type="text"/>
                <span class="help-block error" id="msff_l_em"><?= @$error->name; ?></span>
            </div>
		<?php endif; ?>
		<?php if ($this->hasField('email')): ?>
            <div class="form-group" id="msff_m_gid">
                <label class="control-label" for="msff_m"><?= $label->email; ?></label>
                <input id="msff_m" name="ContactForm[email]" value="<?= @$value->email; ?>" class=" form-control"
                       type="text"/>
                <span class="help-block error" id="msff_m_em"><?= @$error->email; ?></span>
                <span class="help-block error" id="msff_m_em2"><?= @$error->emailFormat; ?></span>
            </div>
		<?php endif; ?>
		<?php if ($this->hasField('subject')): ?>
            <div class="form-group" id="msff_n_gid">
                <label class="control-label" for="msff_n"><?= $label->subject; ?></label>
                <input id="msff_n" name="ContactForm[subject]" value="<?= @$value->subject; ?>" class=" form-control"
                       type="text"/>
                <span class="help-block error" id="msff_n_em"><?= @$error->subject; ?></span>
            </div>
		<?php endif; ?>
		<?php if ($this->hasField('body')): ?>
            <div class="form-group" id="msff_o_gid">
                <label class="control-label" for="msff_o"><?= $label->body; ?></label>
                <textarea id="msff_o" name="ContactForm[body]" class=" form-control"
                          style="min-height:8em;"><?= @$value->body; ?></textarea>
                <span class="help-block error" id="msff_o_em"><?= @$error->body; ?></span>
            </div>
		<?php endif; ?>
        <div class=" submit">
            <input class="btn btn-primary btn-lg btn-success" type="submit" name="yt0" value="<?= $label->submit; ?>"/>
        </div>
    </form>
</div>
<script>
    (function () {
        var css = ".my-email {position:absolute;left: -9999px}",
        head = document.head || document.getElementsByTagName('head')[0],
            style = document.createElement('style');

        style.setAttribute('type', 'text/css')
        if (style.styleSheet) {
            style.styleSheet.cssText = css;
        } else {
            style.appendChild(document.createTextNode(css));
        }

        head.appendChild(style);
        var elem = document.getElementById('msff_k_gid');
        console.log(elem);
        elem.className = 'my-email';
    })();
</script>