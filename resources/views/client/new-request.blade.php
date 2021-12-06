<x-app-layout title="New Request">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>New Request</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0 bg-white rounded">
            @livewire('clients.request')
        </div>
    </div>
</x-app-layout>
