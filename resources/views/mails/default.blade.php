<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link rel="stylesheet" href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css')}}">
        <script src="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js')}}"></script>
        <style type="text/css" media="screen">
            * {
                font-family: "DejaVu Sans";
            }
            html {
                margin: 0;
            }
            body {
                font-size: 10px;
                margin: 36pt;
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
        </style>
    </head>
{{-- @component('mail::message') --}}
    <body>
        <table class="table mt-5">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="100%">
                        <h4 class="text-uppercase">
                            <strong>{{ $invoice->code }}</strong>
                        </h4>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Seller - Buyer --}}
        <table class="table">
            <thead>
                <tr>
                    <th class="border-0 pl-0 party-header" width="48.5%">
                        {{ __('invoices::invoice.seller') }}
                    </th>
                    <th class="border-0" width="3%"></th>
                    <th class="border-0 pl-0 party-header">
                        {{ __('invoices::invoice.buyer') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-0">
                            <p class="seller-name">
                                <strong>{{ config('app.name') }}</strong>
                            </p>
                    </td>
                    <td class="border-0"></td>
                    <td class="px-0">
                            <p class="buyer-name">
                                <strong>{{ $invoice->owner->name }}</strong>
                            </p>

                        @if($invoice->owner->province)
                            <p class="buyer-address">
                                {{ __('Province') }}: {{ $invoice->owner->province->name }}
                            </p>
                        @endif

                        @if($invoice->owner->district)
                            <p class="buyer-address">
                                {{ __('Province') }}: {{ $invoice->owner->district->name }}
                            </p>
                        @endif

                        @if($invoice->owner->sector)
                            <p class="buyer-address">
                                {{ __('Sector') }}: {{ $invoice->owner->sector->name }}
                            </p>
                        @endif

                        @if($invoice->owner->cell)
                            <p class="buyer-address">
                                {{ __('Cell') }}: {{ $invoice->owner->cell->name }}
                            </p>
                        @endif

                        @if($invoice->owner->phone)
                            <p class="buyer-phone">
                                {{ __('invoices::invoice.phone') }}: {{ $invoice->owner->phone }}
                            </p>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Table --}}
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">{{ __('Invoice') }}</th>
                    <th scope="col" class="border-0 pl-0">{{ __('Slot') }}</th>
                    <th scope="col" class="text-center border-0">{{ __('Price/Day') }}</th>
                    <th scope="col" class="text-right border-0">{{ __('Days') }}</th>
                    <th scope="col" class="text-right border-0 pr-0">{{ __('Total Price') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="pl-0">{{ $invoice->code }}</td>
                    <td class="text-right pr-0">{{ $invoice->product->slot->name }}</td>
                    <td class="text-right pr-0">{{ $invoice->product->slot->price }}</td>
                    <td class="text-right pr-0">{{ $invoice->days }}</td>
                    <td class="text-right pr-0">{{ $invoice->total_price }}</td>
                </tr>
            </tbody>
        </table>
        <p>
            {{ __('Total Amount') }}: {{ $invoice->total_price }}
        </p>
        <p>
            {{ __('Pay Until: ') }}: {{ $invoice->created_at->addDays(5) }}
        </p>
    </body>
</html>
{{-- @endcomponent --}}
