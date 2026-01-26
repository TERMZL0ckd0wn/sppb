@section('user')
Admin
@endsection
@section('nav')
    <nav class="bg-nav-footer px-8 shadow-inner">
        <ul class="flex justify-center space-x-6 text-gray-800 font-semibold text-sm">
            <li class="nav-dashboard">
                <a href="{{url ('/dashboard')}}" class="block py-3 px-2 hover:bg-gray-400 rounded-t-md">DASHBOARD</a>
            </li>
            <li class="nav-record">
                <a href="{{url('/record')}}" class="block py-3 px-2 hover:bg-gray-400 rounded-t-md">BORROWING RECORD</a>
            </li>
            <li class="nav-person">
                <a href="{{url('/student')}}" class="block py-3 px-2 hover:bg-gray-400 rounded-t-md">PERSON</a>
            </li>
            <li class="nav-book">
                <a href="{{url('/book')}}" class="block py-3 px-2 hover:bg-gray-400 rounded-t-md">BOOK</a>
            </li>
            <li class="nav-user">
                <a href="{{url('/user')}}" class="block py-3 px-2 hover:bg-gray-400 rounded-t-md">USER</a>
            </li>
        </ul>
    </nav>
@endsection