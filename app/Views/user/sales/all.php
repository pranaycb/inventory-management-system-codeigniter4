<?= $this->extend('user/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h3>My Orders</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatables-reponsive" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th data-data="select" data-orderable="false">
                                    <input type="checkbox" class="form-check-input" id="checkAll">
                                </th>
                                <th data-data="serial">#</th>
                                <th data-data="sales_date">Date</th>
                                <th data-data="order_id">OrderId</th>
                                <th data-data="product">Product</th>
                                <th data-data="price">Price</th>
                                <th data-data="qty">Qty</th>
                                <th data-data="tax_rate">Tax(%)</th>
                                <th data-data="total">Total</th>
                                <th data-data="created">Created</th>
                                <th data-data="updated">Updated</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    $(document).ready(function() {

        const table = $("#datatables-reponsive").DataTable({
            responsive: true,
            ajax: {
                url: '<?= route_to("route.users.sales.fetch"); ?>',
                type: 'post',
                beforeSend: function(req) {
                    req.setRequestHeader('<?= csrf_header() ?>', '<?= csrf_hash() ?>', );
                },
            },
            order: [],
        });

        $('#checkAll').on('click', function() {

            let rows = table.rows({
                'search': 'applied'
            }).nodes();

            $('.input-check-selected', rows).prop('checked', this.checked);

            $('.input-check-selected').trigger('change');
        });

        $(document).on("change", ".input-check-selected", function() {

            const totalRecord = $(".input-check-selected").length;

            const selectedRecord = $(".input-check-selected:checked").length;

            if (selectedRecord > 0) {

                $('.delete-btn').removeClass('d-none');
            } else {
                $('.delete-btn').addClass('d-none');
            }

            if (!this.checked) {
                $('#checkAll').prop('checked', false);
            } else if (selectedRecord === totalRecord) {
                $('#checkAll').prop('checked', true);
            }
        });

        $(this).on('click', '.delete-btn', function() {

            swal({
                title: "Confirmation",
                text: "Are you sure wanted to delete the selected record?",
                dangerMode: true,
                icon: 'warning',
                buttons: [
                    "No",
                    {
                        text: "Yes",
                        closeModal: false,
                    }
                ],
            }).then((willDelete) => {

                if (willDelete) {

                    const ids = [];

                    table.$('.input-check-selected:checked').each(function() {
                        ids.push($(this).val());
                    });

                    $.ajax({
                        url: '<?= route_to("route.sales.delete"); ?>',
                        type: 'DELETE',
                        data: {
                            ids
                        },
                        headers: {
                            '<?= csrf_header() ?>': '<?= csrf_hash() ?>',
                        },
                        success: function(result) {

                            table.rows(table.$('.input-check-selected:checked').closest('tr')).remove().draw();

                            $('#checkAll').prop('checked', false);

                            window.notyf.open({
                                type: 'success',
                                message: result.response,
                                duration: 2000,
                            });

                            swal.close();
                        },

                        error: function(response) {

                            const result = jQuery.parseJSON(response.responseText);

                            window.notyf.open({
                                type: 'danger',
                                message: result.response,
                                duration: 2000,
                            });

                            swal.close();
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection('script'); ?>