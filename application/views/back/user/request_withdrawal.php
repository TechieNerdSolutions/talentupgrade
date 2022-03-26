<?php
$total_pending_amount  = $this->crud_model->get_total_pending_amount($this->session->userdata('user_id'));
$requested_withdrawals = $this->crud_model->get_requested_withdrawals($this->session->userdata('user_id'));
?>
<?php if ($requested_withdrawals->num_rows() > 0): ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading"><?php echo translate('hello_dear'); ?> !!!</h4>
        <p><strong><?php echo translate('you_already_requested_a_withdrawal'); ?></strong></p>
        <p><?php echo translate('if_you_want_to_make_another'); ?>, <?php echo translate('you_have_to_delete_the_requested_one_first'); ?></p>
    </div>
	
<?php elseif($total_pending_amount == 0): ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading"><?php echo translate('hello_dear'); ?>!!!</h4>
        <p><strong><?php echo translate('nothing_to_withdraw_at_the_moment'); ?></strong></p>
    </div>
<?php else: ?>

    <form class="required-form" action="<?php echo site_url('user/withdrawal/request'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $this->session->userdata('user_id'); ?>">
        <div class="form-group">
            <label for="withdrawal_amount"><?php echo translate('withdrawal_amount'); ?></label>
            <input type="number" class="form-control" name="withdrawal_amount" id="withdrawal_amount" aria-describedby="withdrawal_amount-help" placeholder="<?php echo translate('withdrawal_amount_has_to_be_less_than_or_equal_to').' '.$total_pending_amount; ?>" min="0" max="<?php echo $total_pending_amount; ?>" required>
            <small id="withdrawal_amount-help" class="form-text text-muted"><?php echo translate('withdrawal_amount_has_to_be_less_than_or_equal_to').' '.$total_pending_amount; ?></small>
        </div>
        <button type="button" class="btn btn-primary text-center" onclick="checkRequiredFields()"><?php echo translate('request'); ?></button>
    </form>
<?php endif; ?>
