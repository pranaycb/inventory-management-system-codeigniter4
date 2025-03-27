<?= $this->extend('dashboard/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3>New Sale</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= form_open('', ['id' => 'form']); ?>

                    <div class="form-group mb-4">
                        <label class="form-label">Sold To</label>

                        <?php $data = [];

                        if (empty($users)) :

                            $data[''] = 'No user found';

                        else :

                            $data[''] = '--Select--';

                            foreach ($users as $user) :

                                $data[$user->id] = $user->name;

                            endforeach;
                        endif;

                        echo form_dropdown('user', $data, '', 'class="form-control select2 required"'); ?>

                        <div id="user-error" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Product</label>

                        <?php $data = [];

                        if (empty($products)) :

                            $data[''] = 'No brand found';

                        else :

                            $data[''] = '--Select--';

                            foreach ($products as $product) :

                                $data[$product->id] = $product->name;

                            endforeach;
                        endif;

                        echo form_dropdown('product', $data, '', 'class="form-control select2 required"'); ?>

                        <div id="product-error" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Sales Date</label>
                        <?= form_input([
                            'class' => 'form-control required datetime',
                            'name' => 'sales_date',
                            'placeholder' => 'DD.MM.YYYY',
                            'data-mask' => '00.00.0000',
                            'value' => '',
                        ]); ?>

                        <div class="invalid-feedback" id="sales_date-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Product Quantity</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'qty',
                        ]); ?>

                        <div class="invalid-feedback" id="qty-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Price (Per Item)</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'price',
                        ]); ?>

                        <div class="invalid-feedback" id="price-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Tax Rate (%)</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'tax_rate',
                        ]); ?>

                        <div class="invalid-feedback" id="tax_rate-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Sold Type</label>

                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <?= form_radio([
                                    "name" => "sold_as",
                                    "id" => "sold_as_kg",
                                    "class" => "form-check-input required",
                                    'value' => 'kg',
                                ]); ?>
                                <label class="form-check-label" for="sold_as_kg">Kilogram</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <?= form_radio([
                                    "name" => "sold_as",
                                    "id" => "sold_as_piece",
                                    "class" => "form-check-input required",
                                    'value' => 'piece'
                                ]); ?>
                                <label class="form-check-label" for="sold_as_piece">Piece</label>
                            </div>

                            <div id="sold_as-error" class="d-block invalid-feedback"></div>
                        </div>

                    </div>

                    <div>
                        <?= form_button([
                            'type' => 'submit',
                            'content' => 'Create Sale',
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
    /**
     * Init select2
     */
    $(".select2").each(function() {
        $(this)
            .wrap("<div class=\"position-relative required\"></div>")
            .select2({
                placeholder: "--Select--",
                dropdownParent: $(this).parent()
            });
    });

    /**
     * Init datetime picker
     */
    $(".datetime").daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            autoUpdateInput: false,
            autoApply: true,
            locale: {
                format: "DD.MM.YYYY"
            }
        })
        .on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY'));
        })
        .on('cancel.daterangepicker', function(ev, picker) {
            $(this).val("");
        });

    $('#form').submit(function(e) {

        $.ajax({
            type: "POST",
            url: "<?= route_to('route.sales.create'); ?>",
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
                $(this).find('button[type="submit"]').html('Create Sale');
                $(this).find('button[type="submit"]').removeAttr('disabled');
                $(this).trigger('reset');

                window.notyf.open({
                    type: 'success',
                    message: result.response,
                    duration: 2000,
                });

                setTimeout(() => location.href = '<?= route_to("route.sales"); ?>', 2000);
            },
            error: (response) => {

                $(this).find('button[type="submit"]').html('Create Sale');
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