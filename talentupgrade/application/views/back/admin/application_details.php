<?php
$application_details = $this->user_model->get_applications($param2, 'application')->row_array();
$applicant_details = $this->user_model->get_all_user($application_details['user_id'])->row_array();
?>
<div class="text-center mb-2">
    <img class="mr-2 rounded-circle" src="<?php echo $this->user_model->get_user_image_url($applicant_details['id']); ?>" alt="" height="80">
</div>

<div class="table-responsive-sm">
    <table class="table table-bordered table-centered mb-0">
        <tbody>
            <tr class="text-center">
                <td><strong><?php echo translate('applicant'); ?></strong></td>
                <td><?php echo $applicant_details['first_name'].' '.$applicant_details['last_name']; ?></td>
            </tr>
            <tr class="text-center">
                <td><strong><?php echo translate('email'); ?></strong></td>
                <td><?php echo $applicant_details['email']; ?></td>
            </tr>
            <tr class="text-center">
                <td><strong><?php echo translate('phone_number'); ?></strong></td>
                <td><?php echo $application_details['phone']; ?></td>
            </tr>
            <tr class="text-center">
                <td><strong><?php echo translate('address'); ?></strong></td>
                <td><?php echo $application_details['address']; ?></td>
            </tr>
            <tr class="text-center">
                <td><strong><?php echo translate('message'); ?></strong></td>
                <td><?php echo $application_details['message']; ?></td>
            </tr>
            <tr class="text-center">
                <td><strong><?php echo translate('status'); ?></strong></td>
                <td><?php if ($application_details['status']): ?><span class="badge badge-success"><?php echo translate('approved'); ?></span> <?php else: ?><span class="badge badge-danger"><?php echo translate('pending'); ?></span><?php endif; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
