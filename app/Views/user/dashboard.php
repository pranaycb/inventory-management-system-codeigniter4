<?= $this->extend('user/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-0">

    <div class="row mb-4">
        <div class="col-12">
            <h3>Dashboard</h3>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title mb-0">Recent 5 Sales Record</h5>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-striped my-0 datatable">
                        <thead class="text-nowrap">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>OrderId</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Tax(%)</th>
                                <th>Total</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sales)) :

                                foreach ($sales as $index => $sale) : ?>

                                    <tr>
                                        <td>
                                            <?= ++$index; ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y', strtotime($sale->sales_date)); ?>
                                        </td>
                                        <td>
                                            <?= $sale->order_id; ?>
                                        </td>
                                        <td>
                                            <?= $sale->product ?? '--'; ?>
                                        </td>
                                        <td>
                                            <?= $sale->price; ?>
                                        </td>
                                        <td>
                                            <?= $sale->qty . ' ' . ucwords($sale->sold_as); ?>
                                        </td>
                                        <td>
                                            <?= $sale->tax_rate; ?>
                                        </td>
                                        <td>
                                            <?= $sale->total; ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y h:i A', strtotime($sale->created)); ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y h:i A', strtotime($sale->updated)); ?>
                                        </td>
                                    </tr>

                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header mb-0">
                <h5 class="card-title mb-0">This Month Sales Chart</h5>
            </div>
            <div class="card-body">
                <div class="chart w-100">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    $(document).ready(function() {

        $(".datatable").DataTable({
            responsive: true,
            order: [],
            sort: false,
            searching: false,
            paging: false,
            bInfo: false,
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Area chart
        var options = {
            chart: {
                height: 350,
                type: "area",
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#546E7A'],
            series: [{
                name: "Sale",
                data: <?= $chart['ydata']; ?>
            }],
            xaxis: {
                categories: <?= $chart['xdata']; ?>,
            },
        }
        new ApexCharts(
            document.querySelector("#chart"),
            options
        ).render();
    });
</script>

<?= $this->endSection('script'); ?>