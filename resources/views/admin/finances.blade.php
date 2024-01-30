@extends('layout.admin')
@section('body-class', 'not-front not-logged-in lightbox-processed')
@section('title', 'Finanzas')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
@endsection
@section('content')
    <div class="container full">
        @if(Auth::user()->rol->name == 'admin')
        <div class="row block-form collapse">
            <div class="large-12 columns">
                <div class="menu">
                    <h4>Plans</h4>
                </div>
            </div>
        </div>
        <div class="row collapse">
            <div class="large-12 columns">
                <table class="regular" id="admin_plans">
                    <thead>
                        <tr>
                            <td>Id</td>
                            <td>Days</td>
                            <td>Price</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr id="p-{{$plan->id}}" data-id="{{$plan->id}}">
                                <td>{{$plan->id}}</td>
                                <td class="days">{{$plan->days}}</td>
                                <td class="price">{{$plan->price}}</td>
                                <td class="controls">
                                    <a class="publish" href="#"><span><i class="fa @if($plan->active) fa-flag @else fa-flag-o @endif"></i></span></a>
                                    <a class="editp" href="#"><span><i class="fa fa-edit"></i></span></a>
                                    <a class="delete" href="#"><span><i class="fa fa-trash"></i></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                <button class="button button-primary" id="add_plan">Add</button>
            </div>
        </div>

        <div class="row block-form collapse">
            <div class="large-12 columns">
                <div class="menu">
                    <h4>Commissions</h4>
                </div>
            </div>
        </div>
        <div class="row collapse">
            <div class="large-12 columns">
                <table class="regular" id="admin_commissions">
                    <thead>
                    <tr>
                        <td>Rols</td>
                        @foreach($plans as $plan)
                            <td>{{$plan->days}} days - {{$plan->price}} CUC</td>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($rols as $rol)
                            <tr>
                                <td>{{$rol->name}}</td>
                                @foreach($plans as $plan)
                                    @if(isset($commissions[$rol->id]) && isset($commissions[$rol->id][$plan->id]))
                                        <td data-plan="{{$plan->id}}" data-rol="{{$rol->id}}" id="{{$rol->id}}-{{$plan->id}}" data-value="{{$commissions[$rol->id][$plan->id]->value}}"><input type="text" readonly="readonly" value="{{$commissions[$rol->id][$plan->id]->value}}"></td>
                                    @else
                                        <td data-plan="{{$plan->id}}" data-rol="{{$rol->id}}" id="{{$rol->id}}-{{$plan->id}}" data-value="0"><input type="text" value="0" readonly="readonly"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="text-center">Double Click to edit commission, click out to save</p>
        </div>
        @endif
        <div class="row block-form">
            <form action="{{\App\Helper::getPathFor('admin/finances/calculate')}}" method="post">
                {{csrf_field()}}
                <div class="large-12 columns">
                    <div class="menu">
                        <h2>Finances</h2>
                    </div>
                </div>
                <div class="large-5 columns ">
                    <label for="from">From Date</label>
                    <input id="from" name="from" type="date">
                </div>
                <div class="large-5 columns">
                    <label for="to">To Date</label>
                    <input id="to" name="to" type="date">
                </div>
                <div class="large-2 columns">
                    <label>&nbsp;</label>
                    <button class="button button-primary">Calcular</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
@parent
    @if(Auth::user()->rol->name == 'admin')
    <script type="text/javascript">
        var template_add_plan = '<tr><td></td><td><input type="text" id="days"></td><td><input type="text" id="price"></td><td><span id="save_plan"><i class="fa fa-save"></i></span></td></tr>';
        var template_controls_plan = '<a class="publish" href="#"><span><i class="fa fa-flag"></i></span></a> <a class="editp" href="#"><span><i class="fa fa-edit"></i></span></a> <a class="delete" href="#"><span><i class="fa fa-trash"></i></span></a>';
        var loader = '<span id="loader" style="padding: 0 10px"><img src="{{asset('images/uploading.gif')}}"></span>';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){
            var add_plan = $('#add_plan');
            var plans_table = $('#admin_plans');
            var commissions_table = $('#admin_commissions');
            add_plan.click(function(){
                if(!plans_table.hasClass('with_form')){
                    add_plan_form();
                }

            });

            $('body').on('click', '#admin_finances .note i', function(e){
                alert($(e.target).data('note'));
            });

            plans_table.on('click', '#save_plan', function (e) {
                e.preventDefault();
                var this2 = $(this);
                if(!this2.hasClass('saving')){
                    this2.after(loader).addClass('saving');
                    var days = parseInt(plans_table.find('#days').attr('disabled', 'disabled').val());
                    var price = parseInt(plans_table.find('#price').attr('disabled', 'disabled').val());
                    $.post('/admin/finances/plans/save', {price:price, days:days}, function(data){
                        if(data){
                            rebuild_plans_table(data);
                        }
                    }).fail(function(xhr){
                        alert(xhr.statusText);
                    }).complete(function(){
                        plans_table.find('input').removeAttr('disabled');
                        this2.removeClass('saving');
                        plans_table.find('#loader').remove();
                    });
                }

            });

            plans_table.on('click', 'a.publish', function(e){
                e.preventDefault();
                var this2 = $(this);
                var id = this2.parents('tr').data('id');
                $.post('/admin/finances/plans/publish', {id: id}, function(data){
                    if(data){
                        if(data.active == 1)
                            plans_table.find('tr#p-'+data.id).find('a.publish').find('i').removeClass('fa-flag-o').addClass('fa-flag');
                        else
                            plans_table.find('tr#p-'+data.id).find('a.publish').find('i').removeClass('fa-flag').addClass('fa-flag-o');
                    }
                }).fail(function(xhr){
                    alert(xhr.statusText)
                });
            });

            plans_table.on('click', 'a.delete', function(e){
                e.preventDefault();
                if(!confirm('Are you sure?'))
                    return;
                var this2 = $(this);
                var id = this2.parents('tr').data('id');
                $.post('/admin/finances/plans/delete', {id: id}, function(data){
                    if(data)
                        rebuild_plans_table(data);
                }).fail(function(xhr) {
                    alert(xhr.statusText)
                });
            });

            plans_table.on('click', 'a.editp', function (e) {
                e.preventDefault();
                var this2 = $(this);
                var id = this2.parents('tr').data('id');
                var row = $('tr#p-'+id);
                if(!row.hasClass('editing')){
                    var days_e = row.find('td.days');
                    var days = days_e.text();
                    var price_e = row.find('td.price');
                    var price = price_e.text();
                    days_e.empty().append('<input name="days" value="'+days+'">');
                    price_e.empty().append('<input name="price" value="'+price+'">');
                    row.find('td.controls').append(' <a href="#" class="update"><span><i class="fa fa-save"></i></span></a>');
                    row.addClass('editing');
                }
            });

            plans_table.on('click', 'a.update', function(e){
                e.preventDefault();
                var this2 = $(this);
                var id = this2.parents('tr').data('id');
                var row = $('tr#p-'+id);
                var days = row.find('td.days').find('input').val();
                var price = row.find('td.price').find('input').val();
                this2.after(loader);
                row.find('input').attr('disabled', 'disabled');
                $.post('/admin/finances/plans/save', {id:id, price:price, days:days}, function(data){
                    rebuild_plans_table(data);
                }).fail(function(xhr){
                    alert(xhr.statusText);
                });

            });

            commissions_table.on('dblclick', 'input', function () {
                $(this).removeAttr('readonly');
            });

            commissions_table.on('blur', 'input', function () {
                if(!$(this).attr('readonly')){
                    var this2 = $(this);
                    var plan = this2.parents('td').data('plan');
                    var rol = this2.parents('td').data('rol');
                    var value = this2.val();
                    $.post('/admin/finances/commissions/save', {plan:plan, rol:rol, value:value}, function(data){
                        this2.val(data.value);
                    }).fail(function(xhr){
                        alert(xhr.statusText);
                        var prev = this2.parents('td').data('value');
                        this2.val(prev);
                    }).complete(function(){
                        this2.attr('readonly', 'readonly');
                    });
                }
            });

            function add_plan_form() {
                plans_table.find('tbody').append(template_add_plan);
                plans_table.addClass('with_form');
            }

            function rebuild_plans_table(data){
                plans_table.removeClass('with_form');
                var tbody = plans_table.find('tbody').empty();
                $.each(data, function (index, value) {
                    tbody.append('<tr id="p-'+value.id+'"><td>'+value.id+'</td><td class="days">'+value.days+'</td><td class="price">'+value.price+'</td><td class="controls"></td></tr>');
                    tbody.find('tr#p-'+value.id).find('td.controls').append(template_controls_plan);
                    tbody.find('tr#p-'+value.id).data('id', value.id);
                })
            }
        });
    </script>
    @endif
@endsection