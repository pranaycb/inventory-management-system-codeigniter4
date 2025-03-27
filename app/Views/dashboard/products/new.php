<?= $this->extend('dashboard/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h3>New Product</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= form_open('', ['id' => 'form']); ?>

                    <div class="mb-4">
                        <label class="form-label">Product Name</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'name',
                        ]); ?>

                        <div class="invalid-feedback" id="name-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Product Image</label>

                        <?= form_input([
                            "name" => "image",
                            "class" => "form-control required",
                            "type" => "file",
                        ]); ?>

                        <div id="image-error" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Category</label>

                        <?php $data = [];

                        if (empty($categories)) :

                            $data[''] = 'No category found';

                        else :

                            $data[''] = '--Select--';

                            foreach ($categories as $category) :

                                $data[$category->id] = $category->name;

                            endforeach;
                        endif;

                        echo form_dropdown('category', $data, '', 'class="form-control select2 required"'); ?>

                        <div id="category-error" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Brand</label>

                        <?php $data = [];

                        if (empty($brands)) :

                            $data[''] = 'No brand found';

                        else :

                            $data[''] = '--Select--';

                            foreach ($brands as $brand) :

                                $data[$brand->id] = $brand->name;

                            endforeach;
                        endif;

                        echo form_dropdown('brand', $data, '', 'class="form-control select2 required"'); ?>

                        <div id="brand-error" class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Attribute</label>

                        <select name="attribute[]" data-placeholder="--Select--" class="form-control select2 required" multiple>

                            <?php if (!empty($attributes)) :

                                foreach ($attributes as $attribute) : ?>

                                    <option value=""></option>

                                    <optgroup label="<?= $attribute->name; ?>">

                                        <?php foreach (explode(',', $attribute->values) as $value) : ?>

                                            <option class="ps-2" value="<?= $value; ?>"><?= $value; ?></option>

                                        <?php endforeach; ?>
                                    </optgroup>

                            <?php endforeach;

                            endif; ?>
                        </select>

                        <div id="attribute-error" class="invalid-feedback"></div>
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
                        <label class="form-label">Unit Price</label>
                        <?= form_input([
                            'class' => 'form-control required',
                            'name' => 'price',
                        ]); ?>

                        <div class="invalid-feedback" id="price-error"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Product Description</label>

                        <?= form_input([
                            "type" => "hidden",
                            "name" => "description",
                            "id" => "description",
                        ]); ?>

                        <div class="required">

                            <div id="quill-toolbar">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-direction" value="rtl"></button>
                                    <select class="ql-align"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>

                            <div id="quill-editor"></div>
                        </div>

                        <div id="description-error" class="invalid-feedback"></div>
                    </div>

                    <div>
                        <?= form_button([
                            'type' => 'submit',
                            'content' => 'Create Product',
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
    $(document).ready(function() {
        const editor = new Quill("#quill-editor", {
            modules: {
                toolbar: "#quill-toolbar"
            },
            placeholder: "Type something",
            theme: "snow"
        });

        editor.on('text-change', (delta, source) => $('#description').val(editor.root.innerHTML));

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
    });

    $('#form').submit(function(e) {

        $.ajax({
            type: "POST",
            url: "<?= route_to('route.products.create'); ?>",
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
                $(this).find('button[type="submit"]').html('Create Product');
                $(this).find('button[type="submit"]').removeAttr('disabled');
                $(this).trigger('reset');

                window.notyf.open({
                    type: 'success',
                    message: result.response,
                    duration: 2000,
                });

                setTimeout(() => location.href = '<?= route_to("route.products"); ?>', 2000);
            },
            error: (response) => {

                $(this).find('button[type="submit"]').html('Create Product');
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