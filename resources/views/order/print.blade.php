@extends('layouts.print')

@section('seo_title', __('main.order'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

    <div class="container pt-4 pb-5">

        <h1 class="main-header mt-3">{{ __('main.order') }} #{{ $order->id }}</h1>

        @if($order->isInstallmentOrder())
            @if($order->installmentOrder->vendor_name == 'vendoo')
                <div class="mb-4">
                    <h4 class="medium-header">{{ __('main.installment_order') }} {{ __('main.through') }} Vendoo</h4>
                    <a href="{{ config('services.vendoo.scoring_url') . $order->installmentOrder->vendor_order_id }}">{{ __('main.place_installment_order_through') }} Vendoo</a>
                    {{--<p>{{ __('main.status') }}: {{ $order->installmentOrder->vendoo_status_title }}</p>--}}
                </div>
            @else
                <div class="mb-4">
                    Ошибка
                </div>
            @endif
        @endif

        <div class="box">

            <div class="my-4">
                <strong>{{ __('main.status') }}:</strong>
                <span>{{ $order->status_title }}</span>
            </div>

            <div class="order_table table-responsive">
                <table class="table products-list-table border">
                    <thead>
                        <tr class="bg-light">
                            <th class="border-bottom-0">{{ __('main.product') }}</th>
                            <th class="border-bottom-0">{{ __('main.price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $orderItem)
                            <tr class="border-bottom">
                                <td>
                                    {{ $orderItem->name }}
                                    <strong> × {{ $orderItem->quantity }}</strong>
                                </td>
                                <td class="text-nowrap"> {{ Helper::formatPrice($orderItem->total) }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="order_total">
                            <td><strong>{{ __('main.total') }}</strong></td>
                            <td class="text-nowrap"><strong>{{ Helper::formatPrice($order->total) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <script>
        window.print();
    </script>

@endsection
