<x-app-layout title="CheckIns">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>CheckIns</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen px-5">
            @livewire('clients.check-ins')
        </div>
    </div>
</x-app-layout>
