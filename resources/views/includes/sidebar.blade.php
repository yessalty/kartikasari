@auth
    @if (auth()->user()->role === 'admin')
        @include('includes.sidebar.admin')
        
    @else
        @include('includes.sidebar.user')
    @endif
@endauth