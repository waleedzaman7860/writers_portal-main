@extends('layouts.app')
@section('content')
    {{-- <h1>{{Auth::user()->id}}</h1> --}}
    {{-- @php
        $getAllWriters = App\Models\User::all();
        $countAllWriters = count($getAllWriters);

        $getAllArticle = App\Models\Article::all();
        $countAllArticle = count($getAllArticle);

        $getAllWithdrequest = App\Models\WithdrawFunds::all();
        foreach ($getAllWithdrequest as $key) {
            $getAllWithdrequestTotalPayouts[] = $key->withdraw_amount;
        }
        $TotalPayouts = array_sum($getAllWithdrequestTotalPayouts);

    @endphp --}}

    @php
    // dd('this is home page');

        $getAllWriters = App\Models\User::all();
        $countAllWriters = count($getAllWriters);

        $getAllArticle = App\Models\Article::all();
        $countAllArticle = count($getAllArticle);

        $getAllWithdrequest = App\Models\WithdrawFunds::all();
        $getAllWithdrequestTotalPayouts = []; // Define the array

        foreach ($getAllWithdrequest as $key) {
            $getAllWithdrequestTotalPayouts[] = $key->withdraw_amount;
        }

        $TotalPayouts = array_sum($getAllWithdrequestTotalPayouts);
    @endphp


    <div class="container-fluid pt-5 pb-5" style="background-color: #90fcfc;">
        <p class="container text-center">
            Unlock your writing potential and earn while
            you express yourself! Our platform rewards passionate writers like you for submitting engaging and
            informative blog articles. Whether you're a seasoned pro or a budding wordsmith,
            join our community and turn your words into
            income. Share your unique insights, stories, and
            knowledge with the world, and watch your creativity flourish as you get compensated for each approved
            submission. Start your journey
            as a paid contributor today!</p>

        <div class="container bg-black rounded-5 p-3">
            <div class="row text-center">
                <div class="col-md-4 col-4">
                    <p class="text-white">Writers</p>
                    @if (isset($countAllWriters))
                        <p class="text-white">{{ $countAllWriters }}</p>
                    @endif
                </div>

                <div class="col-md-4 col-4">
                    <p class="text-white">Articles</p>
                    @if (isset($countAllArticle))
                        <p class="text-white">{{ $countAllArticle }}</p>
                    @endif
                </div>

                <div class="col-md-4 col-4">
                    <p class="text-white">Payout</p>
                    @if (isset($TotalPayouts))
                        <p class="text-white">USDT {{ $TotalPayouts }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>




    <div class="container-fluid pt-5 pb-5" style="
    background-color: #444349;">
        <h3 class="text-center text-white">What People are Saying</h3>
        <p class="text-center text-white">Chesscademy has inspired ten of thousands of people around the world to learn
            chess</p>
        <div class="container">

            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="card bg-body-secondary" style="width: 18rem;">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Card title</h5> -->
                            <p class="card-text">Finally, all well designed Product for learning chess. Nothing out
                                there is a simple and painless</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            <div class="arrow">

                            </div>
                        </div>
                    </div>
                    <!-- <div class=""> -->

                    <img src="{{ asset('img/client.jpg') }}" class="img-fluid pt-5 rounded-circle" alt="..."
                        style="height: 166px; object-fit: cover;">
                    <p class="text-white">Abishekh Gupta Lead UX designer at oliglvly</p>
                </div>


                <!-- second -->
                <div class="col-md-4 text-center">
                    <div class="card bg-body-secondary" style="width: 18rem;">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Card title</h5> -->
                            <p class="card-text">Finally, all well designed Product for learning chess. Nothing out
                                there is a simple and painless</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            <div class="arrow">

                            </div>
                        </div>
                    </div>
                    <!-- <div class=""> -->

                    <img src="{{ asset('img/client.jpg') }}" class="img-fluid pt-5 rounded-circle" alt="..."
                        style="height: 166px; object-fit: cover;">
                    <p class="text-white">Abishekh Gupta Lead UX designer at oliglvly</p>
                </div>


                <!-- third -->
                <div class="col-md-4 text-center">
                    <div class="card bg-body-secondary" style="width: 18rem;">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Card title</h5> -->
                            <p class="card-text">Finally, all well designed Product for learning chess. Nothing out
                                there is a simple and painless</p>
                            <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            <div class="arrow">

                            </div>
                        </div>
                    </div>
                    <!-- <div class=""> -->

                    <img src="{{ asset('img/client.jpg') }}" class="img-fluid pt-5 rounded-circle" alt="..."
                        style="height: 166px; object-fit: cover;">
                    <p class="text-white">Abishekh Gupta Lead UX designer at oliglvly</p>
                </div>

            </div>

        </div>
    </div>
    </div>
@endsection
