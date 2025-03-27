<?= $this->extend('dashboard/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Settings</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4 text-uppercase fw-bolder">App Settings</h4>

                    <?= form_open(route_to('route.settings.app.update'), "class='form'"); ?>

                    <div class="mb-4">
                        <label class="form-label">Application Title</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'site_title',
                            'value' => getSetting('site_title')
                        ]); ?>

                        <div class="invalid-feedback" id="site_title-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Application Subtitle</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'site_subtitle',
                            'value' => getSetting('site_subtitle')
                        ]); ?>

                        <div class="invalid-feedback" id="site_subtitle-error"></div>
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
                <div class="card-body p-4">

                    <h4 class="card-title mb-4 text-uppercase fw-bolder">Login Settings</h4>

                    <?= form_open(route_to('route.settings.auth.update'), "class='form password-form'"); ?>

                    <div class="mb-4">
                        <label class="form-label">Login Email Id</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'type'    => 'email',
                            'name'    => 'email',
                            'value'    => $admin->email,
                        ]); ?>

                        <div class="invalid-feedback" id="email-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Current Password</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'type'    => 'password',
                            'name'    => 'current_password',
                        ]); ?>

                        <small class="d-block text-info my-2">Leave this field blank if you don't want to change</small>

                        <div class="invalid-feedback" id="current_password-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">New Password</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'type'    => 'password',
                            'name'    => 'new_password',
                        ]); ?>

                        <small class="d-block text-info my-2">Leave this field blank if you don't want to change</small>

                        <div class="invalid-feedback" id="new_password-error"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Rewrite New Password</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'type'    => 'password',
                            'name'    => 'retyped_new_password',
                        ]); ?>

                        <small class="d-block text-info my-2">Leave this field blank if you don't want to change</small>

                        <div class="invalid-feedback" id="retyped_new_password-error"></div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-check">
                                <?= form_checkbox([
                                    'class' => 'form-check-input',
                                    'id' => 'showpass-check',
                                    'name' => 'showpass'
                                ]); ?>
                                <label class="form-check-label" for="showpass-check">
                                    Show password
                                </label>
                            </div>
                        </div>
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
    $('input[name="showpass"]').change(function() {

        $(this).prop("checked") ?
            $('.password-form input[type="password"]').prop("type", "text") :
            $('.password-form input[type="text"]').prop("type", "password");
    });

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
                $(this).find('button[type="submit"]').html("Update");
                $(this).find('button[type="submit"]').removeAttr('disabled');

                window.notyf.open({
                    type: 'success',
                    message: result.response,
                    duration: 2000,
                });

                setTimeout(() => location.reload(), 2000);
            },
            error: (response) => {

                $(this).find('button[type="submit"]').html("Update");
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