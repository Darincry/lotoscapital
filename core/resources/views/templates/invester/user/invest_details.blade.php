@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-inner">
        <div>
            <p>Депозиты</p>
            <div class="d-flex flex-wrap justify-content-between mb-4">
                <h3>Информация по вкладу</h3>
                @if ($invest->eligibleCapitalBack())
                    <button class="btn btn--base btn--smd" data-bs-toggle="modal" data-bs-target="#capitalModal">@lang('Manage Capital')</button>
                @endif
            </div>
        </div>
        <div class="row gy-3">
            <div class="col-xl-4">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">Инфомрация о тарифе</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @php
                                $plan = $invest->plan;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between">
                                Тариф
                                <span>{{ __($plan->name) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Лимиты
                                <span>
                                    @if ($plan->fixed_amount > 0)
                                        {{ $general->cur_sym }}{{ showAmount($plan->fixed_amount) }}
                                    @else
                                        {{ $general->cur_sym }}{{ showAmount($plan->minimum) }} - {{ $general->cur_sym }}{{ showAmount($plan->maximum) }}
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Процентная ставка
                                <span>{{ showAmount($plan->interest) }}{{ $plan->interest_type == 1 ? '%' : " $general->cur_text" }}</span>
                            </li> <!--
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Compound Interest')
                                <span>
                                    @if ($plan->compound_interest)
                                        @lang('Yes')
                                    @else
                                        @lang('No')
                                    @endif
                                </span>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Hold Capital')
                                <span>
                                    @if ($plan->hold_capital)
                                        @lang('Yes')
                                    @else
                                        @lang('No')
                                    @endif
                                </span>
                            </li>   -->
                            <li class="list-group-item d-flex justify-content-between">
                                Срок вклада
                                <span>
                                    @if ($plan->repeat_time)
                                        24 часа
                                    @else
                                        @lang('Lifetime')
                                    @endif
                                </span>
                            </li> 
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Status')
                                <span>
                                    @if ($plan->status)
                                        <span class="badge badge--success">Активен</span>
                                    @else
                                        <span class="badge badge--warning">Закрыт</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">Базовая информация</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                Сумма вклада
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->initial_amount) }}</span>
                            </li> <!--
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Current Invest')
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->amount) }}</span>
                            </li> -->
                            <li class="list-group-item d-flex justify-content-between">
                                Открыт
                                <span>{{ showDateTime($invest->created_at) }}</span>
                            </li> <!--
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Initial Interest')
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->initial_interest) }}</span>
                            </li> -->
                            <li class="list-group-item d-flex justify-content-between">
                                Ожидаемая прибыль
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->interest) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Срок вклада
                                <span>24 часа</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Status')
                                <span>
                                    @if ($invest->status == 1)
                                        <span class="badge badge--success">@lang('Running')</span>
                                    @elseif($invest->status == 2)
                                        <span class="badge badge--danger">@lang('Canceled')</span>
                                    @else
                                        <span class="badge badge--info">@lang('Completed')</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="title">Начисления </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                Количество выплат
                                <span>
                                    @if ($invest->period != -1)
                                        {{ $invest->period }} 
                                    @else
                                        @lang('Lifetime')
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                Выплат
                                <span>{{ $invest->return_rec_time }} </span>
                            </li> <!--
                            <li class="list-group-item d-flex justify-content-between">
                                Выплачено
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->paid) }}</span>
                            </li> -->
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Should Pay')
                                <span>
                                    @if ($invest->should_pay != -1)
                                        <span class="fw-bold">{{ showAmount(($invest->amount)+($invest->interest)) }} {{ $general->cur_text }} </span>
                                    @else
                                        **
                                    @endif
                                </span>
                            </li> <!--
                            <li class="list-group-item d-flex justify-content-between">
                                @lang('Last Paid Time')
                                <span>{{ showDateTime($invest->last_time) }}</span>
                            </li> -->
                            <li class="list-group-item d-flex justify-content-between">
                                Выплата
                                <span>{{ showDateTime($invest->next_time) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                Полученная прибыль
                                <span>{{ $general->cur_sym }}{{ showAmount($invest->net_interest) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        @if ($invest->compound_times)
            <h4 class="mb-2 mt-4">@lang('All Interests & Compound Investment')</h4>
        @else
            <h4 class="mb-2 mt-4">Начисления прибыли</h4>
        @endif

        <div class="accordion table--acordion" id="transactionAccordion">
            @forelse($transactions as $transaction)
                <div class="accordion-item transaction-item">
                    <h2 class="accordion-header" id="h-{{ $loop->iteration }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c-{{ $loop->iteration }}">
                            <div class="col-lg-4 col-sm-5 col-8 order-1 icon-wrapper">
                                <div class="left">
                                    <div class="icon tr-icon @if ($transaction->trx_type == '+') icon-success @else icon-danger @endif">
                                        <i class="las la-long-arrow-alt-right"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="trans-title">Проценты по вкладу</h6>
                                        <span class="text-muted font-size--14px mt-2">{{ showDateTime($transaction->created_at, 'M d Y @g:i:a') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12 order-sm-2 order-3 content-wrapper mt-sm-0 mt-3">
                                <p class="text-muted font-size--14px"><b>#{{ $transaction->trx }}</b></p>
                            </div>
                            <div class="col-lg-4 col-sm-3 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                <p>
                                    <b>{{ showAmount($transaction->amount) }} {{ $general->cur_text }}</b><br>
                                    <small class="fw-bold text-muted">Баланс: {{ showAmount($transaction->post_balance) }} {{ $general->cur_text }}</small>
                                </p>

                            </div>
                        </button>
                    </h2>
                    <div id="c-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="h-1" data-bs-parent="#transactionAccordion">
                        <div class="accordion-body">
                            <ul class="caption-list">
                                <li>
                                    <span class="caption">Баланс после</span>
                                    <span class="value">{{ showAmount($transaction->post_balance) }} {{ $general->cur_text }}</span>
                                </li>
                                <li>
                                    <span class="caption">@lang('Details')</span>
                                    <span class="value">{{ __($transaction->details) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- transaction-item end -->
            @empty
                <div class="accordion-body text-center">
                    <h4 class="text--muted"><i class="far fa-frown"></i> Прибыль пока не начислена</h4>
                </div>
            @endforelse
        </div>


        @if ($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>


    <div class="modal fade" id="capitalModal">
        <div class="modal-dialog modal-dialog-centered modal-content-bg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Manage Invest Capital')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.invest.capital.manage') }}" method="post">
                    @csrf
                    <input type="hidden" name="invest_id" value="{{ $invest->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Investment Capital')</label>
                            <select name="capital" class="form-control form--control form-select">
                                <option value="reinvest">@lang('Reinvest')</option>
                                <option value="capital_back">@lang('Capital Back')</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
