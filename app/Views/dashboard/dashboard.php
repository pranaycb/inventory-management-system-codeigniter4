<?= $this->extend('dashboard/layout/main-layout.php'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid p-0">

    <div class="row mb-4">
        <div class="col-12">
            <h3>Dashboard</h3>
        </div>
    </div>

    <!-- Analytics -->
    <div class="row">
        <div class="col-md-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Categories</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat stat-sm">
                                <i class="ri-list-indefinite"></i>
                            </div>
                        </div>
                    </div>
                    <span class="h1 d-inline-block mt-1 mb-3">
                        <?= $count['categories']; ?>
                    </span>
                    <div class="mb-0">
                        <a href="<?= route_to('route.categories'); ?>" class="text-muted">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Brands</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat stat-sm">
                                <i class="ri-apps-line"></i>
                            </div>
                        </div>
                    </div>
                    <span class="h1 d-inline-block mt-1 mb-3">
                        <?= $count['brands']; ?>
                    </span>
                    <div class="mb-0">
                        <a href="<?= route_to('route.brands'); ?>" class="text-muted">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Products</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat stat-sm">
                                <i class="ri-pie-chart-2-line"></i>
                            </div>
                        </div>
                    </div>
                    <span class="h1 d-inline-block mt-1 mb-3">
                        <?= $count['products']; ?>
                    </span>
                    <div class="mb-0">
                        <a href="<?= route_to('route.products'); ?>" class="text-muted">View All</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Sales</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat stat-sm">
                                <i class="ri-money-dollar-box-line"></i>
                            </div>
                        </div>
                    </div>
                    <span class="h1 d-inline-block mt-1 mb-3">
                        <?= number_format($count['sales'], 2, '.', ','); ?> ৳
                    </span>
                    <div class="mb-0">
                        <a href="<?= route_to('route.employees'); ?>" class="text-muted">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row">
        <div class="col-lg-12 col-xl-6">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title mb-0">Recently Added 5 Products</h5>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-striped my-0 datatable">
                        <thead class="text-nowrap">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Qty</th>
                                <th>Sold</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)) :

                                foreach ($products as $index => $product) : ?>

                                    <tr>
                                        <td>
                                            <?= ++$index; ?>
                                        </td>
                                        <td>
                                            <img src="<?= base_url('assets/img/products/' . $product->image); ?>" class="img-thumbnail" style="max-width: 70px;" />
                                        </td>
                                        <td>
                                            <?= $product->name; ?>
                                        </td>
                                        <td>
                                            <?= $product->category ?? '--'; ?>
                                        </td>
                                        <td>
                                            <?= $product->brand ?? '--'; ?>
                                        </td>
                                        <td>
                                            <?= $product->qty; ?>
                                        </td>
                                        <td>
                                            <?= $product->sold ?? 0; ?>
                                        </td>
                                        <td>
                                            <?php if ($product->qty > $product->sold) :

                                                echo '<span class="badge bg-success font-size-12">In Stock</span>';

                                            else :

                                                echo '<span class="badge bg-danger font-size-12">Out of Stock</span>';
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y h:i A', strtotime($product->created)); ?>
                                        </td>
                                        <td>
                                            <?= date('d.m.Y h:i A', strtotime($product->updated)); ?>
                                        </td>
                                    </tr>

                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xl-6">
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