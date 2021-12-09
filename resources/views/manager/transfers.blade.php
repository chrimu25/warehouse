<x-app-layout title="Transfers">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Requests</li>
            <li>Transfers</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen px-5">
            @livewire('manager.transfers')
        </div>
    </div>
</x-app-layout>
