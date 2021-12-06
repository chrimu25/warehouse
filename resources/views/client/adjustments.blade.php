<x-app-layout title="Adjustment">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>Adjustment</li>
          </ul>
          <a href="{{ route('admin.warehouses.create') }}" class="button dark">
            <span class="icon"><i class="mdi mdi-plus"></i></span>
            <span>Make An Adjustment</span>
          </a>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            @livewire('clients.adjustment')
        </div>
    </div>
</x-app-layout>
