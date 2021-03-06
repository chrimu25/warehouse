<x-app-layout title="CheckOuts">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>All Request</li>
          </ul>
          <a href="{{ route('client.requests.new') }}" class="button dark">
            <span class="icon"><i class="mdi mdi-plus"></i></span>
            <span>New Checkout</span>
          </a>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen px-5">
            @livewire('clients.items')
        </div>
    </div>
</x-app-layout>
