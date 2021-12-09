<x-app-layout title="{{$item->item->name}} Transfer">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>Transfer {{$item->item->name}} from {{$item->warehouse->name}} Warehouse</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0 bg-white rounded">
            @livewire('clients.single-transfer', ['item' => $item], key($item->id))
        </div>
    </div>
</x-app-layout>
