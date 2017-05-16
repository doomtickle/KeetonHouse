@extends('layouts.main')

@section('title')
    All Residents
@endsection

@section('content')
    <div class="container">
        <a href="/resident/create" class="button is-primary" style="margin-top: 30px;">Add a new resident</a>
        <div class="columns">
            <div class="column">
                <p><input type="text" class="quicksearch input column is-3" placeholder="Search"/></p>
                <div class="grid">
                    <div class="row">
                        @foreach($residents as $resident)
                            <div class="single-resident">
                                <div class="card">
                                    <header class="card-header">
                                        <p class="card-header-title">
                                            <a href="{{ route('resident.show', ['id' => $resident->id]) }}" class="blackish">{{ ucfirst($resident->last_name) }}, {{ ucfirst($resident->first_name) }} {{ strtoupper($resident->middle_initial) }}</a><span class="column has-text-right doc-number">{{ $resident->document_number }}</span>
                                        </p>
                                    </header>
                                    <div class="card-content">
                                        <div class="content">
                                            <p><strong>Sex: </strong>{{ $resident->sex }}</p>
                                            <p><strong>Race: </strong>{{ $resident->race }}</p>
                                            <p><strong>Service Center #: </strong>{{ $resident->service_center_number }}</p>
                                            <p><strong>DOB: </strong>{{ $resident->dob }}</p>
                                            <p><strong>Age: </strong>{{ $resident->age }}</p>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <a class="card-footer-item blackish" href="{{ route('transaction.create',  $resident->id ) }}">Account</a>
                                        <a class="card-footer-item blackish" href="{{ route('resident.edit', $resident->id) }}">Edit</a>
                                        <a class="card-footer-item danger">Delete</a>
                                    </footer>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts.footer')
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.0/masonry.pkgd.min.js"></script>

    <script>
        // quick search regex
        var qsRegex;

        // init Isotope
        var $grid = $('.grid').isotope({
            itemSelector: '.single-resident',
            layoutMode: 'fitRows',
            filter: function () {
                return qsRegex ? $(this).text().match(qsRegex) : true;
            }
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup(debounce(function () {
            qsRegex = new RegExp($quicksearch.val(), 'gi');
            $grid.isotope();
        }, 200));

        // debounce so filtering doesn't happen every millisecond
        function debounce(fn, threshold) {
            var timeout;
            return function debounced() {
                if (timeout) {
                    clearTimeout(timeout);
                }
                function delayed() {
                    fn();
                    timeout = null;
                }

                timeout = setTimeout(delayed, threshold || 100);
            }
        }

    </script>
@endsection



