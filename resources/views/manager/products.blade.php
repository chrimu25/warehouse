<x-app-layout title="Warehouse Items">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Item</li>
          </ul>
          <a href="{{ route('manager.products.insert') }}" class="button dark space-x-3">
            <span class="icon"><i class="mdi mdi-plus"></i></span>
            <span>Insert Product Records</span>
          </a>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            @livewire('manager.products')
        </div>
    </div>
</x-app-layout>
