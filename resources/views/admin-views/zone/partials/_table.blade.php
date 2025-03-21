
@php($config=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery'))
@php($digital_payment=\App\CentralLogics\Helpers::get_business_settings('digital_payment'))
@php($offline_payment=\App\CentralLogics\Helpers::get_business_settings('offline_payment_status'))
@php($non_mod = 0)
@foreach($zones as $key=>$zone)
@php($non_mod = (count($zone->modules)>0 && $non_mod == 0) ? $non_mod:$non_mod+1 )
    <tr>
        <td>{{$key+1}}</td>
        <td>{{$zone->id}}</td>
        <td>
            <span class="d-block font-size-sm text-body">
                {{$zone['name']}}
            </span>
        </td>
        <td>{{$zone->stores_count}}</td>
        <td>{{$zone->deliverymen_count}}</td>
        <td>
            <label class="toggle-switch toggle-switch-sm" for="status-{{$zone['id']}}">
                <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                       data-id="status-{{$zone['id']}}"
                       data-type="status"
                       data-image-on='{{asset('/assets/admin/img/modal')}}/zone-status-on.png'
                       data-image-off="{{asset('/assets/admin/img/modal')}}/zone-status-off.png"
                       data-title-on="{{translate('Want_to_activate_this_Zone?')}}"
                       data-title-off="{{translate('Want_to_deactivate_this_Zone?')}}"
                       data-text-on="<p>{{translate('If_you_activate_this_zone,_Customers_can_see_all_stores_&_products_available_under_this_Zone_from_the_Customer_App_&_Website.')}}</p>"
                       data-text-off="<p>{{translate('If_you_deactivate_this_zone,_Customers_Will_NOT_see_all_stores_&_products_available_under_this_Zone_from_the_Customer_App_&_Website.')}}</p>"
                       id="status-{{$zone['id']}}" {{$zone->status?'checked':''}}>
                <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
            </label>
            <form action="{{route('admin.business-settings.zone.status',[$zone['id'],$zone->status?0:1])}}" method="get" id="status-{{$zone['id']}}_form">
            </form>
        </td>
        @if ($digital_payment && $digital_payment['status']==1)
            <td>
                <label class="toggle-switch toggle-switch-sm" for="digital_paymentCheckbox{{$zone->id}}">
                    <input type="checkbox" data-id="digital_payment-{{$zone['id']}}" data-title="{{ $zone->digital_payment?translate('Want_to_disable_‘Digital_Payment’?'):translate('Want_to_enable_‘Digital_Payment’?') }}" data-message="{{ $zone->digital_payment? translate('If_yes,_the_digital_payment_option_will_be_hidden_during_checkout.'):translate('If_yes,_Customers_can_choose_the_‘Digital_Payment’_option_during_checkout.')}}" class="toggle-switch-input status_form_alert" id="digital_paymentCheckbox{{$zone->id}}" {{$zone->digital_payment?'checked':''}}>
                    <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
                </label>
                <form action="{{route('admin.business-settings.zone.digital-payment',[$zone['id'],$zone->digital_payment?0:1])}}" method="get" id="digital_payment-{{$zone['id']}}">
                </form>
            </td>
        @endif
        @if ($config && $config['status']==1)
            <td>
                <label class="toggle-switch toggle-switch-sm" for="cashOnDeliveryCheckbox{{$zone->id}}">
                    <input type="checkbox" data-id="cash_on_delivery-{{$zone['id']}}" data-title="{{ $zone->cash_on_delivery?translate('Want_to_disable_‘Cash_On_Delivery’?'):translate('Want_to_enable_‘Cash_On_Delivery’?') }}" data-message="{{ $zone->cash_on_delivery? translate('If_yes,_the_Cash_on_Delivery_option_will_be_hidden_during_checkout.'):translate('If_yes,_Customers_can_choose_the_‘Cash_On_Delivery’_option_during_checkout.')}}" class="toggle-switch-input status_form_alert" id="cashOnDeliveryCheckbox{{$zone->id}}" {{$zone->cash_on_delivery?'checked':''}}>
                    <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                </label>
                <form action="{{route('admin.business-settings.zone.cash-on-delivery',[$zone['id'],$zone->cash_on_delivery?0:1])}}" method="get" id="cash_on_delivery-{{$zone['id']}}">
                </form>
            </td>
        @endif
        @if ($offline_payment && $offline_payment==1)
            <td>
                <label class="toggle-switch toggle-switch-sm" for="offline_paymentCheckbox{{$zone->id}}">
                    <input type="checkbox" data-id="offline_payment-{{$zone['id']}}" data-title="{{ $zone->offline_payment?translate('Want_to_disable_‘offline_Payment’?'):translate('Want_to_enable_‘offline_Payment’?') }}" data-message="{{ $zone->offline_payment? translate('If_yes,_the_offline_payment_option_will_be_hidden_during_checkout.'):translate('If_yes,_Customers_can_choose_the_‘offline_Payment’_option_during_checkout.')}}" class="toggle-switch-input status_form_alert" id="offline_paymentCheckbox{{$zone->id}}" {{$zone->offline_payment?'checked':''}}>
                    <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                </label>
                <form action="{{route('admin.business-settings.zone.offline-payment',[$zone['id'],$zone->offline_payment?0:1])}}" method="get" id="offline_payment-{{$zone['id']}}">
                </form>
            </td>
        @endif
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary"
                   href="{{route('admin.business-settings.zone.edit',[$zone['id']])}}" title="{{translate('messages.edit_zone')}}"><i class="tio-edit"></i>
                </a>
                <div class="popover-wrapper {{ $non_mod == 1 ? 'active':'' }}">
                    <a class="btn active action-btn btn--warning btn-outline-warning" href="{{route('admin.business-settings.zone.module-setup',[$zone['id']])}}">
                        <i class="tio-settings"></i>
                    </a>
                    <div class="popover __popover">
                        <div class="arrow"></div>
                        <h3 class="popover-header d-flex justify-content-between">
                            <span>{{ translate('messages.Important!') }}</span>
                        </h3>
                        <div class="popover-body">
                            {{ translate('The_Business_Zone_will_NOT_work_if_you_don’t_select_your_business_module_&_payment_method.') }}
                        </div>
                    </div>
                </div>
                <a class="btn action-btn btn--danger btn-outline-danger status_form_alert" href="javascript:" data-id="zone-{{$zone['id']}}" data-title="{{ translate('Want_to_Delete_this_Zone?') }}" data-message="{{ translate('If_yes,_all_its_modules,_stores,_and_products_will_be_DELETED_FOREVER.') }}" title="{{translate('messages.delete_zone')}}"><i class="tio-delete-outlined"></i>
                </a>
                <form action="{{route('admin.business-settings.zone.delete',[$zone['id']])}}" method="post" id="zone-{{$zone['id']}}">
                    @csrf @method('delete')
                </form>
            </div>
        </td>
    </tr>
@endforeach
