<x-app-layout title="CheckOuts">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>CheckOuts</li>
          </ul>
          <a href="{{ route('admin.warehouses.create') }}" class="button dark">
            <span class="icon"><i class="mdi mdi-plus"></i></span>
            <span>New Checkout</span>
          </a>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            @livewire('clients.check-outs')
        </div>
    </div>
</x-app-layout>
