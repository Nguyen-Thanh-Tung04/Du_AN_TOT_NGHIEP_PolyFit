<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead>
        <tr>
            <th class="text-center">
                STT
            </th>
            <th>Tên chức vụ</th>
            <th class="text-center">Số người</th>
            <th class="text-center">Mô tả</th>
            <th class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
        </thead>
        <tbody>
            @if (isset($userCatalogues) && is_object($userCatalogues))
                @foreach($userCatalogues as $key => $userCatalogue)
                @if ($userCatalogue->id == 3)
                    @continue
                @endif
                <tr>
                    <td class="text-center">
                        {{ $key + 1 }}
                    </td>
                    <td>{{ $userCatalogue->name }}</td>
                    <td class="text-center">
                        {{ $userCatalogue->users_count }} người
                    </td>
                    <td>{{ $userCatalogue->description }}</td>
                    <td class="text-center js-switch-{{ $userCatalogue->id }}">
                        <input type="checkbox" value="{{ $userCatalogue->publish }}"
                        class="js-switch status " 
                        {{ ($userCatalogue->id == 1) ? 'disabled' : '' }}
                        data-field="publish"
                        data-model="UserCatalogue"
                        data-modelId="{{ $userCatalogue->id }}"
                        {{ ($userCatalogue->publish == 1) ? 'checked' : '' }}/>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('user.catalogue.edit', $userCatalogue->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>

                        {{-- <a href="{{ route('user.catalogue.delete', $userCatalogue->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> --}}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {{ $userCatalogues->links('pagination::bootstrap-5') }}

</div>
