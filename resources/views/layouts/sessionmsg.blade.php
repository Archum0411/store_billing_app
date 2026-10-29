@if (session('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert"
        style="position: fixed;right: 30px; z-index: 1; width:40% ">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endif

@if (session('error'))
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert"
        style="position: fixed;right: 30px; z-index: 1; width:40% ">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            $('#errorAlert').fadeOut('slow');
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>
@endif


{{-- @if (session('success'))
    <div id="successAlert" class="alert alert-success "
        style="    position: absolute;
    right: 0;
    z-index: 1;
    width:30%
">
        {{ session('success') }}
    </div>



    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 300000); // 3000 milliseconds = 3 seconds
    </script>
@endif --}}
