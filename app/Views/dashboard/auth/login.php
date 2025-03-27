<?= $this->extend('dashboard/auth/layout/main-layout'); ?>

<?= $this->section('content'); ?>

<div class="d-table-cell align-middle">

    <div class="text-center mt-4 mb-4">
        <h1 class="h2">
            <?= getSetting('site_title'); ?>
        </h1>
        <p class="fs-6">
            Login to continue to Admin Dashboard
        </p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="m-sm-3">

                <?= form_open('', 'id="form"'); ?>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control required" type="email" name="email" placeholder="Enter your email" />
                    <div class="invalid-feedback" id="email-error"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input class="form-control required" type="password" name="password" placeholder="Enter your password" />
                    <div class="invalid-feedback" id="password-error"></div>
                </div>

                <div>
                    <div class="form-check align-items-center">
                        <input id="remember" type="checkbox" class="form-check-input" value="yes" name="remember" checked>
                        <label class="form-check-label text-small" for="remember">Remember me</label>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class='btn py-2 btn-primary'>Login</button>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    $('#form').submit(function(e) {

        $.ajax({
            type: "POST",
            url: "<?= route_to('route.admin.login.validate'); ?>",
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
                $(this).find('button[type="submit"]').html('Log In');
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

                $(this).find('button[type="submit"]').html('Log In');
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