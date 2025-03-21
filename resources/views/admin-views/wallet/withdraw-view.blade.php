@extends('layouts.admin.app')
@section('title',translate('Withdraw information View'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
    @php
        $vendor = $wr?->vendor->stores[0]?->module_type == 'rental' ? 'Provider' : 'store';
    @endphp
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title mr-3 mb-md-0">
            <span class="page-header-icon">
                <img src="{{asset('assets/admin/img/withdraw.png')}}" class="w--26" alt="">
            </span>
            <span>
                {{translate($vendor.'_withdraw_information')}}
            </span>
        </h1>
    </div>
    <!-- Page Heading -->

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="d-flex __gap-5px text-capitalize">
                                <span>{{translate('messages.amount')}}</span>
                                <span>:</span>
                                <span>{{\App\CentralLogics\Helpers::format_currency($wr->amount)}}</span>
                            </h5>
                            <h5 class="d-flex __gap-5px">
                                <span>{{ translate('messages.request_time') }}</span><span>:</span><span>{{$wr->created_at}}</span>
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="d-flex __gap-5px">
                                <span>{{ translate('messages.note') }}</span><span>:</span><span> {{translate($wr->transaction_note)}}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            @if ($wr->approved== 0)
                                <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#exampleModal">{{translate('messages.proceed')}}
                                    <i class="tio-arrow-forward"></i>
                                </button>
                            @else
                                <div class="text-center float-right text-capitalize">
                                    @if($wr->approved==1)
                                        <label class="badge badge-success p-2 rounded-bottom">
                                            {{translate('messages.approved')}}
                                        </label>
                                    @else
                                        <label class="badge badge-danger p-2 rounded-bottom">
                                            {{translate('messages.denied')}}
                                        </label>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>




        @if ($wr->method)
        <div class="col-md-4">
            <div class="card min-height-260px">
                <div class="card-header">
                    <h3 class="h3 mb-0 text-capitalize">{{ translate($wr->method->method_name) }} </h3>
                    <i class="tio tio-dollar-outlined"></i>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                    @forelse(json_decode($wr->withdrawal_method_fields, true) as $key=> $item)
                    <h5 class="text-capitalize "> {{  translate($key) }}: {{$item}}</h5>
                    @empty
                    <h5 class="text-capitalize"> {{translate('messages.No_Data_found')}}</h5>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($wr->vendor && $wr->vendor->stores[0])
            <div class="col-md-4">
                <div class="card min-height-260">
                    <div class="card-header">
                        <h3 class="h3 mb-0">{{translate($vendor.'_info')}}</h3>
                        <i class="tio tio-shop-outlined"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="d-flex __gap-5px"><span>{{translate($vendor)}}</span> <span>:</span> <span>{{$wr->vendor->stores[0]->name}}</span></h5>
                        <h5 class="d-flex __gap-5px"><span>{{translate('messages.phone')}}</span> <span>:</span> <span>{{$wr->vendor->stores[0]->contact}}</span></h5>
                        <h5 class="d-flex __gap-5px"><span>{{translate('messages.address')}}</span> <span>:</span> <span>{{$wr->vendor->stores[0]->address}}</span></h5>
                        <h5 class="text-capitalize badge badge-success d-flex __gap-5px"><span>{{translate('messages.balance')}}</span> <span>:</span> <span>{{$wr->vendor->wallet->balance}}</span></h5>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="card min-height-260">
                <div class="card-header">
                    <h3 class="h3 mb-0 "> {{translate('messages.owner_info')}}</h3>
                    <i class="tio tio-user-big-outlined"></i>
                </div>
                <div class="card-body">
                    @if ($wr->vendor)
                        <h5 class="d-flex __gap-5px"><span>{{translate('messages.name')}}</span> <span>:</span> <span>{{$wr->vendor->f_name}} {{$wr->vendor->l_name}}</span></h5>
                        <h5 class="d-flex __gap-5px"><span>{{translate('messages.email')}}</span> <span>:</span> <span>{{$wr->vendor->email}}</span></h5>
                        <h5 class="d-flex __gap-5px"><span>{{translate('messages.phone')}}</span> <span>:</span> <span>{{$wr->vendor->phone}}</span></h5>
                    @else
                        <h5>{{translate('messages.'.$vendor.' deleted!')}}</h5>
                    @endif

                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{translate('Withdraw request process')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('admin.transactions.store.withdraw_status',[$wr->id])}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">{{translate('messages.request')}}:</label>
                                <select name="approved" class="custom-select" id="inputGroupSelect02">
                                    <option value="1">{{translate('messages.approve')}}</option>
                                    <option value="2">{{translate('messages.deny')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">{{translate('Note_about_transaction_or_request')}}:</label>
                                <textarea class="form-control" name="note" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('messages.Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{translate('messages.Submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

@endpush
