<x-app-layout title="Transfers">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Requests</li>
            <li>Transfers</li>
          </ul>
          <div>
            <a href="{{ route('admin.export.transfers.yearly') }}" class="button bg-green-300 text-green-900
             space-x-3">
              <span class="icon"><i class="mdi mdi-download"></i></span>
              <span>Yearly Report</span>
            </a>
            <a href="{{ route('admin.export.transfers') }}" class="button bg-green-300 text-green-900
             space-x-3">
              <span class="icon"><i class="mdi mdi-download"></i></span>
              <span>Monthly Report</span>
            </a>
          </div>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen px-5">
            @livewire('admin.transfers')
        </div>
    </div>
</x-app-layout>
