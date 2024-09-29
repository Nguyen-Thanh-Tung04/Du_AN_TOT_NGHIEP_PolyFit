@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['table'] }}</h5>
                @include('admin.dashboard.component.toolbox', ['model' => 'Product'])

            </div>
            <div class="ibox-content">
                @include('admin.product.product.component.filter')
                @include('admin.product.product.component.table')
            </div>
        </div>
    </div>
</div>
