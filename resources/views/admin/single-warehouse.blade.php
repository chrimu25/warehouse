<x-app-layout :title="$wh->name">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Warehouse</li>
            <li>{{$wh->name}}</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            {{-- @livewire('admin.categories') --}}
        </div>
    </div>
</x-app-layout>
