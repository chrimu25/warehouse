<x-app-layout title="Dashboard">
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
                {{$whclients}}
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
                Slots
              </h3>
              <h1>
                {{Auth::user()->warehouse->slots->count().__('/').Auth::user()->warehouse->num_of_slots}}
              </h1>
            </div>
            <div class="widget-label">
              <h3>Accopied: {{Auth::user()->warehouse->fullSlots->count()}}</h3>
              <h3>Empty Slots: {{Auth::user()->warehouse->EmptySlots->count()}}</h3>
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
                Total Earnings
              </h3>
              <h1>
                {{Auth::user()->warehouse->invoices->sum('total_price')}}
              </h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>
    <div class="md:flex justify-between mb-10">
      <div class="card w-full mr-4">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Top 5 With High Number of Requests
              </h3>
              <ul>
                @forelse ($top5 as $user)
                <li>
                  <a href="{{route('manager.client', Crypt::encrypt($user->id))}}">
                  {{$user->name.__(' ('.$user->items_count.')')}}
                  </a>
                </li>
                @empty
                    
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="card w-full">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Clients with High Number Of Activities
              </h3>
              <ul>
                @forelse ($top_activities as $user)
                <li>
                  <a href="{{route('manager.client', Crypt::encrypt($user->id))}}">
                  {{$user->name.__(' ('.$user->activities_count.')')}}
                  </a>
                </li>
                @empty
                    
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="md:flex justify-between">
      <div class="w-full mr-2">
          <div class="card mb-6">
              <header class="card-header">
                <p class="card-header-title">
                  <span class="icon"><i class="mdi mdi-finance"></i></span>
                  Yearly Warehouse Activities Trends
                </p>
              </header>
              <div class="card-content">
                <div class="chart-area">
                  <div class="h-full">
                    <div class="chartjs-size-monitor">
                      <div class="chartjs-size-monitor-shrink">
                        <div id="wh-checkouts"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div class="w-full">
          <div class="card mb-6">
              <header class="card-header">
                <p class="card-header-title">
                  <span class="icon"><i class="mdi mdi-finance"></i></span>
                  Yearly Requests Trends
                </p>
              </header>
              <div class="card-content">
                <div class="chart-area">
                  <div class="h-full">
                    <div class="chartjs-size-monitor">
                      <div class="chartjs-size-monitor-shrink">
                        <div id="wh-requests"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>

    {{-- <div class="w-full">
        <div class="card mb-6">
            <header class="card-header">
              <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-finance"></i></span>
                Yearly Transfers
              </p>
            </header>
            <div class="card-content">
              <div class="chart-area">
                <div class="h-full">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-shrink">
                      <div id="wh-transfers"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div> --}}
</section>
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.32.0/apexcharts.min.js" 
    integrity="sha512-JWuHiH5weF9hQAM/H5LaXRekU40IcLV8QgqGtvlR2t6vFNmDdCxkmFDajuHiuN0Tyh3n7HO/qdb3ARyUokKs0A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // warehouse checkouts
        var options = {
          series: [{
            name: 'Checkouts',
            data: {{$whcheckouts}}
          }, {
            name: 'Checkins',
            data: {{$whcheckins}}
          }],
          chart: {
          type: 'bar',
          height: 400,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: false,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        },
        };

        var chart = new ApexCharts(document.querySelector("#wh-checkouts"), options);
        chart.render();

        // warehouse transfers
        var options = {
          series: [{
            name: 'Incoming Requests',
            data: {{$whinrequests}}
          }, {
            name: 'Outgoing Requests',
            data: {{$whoutrequests}}
          }],
          chart: {
          type: 'bar',
          height: 400,
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            dataLabels: {
              position: 'top',
            },
          }
        },
        dataLabels: {
          enabled: false,
          offsetX: -6,
          style: {
            fontSize: '12px',
            colors: ['#fff']
          }
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#fff']
        },
        tooltip: {
          shared: true,
          intersect: false
        },
        xaxis: {
          categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        },
        };

        var chart = new ApexCharts(document.querySelector("#wh-requests"), options);
        chart.render();

        
    </script>
    @endpush
</x-app-layout>