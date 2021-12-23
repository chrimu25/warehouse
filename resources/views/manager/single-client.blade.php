<x-app-layout title="View: {{$user->name}}">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Cients</li>
            <li>{{$user->name}}</li>
          </ul>
        </div>
    </section>
    <div class="w-full bg-gray-100">
      <div x-data="{ openTab: 1 }" class="p-6">
        <ul class="flex border-b">
          <li @click="openTab = 1" class="-mb-px mr-1">
            <a class="bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700
             font-semibold" href="#">Incoming Request</a>
          </li>
          <li @click="openTab = 2" class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" 
            href="#">Checkins</a>
          </li>
          <li @click="openTab = 3" class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" 
            href="#">Checkouts</a>
          </li>
          <li @click="openTab = 4" class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" 
            href="#">Incoming Transfers</a>
          </li>
          <li @click="openTab = 5" class="mr-1">
            <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" 
            href="#">Outgoing Transfers</a>
          </li>
        </ul>
        @livewire('manager.single-client', ['user' => $user], key($user->id))
      </div>
    </div>
</x-app-layout>
