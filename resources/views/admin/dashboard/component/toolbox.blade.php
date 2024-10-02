<div class="ibox-tools">
    <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a href="#" 
            class="changeStatusAll" 
            data-field="{{ $field }}"
            data-model="{{ $model }}"
            data-value="1"
            >Active toàn bộ</a>
        </li>
        <li>
            <a href="#" 
            class="changeStatusAll" 
            data-field="{{ $field }}"
            data-model="{{ $model }}"
            data-value="2"
            >UnActive toàn bộ</a>
        </li>
    </ul>
    <a class="close-link">
        <i class="fa fa-times"></i>
    </a>
</div>
