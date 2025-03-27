<?= $this->extend('user/auth/layout/main-layout'); ?>

<?= $this->section('content'); ?>

<div class="d-table-cell align-middle">

    <div class="text-center mt-4 mb-4">
        <h1 class="h2">
            <?= getSetting('site_title'); ?>
        </h1>
        <p class="fs-6">
            Register your account
        </p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="m-sm-3">

                <?= form_open('', 'id="form"'); ?>

                <div class="mb-4">
                    <label class="form-label">Name</label>
                    <?= form_input([
                        'class' => 'form-control required',
                        'name' => 'name',
                    ]); ?>

                    <div class="invalid-feedback" id="name-error"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <?= form_input([
                        'class' => 'form-control required',
                        'name' => 'email',
                        'type' => 'email',
                    ]); ?>

                    <div class="invalid-feedback" id="email-error"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Phone</label>
                    <?= form_input([
                        'class' => 'form-control required',
                        'name' => 'phone',
                    ]); ?>

                    <div class="invalid-feedback" id="phone-error"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Address</label>
                    <?= form_textarea([
                        'class' => 'form-control required',
                        'name' => 'address',
                        'rows' => '3',
                    ]); ?>

                    <div class="invalid-feedback" id="address-error"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <?= form_input([
                        'class' => 'form-control required',
                        'name' => 'password',
                        'type' => 'password',
                    ]); ?>

                    <div class="invalid-feedback" id="password-error"></div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class='btn py-2 btn-primary'>Register</button>
                </div>

                <?= form_close(); ?>
            </div>

            <p class="text-center">Already have an account? <a href="<?= route_to('route.user.login'); ?>">Login Now</a></p>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    $('#form').submit(function(e) {

        $.ajax({
            type: "POST",
            url: "<?= route_to('route.user.register.validate'); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: () => {

                $(this).find('.invalid-feedback').text('');
                $(this).find('.form-control').removeClass('is-invalid');
                $(this).find('button[type="submit"]').html("<i class='fas fa-spinner fa-spin me-1'></i> Please wait");
                $(this).find('button[type="submit"]').attr('disabled', 'true');
            },
            success: (result) => {
                $(this).find('button[type="submit"]').html('Register');
                $(this).find('button[type="submit"]').removeAttr('disabled');
                $(this).trigger('reset');

                if (result.response['msg']) {

                    window.notyf.open({
                        type: 'success',
                        message: result.response['msg'],
                        duration: 2000,
                    });

                    setTimeout(() => location.href = result.response['redirect'], 2000);
                } else {

                    location.href = result.response['redirect'];
                }
            },
            error: (response) => {

                $(this).find('button[type="submit"]').html('Register');
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