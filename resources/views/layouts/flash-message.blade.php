<div class="max-w-lg mx-auto mt-6 mr-6">

    @if(session()->has('success'))

        <div class="flex bg-grey-800 rounded-lg p-4 text-sm text-red-600 ">
            {{ session('success') }}
        </div>
    @endif
    
</div>