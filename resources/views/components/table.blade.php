<div class="card has-table">
    <div class="card-content">
        <table>
            {{-- <table class="min-w-full divide-y divide-gray-300 border"> --}}
            <thead>
                <tr>{{$heading}}</tr>
            </thead>
            <tbody>
                {{-- <tbody class="bg-white divide-y divide-gray-300 divide-solid"> --}}
                {{$slot}}
            </tbody>
        </table>
        <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
    </div>

</div>