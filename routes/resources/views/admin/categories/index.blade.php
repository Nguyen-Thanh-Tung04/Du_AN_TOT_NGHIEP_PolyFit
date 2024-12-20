@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row mt-20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['table'] }}</h5>
                @include('admin.dashboard.component.toolbox', ['model' => 'category'])

            </div>
            <div class="ibox-content">
                @include('admin.categories.component.filter')
                @include('admin.categories.component.table')
            </div>
        </div>
    </div>
</div>