<x-app-layout>
  @push('extra-css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.32.0/apexcharts.min.css" 
  integrity="sha512-Tv+8HvG00Few62pkPxSs1WVfPf9Hft4U1nMD6WxLxJzlY/SLhfUPFPP6rovEmo4zBgwxMsArU6EkF11fLKT8IQ==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" /> 
  @endpush
  {{-- <div id="chart"></div> --}}
    {{-- @if (Auth::user()->role=="Admin") --}}
      {{-- @livewire('admin-dashboard') --}}
      <section class="section main-section">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
          <div class="card">
            <div class="card-content">
              <div class="flex items-center justify-between">
                <div class="widget-label">
                  <h3>
                    Clients
                  </h3>
                  <h1>
                    {{$clients}}
                  </h1>
                </div>
                <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="flex items-center justify-between">
                <div class="widget-label">
                  <h3>
                    Warehouses
                  </h3>
                  <h1>
                    {{$wh}}
                  </h1>
                </div>
                <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
              </div>
            </div>
          </div>
  
          <div class="card">
            <div class="card-content">
              <div class="flex items-center justify-between">
                <div class="widget-label">
                  <h3>
                    Storage
                  </h3>
                  <h1>
                    256%
                  </h1>
                </div>
                <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
              </div>
            </div>
          </div>
        </div>
        {{-- Warehouse trends --}}
        <div class="w-full">
            <div class="card mb-6">
                <header class="card-header">
                  <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-finance"></i></span>
                    warehouses Trends
                  </p>
                </header>
                <div class="card-content">
                  <div class="chart-area">
                    <div class="h-full">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div id="chart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        {{-- Check ins --}}
        <div class="w-full mb-6 md:flex justify-between">
          <div class=" card  w-full">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="checkins"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>
        {{-- Checkout --}}
        <div class="w-full mb-6 md:flex justify-between">
          <div class="w-full card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="checkouts"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full ml-2 card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="checkoutspie"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Transfers --}}
        <div class="mb-6 md:flex justify-between">
          <div class="w-full card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="transfers"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full ml-2 card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div id="transferpie"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Requests --}}
        <div class="mb-6 md:flex justify-between">
          <div class="w-full card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="requests"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full ml-2 card">
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="requestpie"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    {{-- @elseif(Auth::user()->role=="Manager")
      @include('manager.dashboard')
    @elseif (Auth::user()->role=="Client")
    @include('client.dashboard')
    @endif --}}
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.32.0/apexcharts.min.js" 
    integrity="sha512-JWuHiH5weF9hQAM/H5LaXRekU40IcLV8QgqGtvlR2t6vFNmDdCxkmFDajuHiuN0Tyh3n7HO/qdb3ARyUokKs0A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      var options = {
          series: [{
            name: "Transfers",
            data: {{$transfers}}
          },
          {
            name: "Activities",
            data: {{$checkins}}
          },
          {
            name: 'Requests',
            data: {{$requests}}
          }
        ],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
           toolbar: {
      show: false
    },
          
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [5, 7, 5],
          curve: 'straight',
          dashArray: [0, 8, 5]
        },
        title: {
          text: 'Page Statistics',
          align: 'left',
        },
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
          }
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6
          }
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        },
        tooltip: {
          y: [
            {
              title: {
                formatter: function (val) {
                  return val
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val
                }
              }
            },
            {
              title: {
                formatter: function (val) {
                  return val;
                }
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // checkins
        var options = {
          series: [{
            name: "Checkins",
            data: {{$totalCheckins}}
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
           toolbar: {
      show: false
    }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Yearly Checkins Trends',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#checkins"), options);
        chart.render();

        var options = {
          series: {{$checkinspie}},
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Pending', 'Approved', 'Denied'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 120
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#checkinspie"), options);
        chart.render();
        // checkouts
        var options = {
          series: [{
            name: "Checkouts",
            data: {{$totalCheckouts}}
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
           toolbar: {
      show: false
    }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Yearly Checkouts Trends',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#checkouts"), options);
        chart.render();

        var options = {
          series: {{$checkoutspie}},
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Pending', 'Approved', 'Denied'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 120
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#checkoutspie"), options);
        chart.render();

        // transfers
        var options = {
          series: [{
            name: "Transfers",
            data: {{$transfers}}
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
           toolbar: {
      show: false
    }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Yearly Transfers Trends',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#transfers"), options);
        chart.render();

        var options = {
          series: {{$transferpie}},
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Pending', 'Approved', 'Denied'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 120
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#transferpie"), options);
        chart.render();

         // requests
         var options = {
          series: [{
            name: "Requests",
            data: {{$requests}}
        }],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          },
           toolbar: {
      show: false
    }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Yearly Requests Trends',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#requests"), options);
        chart.render();

        var options = {
          series: {{$requestpie}},
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: ['Pending', 'Approved', 'Denied'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 120
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#requestpie"), options);
        chart.render();
    </script>
    @endpush
</x-app-layout>
