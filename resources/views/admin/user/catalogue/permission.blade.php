@include('admin.dashboard.component.breadcrumb', ['title' => $config['seo']['permission']['title']])

<form action="{{ route('user.catalogue.updatePermission') }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cấp quyền</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-sm table-striped table-bordered">
                            <tr>
                                <th></th>
                                @foreach ($userCatalogues as 
                                $userCatalogue)
                                <th class="text-center">{{ $userCatalogue->name }}</th>
                                @endforeach
                            </tr>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td><a href="" class="uk-flex uk-flex-middle uk-flex-space-between">{{ $permission->name }}</a></td>
                                @foreach ($userCatalogues as $userCatalogue)
                                <td>
                                    <input {{ (collect($userCatalogue->permissions)->contains('id', $permission->id) ? 'checked' : '') }} 
                                    type="checkbox" 
                                    name="permission[{{ $userCatalogue->id }}][]" 
                                    value="{{ $permission->id }}" 
                                    class="form-control">
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        
        <div class="text-right mb-15">
            <button type="submit" class="btn btn-primary" name="send" value="send">Lưu thay đổi</button>
        </div>
    </div>
</form>
