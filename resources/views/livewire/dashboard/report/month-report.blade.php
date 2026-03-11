<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Month Orders Report')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Month Orders Report')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="month" class="form-label">@lang('Month')</label>
                    <select wire:model.live="month" id="month" class="form-control">
                        <option value="1">@lang('January')</option>
                        <option value="2">@lang('February')</option>
                        <option value="3">@lang('March')</option>
                        <option value="4">@lang('April')</option>
                        <option value="5">@lang('May')</option>
                        <option value="6">@lang('June')</option>
                        <option value="7">@lang('July')</option>
                        <option value="8">@lang('August')</option>
                        <option value="9">@lang('September')</option>
                        <option value="10">@lang('October')</option>
                        <option value="11">@lang('November')</option>
                        <option value="12">@lang('December')</option>
                    </select>
                    @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="year" class="form-label">@lang('Year')</label>
                    <select wire:model.live="year" id="year" class="form-control">
                        @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3 pt-4 mt-2">
                    <button type="button" class="btn btn-primary" wire:click="fetchOrderData">
                        @lang('Refresh Data')
                    </button>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Daily Orders')</h5>
                </div>

                <div class="card-body">
                    <div id="ordersChart" wire:ignore></div>
                </div>

            </div>

        </div>


    </div>
</div>

@push('js')

    <script>
        (function () {
            // Livewire قد يعيد حقن نفس السكربت أكثر من مرة (خصوصًا مع navigate)
            // وهذا يسبب تكرار listeners وبالتالي تكرار الشارت. هذا الحارس يمنع التنفيذ أكثر من مرة.
            if (window.__monthOrdersReportChartBooted) return;
            window.__monthOrdersReportChartBooted = true;

            const containerSelector = '#ordersChart';
            window.__monthOrdersReportChartInstance = window.__monthOrdersReportChartInstance || null;
            window.__monthOrdersReportLastData = window.__monthOrdersReportLastData || null;

            function waitForApexCharts(callback) {
                if (typeof ApexCharts !== 'undefined') {
                    callback();
                    return;
                }
                setTimeout(function () {
                    waitForApexCharts(callback);
                }, 100);
            }

            function renderChart(chartData) {
                if (!chartData || !chartData.series || !chartData.categories) return;
                window.__monthOrdersReportLastData = chartData;

                const chartContainer = document.querySelector(containerSelector);
                if (!chartContainer) return;

                // Destroy existing chart instance (shared globally) then clean container
                if (window.__monthOrdersReportChartInstance) {
                    try {
                        window.__monthOrdersReportChartInstance.destroy();
                    } catch (e) {
                        // ignore
                    }
                    window.__monthOrdersReportChartInstance = null;
                }

                chartContainer.innerHTML = '';

                const options = {
                    series: chartData.series,
                    chart: {
                        height: 350,
                        type: 'bar',
                        toolbar: { show: false },
                        animations: { enabled: true }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: { enabled: false },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: chartData.categories,
                        title: { text: '@lang("Day of Month")' }
                    },
                    yaxis: {
                        title: { text: '@lang("Number of Orders")' }
                    },
                    fill: { opacity: 1 },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " @lang('orders')";
                            }
                        }
                    }
                };

                window.__monthOrdersReportChartInstance = new ApexCharts(chartContainer, options);
                window.__monthOrdersReportChartInstance.render();
            }

            function bootWithData(chartData) {
                waitForApexCharts(function () {
                    // requestAnimationFrame يساعد أن يكون الـ DOM جاهز قبل الرسم
                    requestAnimationFrame(function () {
                        renderChart(chartData);
                    });
                });
            }

            // أول تحميل للصفحة
            document.addEventListener('DOMContentLoaded', function () {
                bootWithData(@json($chartData));
            });

            // تحديثات البيانات من السيرفر
            document.addEventListener('chartDataUpdated', function (event) {
                if (event?.detail?.chartData) {
                    bootWithData(event.detail.chartData);
                }
            });

            // في حال استخدام Livewire Navigate: نعيد الرسم بعد التنقل باستخدام آخر بيانات معروفة
            document.addEventListener('livewire:navigated', function () {
                if (window.__monthOrdersReportLastData) {
                    bootWithData(window.__monthOrdersReportLastData);
                }
            });
        })();



    </script>

    @endpush
