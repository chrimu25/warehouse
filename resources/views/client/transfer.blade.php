<x-app-layout title="Transfer">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>Transfer</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen w-full ">
            @livewire('clients.transfer')
        </div>
    </div>
</x-app-layout>
