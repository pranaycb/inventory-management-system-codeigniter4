<?= $this->extend('user/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3>My Account</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update Profile</h5>
                </div>
                <div class="card-body">
                    <?= form_open(route_to('route.users.account.profile.update'), ['class' => 'form']); ?>

                    <div class="mb-4">
                        <label class="form-label">Name</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'name',
                            'value' => $details->name,
                        ]); ?>

                        <div class="invalid-feedback" id="name-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'email',
                            'type' => 'email',
                            'value' => $details->email,
                        ]); ?>

                        <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Phone</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'phone',
                            'value' => $details->phone,
                        ]); ?>

                        <div class="invalid-feedback" id="phone-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <?= form_textarea([
                            'class' => 'form-control required',
                            'name' => 'address',
                            'rows' => '3',
                            'value' => $details->address,
                        ]); ?>

                        <div class="invalid-feedback" id="address-error"></div>
                    </div>

                    <div>
                        <?= form_button([
                            'type' => 'submit',
                            'content' => 'Update',
                            'class' => 'btn btn-primary',
                        ]); ?>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update Password</h5>
                </div>
                <div class="card-body">

                    <?= form_open(route_to('route.users.account.password.update'), ['class' => 'form']); ?>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'password',
                            'type' => 'password',
                        ]); ?>

                        <div class="invalid-feedback" id="password-error"></div>
                    </div>

                    <div>
                        <?= form_button([
                            'type' => 'submit',
                            'content' => 'Update',
                            'class' => 'btn btn-primary',
                        ]); ?>
                    </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    $('.form').submit(function(e) {

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: () => {

                $(this).find('.invalid-feedback').text('');
                $(this).find('.required').removeClass('is-invalid');
                $(this).find('button[type="submit"]').html("<i class='fas fa-spinner fa-spin me-1'></i> Please wait");
                $(this).find('button[type="submit"]').attr('disabled', 'true');
            },
            success: (result) => {
                $(this).find('button[type="submit"]').html('Update');
                $(this).find('button[type="submit"]').removeAttr('disabled');

                window.notyf.open({
                    type: 'success',
                    message: result.response,
                    duration: 2000,
                });

                setTimeout(() => location.reload(), 2000);
            },
            error: (response) => {

                $(this).find('button[type="submit"]').html('Update');
                $(this).find('button[type="submit"]').removeAttr('disabled');

                const result = JSON.parse(response.responseText);

                if (result.status === 'validation-error') {

                    //show validation error message
                    $.each(result.response, (prefix, val) => {

                        $('#' + prefix + '-error').parent().find('.required').addClass('is-invalid');

                        $(this).find('#' + prefix + '-error').text(val);
                    });

                } else {

                    window.notyf.open({
                        type: 'danger',
                        message: result.response,
                        duration: 3500,
                    });
                }
            }
        });

        e.preventDefault();
    });
</script>
<?= $this->endSection('script'); ?>