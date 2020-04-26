@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="list-group">
                        @foreach($dates as $date)
                            @php
                                $gmtTimezone = new DateTimeZone('UTC');
                                $myTimezone = new DateTimeZone($userTimezone);
                                $gmtDateTime = new DateTime($date->date, $gmtTimezone);
                                $gmtDateTime2 = new DateTime($date->date, $gmtTimezone);
                                $myDateTime = $gmtDateTime2->setTimeZone($myTimezone);
                            @endphp
                            <a href="#" class="list-group-item list-group-item-action">{{ $gmtDateTime->format('g:ia \o\n l jS F Y') }} UTC <b>TO</b> {{ $myDateTime->format('g:ia \o\n l jS F Y') . " " .$userTimezone }} </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    {{ $dates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
