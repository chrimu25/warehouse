<x-app-layout title="Insert new Item">
    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-1 md:space-y-0">
          <ul>
            <li>{{Auth::user()->role}}</li>
            <li>Items</li>
            <li>Insert New</li>
          </ul>
        </div>
    </section>
    <div class="bg-gray-100">
        <div class="min-h-screen sm:pt-0 ">
          @livewire('manager.insert-items')
        </div>
    </div>
    <div wire:ignore.self class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex 
    justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat 
    bg-center bg-cover hidden"  id="my-modal">
      <div class="absolute bg-black opacity-80 inset-0 z-0" id=""></div>
     <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
       <!--content-->
       <div class="">
         <h3 class="mx text-center text-2xl font-bold">Insert New Client</h3>
         <!--body-->
         @livewire('manager.new-client')
       </div>
     </div>
   </div>
   @push('script')
     <script>
       let modal = document.getElementById("my-modal");
       let btn = document.getElementById("open-btn");
       let close = document.getElementById("close-btn");
   
       btn.onclick = function() {
       modal.classList.remove('hidden');
       }
       close.onclick = function() {
        modal.classList.add('hidden');
       }
       window.livewire.on('InsertItemsComponent', () => {
          modal.classList.add('hidden');
        });
     </script>
   @endpush
</x-app-layout>
