@extends('layouts.wrapper')
@section('content')
<div class="lock-overlay"></div>
    @php
        function formatShortenedRupiah($amount)
        {
            $suffix = '';
            if ($amount >= 1000000000) {
                $amount /= 1000000000;
                $suffix = 'B';
            } elseif ($amount >= 1000000) {
                $amount /= 1000000;
                $suffix = 'M';
            } elseif ($amount >= 1000) {
                $amount /= 1000;
                $suffix = 'K';
            }
            return 'Rp. ' . number_format($amount, $suffix == 'Rp.' ? 0 : 1) . $suffix;
        }
    @endphp
    <div class="row">
        <div class="col-lg-3 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ count($registrations['all']) }}</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-contacts"></i>
                </div>
                <a href="{{ route('admin_show_registrations', 'all') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ count($registrations['success']) }}</sup></h3>

                    <p>Succesful Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-checkmark-circle"></i>
                </div>
                <a href="{{ route('admin_show_registrations', 'success') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>Pending Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-stopwatch"></i>
                </div>
                <a href="{{ route('admin_show_registrations', 'pending') }}" class="small-box-footer">More info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Registration Attempts Report</h5>
                    @php
                        // Function to get the smallest and greatest timestamps
                        function getMinMaxTimestamp($data)
                        {
                            $timestamps = array_column($data, 'created_at');
                            $minTimestamp = min($timestamps);
                            $maxTimestamp = max($timestamps);
                            return [$minTimestamp, $maxTimestamp];
                        }

                        // Extracting data from the payload
                        $successData = $registrations['success'];
                        $pendingData = $registrations['pending'];
                        $allData = $registrations['all'];

                        // Get the smallest and greatest timestamps
                        [$minSuccessTimestamp, $maxSuccessTimestamp] = getMinMaxTimestamp($successData);
                        [$minPendingTimestamp, $maxPendingTimestamp] = getMinMaxTimestamp($pendingData);
                        [$minAllTimestamp, $maxAllTimestamp] = getMinMaxTimestamp($allData);
                        $title =
                            'Per ' .
                            date('d M, Y', strtotime($minSuccessTimestamp)) .
                            ' - ' .
                            date('d M, Y', strtotime($maxSuccessTimestamp));

                        // Assuming $registrationDetails is your original data

                        // Group data by activity_id and sum up counts
                        $aggregatedData = [];
                        foreach ($registrationDetails as $detail) {
                            $activityId = $detail['activity_id'];
                            if (!isset($aggregatedData[$activityId])) {
                                $aggregatedData[$activityId] = [
                                    'activity_id' => $activityId,
                                    'desc' => $detail['item_desc'],
                                    'count' => 0,
                                    // You can also include other fields here if needed
                                ];
                            }
                            $aggregatedData[$activityId]['count'] += $detail['count'];
                            // You can perform other aggregations or calculations here if needed
                        }

                        // Convert the associative array to a simple indexed array
                        $aggregatedData = array_values($aggregatedData);

                        // Encode the aggregated data to JSON
                        $aggregatedDataJson = json_encode($aggregatedData);
                    @endphp
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-wrench"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a href="#" class="dropdown-item">Action</a>
                                <a href="#" class="dropdown-item">Another action</a>
                                <a href="#" class="dropdown-item">Something else here</a>
                                <a class="dropdown-divider"></a>
                                <a href="#" class="dropdown-item">Separated link</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <strong>{{ $title }}</strong>
                            </p>

                            <div class="chart">

                                <canvas id="registrationsChart" height="180" style="height: 180px;"></canvas>
                            </div>

                        </div>
                        <div class="col-md-4">
                            {{-- <p class="text-center">
                                <strong>Registrations</strong>
                            </p>
                            @foreach ($registrationDetails as $detail)
                                <div class="progress-group">
                                    {{ $detail['activity_id'] }}
                                    <span class="float-right"><b>{{ $detail['count'] }}</b></span>
                                    <div class="progress progress-sm">
                                        @php
                                            $progressPercentage = ($detail['count'] / 100) * 100; // Assuming a maximum count of 200
                                        @endphp
                                        <div class="progress-bar bg-primary" style="width: {{ $progressPercentage }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach --}}
                            <p class="text-center">
                                <strong>Registration Details</strong>
                            </p>
                            <canvas id="registrationPieChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">IDR {{ number_format($total['paid_credit_card'], 2) }}</h5>
                                <span class="description-text text-success">TOTAL PAID (CREDIT CARD)</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">IDR {{ number_format($total['paid_bank_transfer'], 2) }}</h5>
                                <span class="description-text text-success">TOTAL PAID (BANK TRANSFER)</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block border-right">
                                <h5 class="description-header">IDR {{ number_format($total['pending'], 2) }}</h5>
                                <span class="description-text text-warning">TOTAL PENDING (PAY ON SITE)</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-6">
                            <div class="description-block">
                                <h5 class="description-header">IDR {{ number_format($total['total'], 2) }}</h5>
                                <span class="description-text text-info">EST. TOTAL REVENUE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Latest Registrations</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>email</th>
                                <th>Payment Method/Status</th>
                                <th>More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $registrationData = collect($registrations['all'])->sortByDesc('created_at');
                                // dd($registrationData);
                            @endphp
                            @foreach ($registrationData->take(5) as $reg)
                                <tr>
                                    {{-- @php
                                        dd($reg);
                                    @endphp --}}
                                    @if(is_array($reg))
                                        <td>{{ $reg['honorific'] }}. {{ $reg['name'] }}</td>
                                        <td><a href="mailto:{{$reg['email']}}">{{$reg['email']}}</a></td>
                                        <td>
                                            @if ($reg['payment_method'] == 'doku')
                                                <span class="badge bg-success">Credit Card/IPG</span>
                                            @elseif($reg['payment_method'] == 'transfer')
                                                <span class="badge bg-primary">Bank Transfer</span>
                                            @elseif($reg['payment_method'] == 'letter')
                                                <span class="badge bg-warning">Guarantee Letter</span>
                                            @else
                                                {{ $reg['payment_method'] }}
                                            @endif
                
                                            {{-- Fetch payment status --}}
                                            @php
                                                $payment = App\Models\Payment::where('registration_id', $reg['id'])->first();
                                                $paymentStatus = $payment ? $payment->status : 'N/A';
                                            @endphp
                
                                            {{-- Display payment status badge --}}
                                            @if ($paymentStatus == 'PAID')
                                                <span class="badge bg-success">{{ $paymentStatus }}</span>
                                            @elseif ($paymentStatus == 'PENDING')
                                                <span class="badge bg-warning">{{ $paymentStatus }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $paymentStatus }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $reg['id'] !== 0 ? route('registration_details', ['id' => Crypt::encrypt($reg['id'])]) : route('registration_details', ['id' => $reg['request_id']]) }}" class="btn btn-success {{ $reg['id'] === 0 ? 'disabled' : '' }}">
                                                <i class="fa fa-eye"></i>
                                            </a>    
                                            <a href="#" class="btn btn-info disabled">
                                                <i class="fa fa-hourglass"></i>
                                            </a>
                                        </td>
                                    @elseif (is_object($reg))
                                        <td>{{$reg->honorific}}. {{$reg->name}}</td>
                                        <td><a href="mailto:{{$reg->email}}">{{$reg->email}}</a></td>
                                        <td>
                                            @if ($reg->payment_method == 'doku')
                                                <span class="badge bg-success">Credit Card/IPG</span>
                                            @elseif($reg->payment_method == 'transfer')
                                                <span class="badge bg-primary">Bank Transfer</span>
                                            @elseif($reg->payment_method == 'letter')
                                                <span class="badge bg-warning">Guarantee Letter</span>
                                            @else
                                                {{ $reg->payment_method }}
                                            @endif
                
                                            {{-- Fetch payment status --}}
                                            @php
                                                $payment = App\Models\Payment::where('registration_id', $reg->id)->first();
                                                $paymentStatus = $payment ? $payment->status : 'N/A';
                                            @endphp
                
                                            {{-- Display payment status badge --}}
                                            @if ($paymentStatus == 'PAID')
                                                <span class="badge bg-success">{{ $paymentStatus }}</span>
                                            @elseif ($paymentStatus == 'PENDING')
                                                <span class="badge bg-warning">{{ $paymentStatus }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $paymentStatus }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ $reg->id !== 0 ? route('registration_details', ['id' => Crypt::encrypt($reg->id)]) : route('registration_details', ['id' => $reg->request_id]) }}" class="btn btn-success {{ $reg->id === 0 ? 'disabled' : '' }}">
                                                <i class="fa fa-eye"></i>
                                            </a>    
                                            @if ($reg->request_id && (isset($reg->payment_status) && $reg->payment_status != 'PAID'))
                                                <a href="{{ route('validate_payment_form', ['request_id' => $reg->request_id]) }}" class="btn btn-info {{ $reg->request_id === 0 ? 'disabled' : '' }}">
                                                    <i class="fa fa-hourglass"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('validate_payment_form', ['request_id' => $reg->request_id]) }}" class="btn btn-info {{ $reg->payment_method === 'letter' ? 'disabled' : '' }}">
                                                    <i class="fa fa-hourglass"></i>
                                                </a>  
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-success float-left">View Succesful Registrations</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Registrations</a>
                  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Recent Transaction Attempts</h3>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="products-list product-list-in-card">
                    @foreach ($paymentAttempts as $attempt)
                        @php
                            $attemptRegData = collect(json_decode($attempt->payload));
                            $name = strlen($attemptRegData['name']) > 20 ? substr($attemptRegData['name'], 0, 20) . '...' : $attemptRegData['name'];
                            $activityMapping = [
                                'local' => [
                                    'activity_1' => ['Day 1 Session-Inc. Opening Ceremony + TC Open Meeting - Local Participant', 2000000],
                                    'activity_2' => ['Day 1 Half Day Session - Local Participant', 1000000],
                                    'activity_3' => ['Day 2 Session - Local Participant', 2000000],
                                    'activity_4' => ['2 Days Package -include Opening Ceremony and TC Open Meeting- Local Participant', 3750000],
                                    'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Local Participant', 2600000],
                                    'activity_6' => ['2 days GDPMD -CDAKB- for Technical Responsible Person + Certificate by Ministry of Health Republic of Indonesia', 4000000],
                                    'activity_7' => ['Gala Dinner - Local Participant', 750000],
                                ],
                                'foreign' => [
                                    'activity_1' => ['Day 1 Session -Inc. Opening Ceremony + TC Open Meeting - Foreign Participant', 250 * 16300], // Multiply by 16300
                                    'activity_2' => ['Day 1 Half Day Session - Foreign Participant', 125 * 16300], // Multiply by 16300
                                    'activity_3' => ['Day 2 Session - Foreign Participant', 250 * 16300], // Multiply by 16300
                                    'activity_4' => ['2 Days Package -include Opening Ceremony and TC Open Meeting- Foreign Participant', 500 * 16300], // Multiply by 16300
                                    'activity_5' => ['Halal Awareness by IHATEC + Attendance certificate - Foreign Participant', 250 * 16300], // Multiply by 16300
                                    'activity_7' => ['Gala Dinner - Foreign Participant', 100 * 16300], // Multiply by 16300
                                ],
                            ];                 
                            // dd($attempt->payload);
                            $activities = [];
                            foreach ($attemptRegData as $key => $value) {
                                if (strpos($key, 'activity_') === 0 && $value !== null) {
                                    $activityId = str_replace('activity_', '', $key);
                                    $activityType = $value; // Get the activity type (foreign or local)
                                    $activity = $activityMapping[$activityType][$key]; // Get activity details based on activity type and activity key

                                    array_push($activities, strlen($activity[0]) > 30 ? substr($activity[0], 0, 30) . '...' : $activity[0]); 
                                }
                            }  
                        @endphp
                        <li class="item">
                            <div class="product-info" style="margin-left: 10px;">
                            <a href="mailto:{{$attemptRegData['email']}}" class="product-title">{{$name}}&nbsp;
                                <small>{{strlen($attemptRegData['email']) > 50 ? substr($attemptRegData['email'], 0, 50) . '...' : $attemptRegData['email'];}}</small>
                                <span class="float-right" style=" margin-right: 10px;">
                                    @if ($attempt->payment_method == 'doku')
                                        <span class="badge bg-success float-left">Credit Card/IPG</span>
                                    @elseif($attempt->payment_method == 'transfer')
                                        <span class="badge bg-primary float-left">Bank Transfer</span>
                                    @elseif($attempt->payment_method == 'letter')
                                        <span class="badge bg-warning float-left">Guarantee Letter</span>
                                    @else
                                        {{ $attempt->payment_method }}
                                    @endif
                                    @if ($attempt['status'] == 'PAID')
                                        <span class="badge bg-success float-right">{{ $attempt['status'] }}</span>
                                    @elseif ($attempt['status'] == 'PENDING')
                                        <span class="badge bg-danger float-right">{{ $attempt['status'] }}</span>
                                    @else
                                        <span class="badge bg-danger float-right">{{ $attempt['status'] }}</span>
                                    @endif
                                    <br>
                                    <span class="badge badge-warning float-right">{{ formatShortenedRupiah($attemptRegData['total']) }}</span>
                                </span>
                            </a>
                            <span class="product-description">
                                <ol>
                                    @foreach ($activities as $activity)
                                       <li>{{$activity}}</li> 
                                    @endforeach
                                </ol>
                            </span>
                            </div>
                        </li>
                    @endforeach
                  </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  {{-- <a href="javascript:void(0)" class="uppercase">View All Products</a> --}}
                </div>
                <!-- /.card-footer -->
              </div>
        </div>
    </div>
    <script>
        $(function() {
            'use strict'

            var registrationsChartCanvas = $('#registrationsChart').get(0).getContext('2d');

            // Extracting data from the payload
            var successData = {!! json_encode($registrations['success']) !!};
            var pendingData = {!! json_encode($registrations['pending']) !!};
            var allData = {!! json_encode($registrations['all']) !!};

            // Function to count entries per week
            function getCountPerWeek(data) {
                var countPerWeek = {};
                var labelsPerWeek = {};
                data.forEach(function(entry) {
                    var week = moment(entry.created_at).isoWeek();
                    var monthAbbreviation = moment(entry.created_at).format('MMM');
                    var label = monthAbbreviation + ' - Week ' + week;
                    if (countPerWeek.hasOwnProperty(week)) {
                        countPerWeek[week]++;
                    } else {
                        countPerWeek[week] = 1;
                        labelsPerWeek[week] = label;
                    }
                });
                return {
                    counts: countPerWeek,
                    labels: labelsPerWeek
                };
            }

            // Count entries per week for each dataset
            var successCountPerWeek = getCountPerWeek(successData);
            var pendingCountPerWeek = getCountPerWeek(pendingData);
            var allCountPerWeek = getCountPerWeek(allData);

            // Building the chart data
            var registrationsChartData = {
                labels: Object.values(successCountPerWeek.labels),
                datasets: [{
                        label: 'Success',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: Object.values(successCountPerWeek.counts)
                    },
                    {
                        label: 'Pending',
                        backgroundColor: 'rgba(255, 193, 7, 0.9)',
                        borderColor: 'rgba(255, 193, 7, 0.8)',
                        pointRadius: false,
                        pointColor: '#ffc107',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220, 220, 220, 1)',
                        data: Object.values(pendingCountPerWeek.counts)
                    },
                    {
                        label: 'All',
                        backgroundColor: '#00a65a',
                        borderColor: '#00a65a',
                        pointRadius: false,
                        pointColor: '#00a65a',
                        pointStrokeColor: '#00c0ef',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: '#00c0ef',
                        data: Object.values(allCountPerWeek.counts)
                    }
                ]
            };

            var registrationsChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            };

            var registrationsChart = new Chart(registrationsChartCanvas, {
                type: 'bar',
                data: registrationsChartData,
                options: registrationsChartOptions
            });

            // console.log('{!! json_encode($aggregatedDataJson) !!}');
            var registrationDetails = {!! $aggregatedDataJson !!};

            // Extract activity IDs, counts, and generate random colors
            var activityIds = [];
            var counts = [];
            var colors = [];
            var colorPallette = [
                '#2196F3', // Blue
                '#4CAF50', // Green
                '#FF5722', // Deep Orange
                '#FFC107', // Amber
                '#673AB7', // Deep Purple
                '#009688', // Teal
                '#FF9800', // Orange
                '#795548', // Brown
                '#E91E63', // Pink
                '#00BCD4', // Cyan
                '#8BC34A', // Light Green
                '#CDDC39', // Lime
                '#FFEB3B', // Yellow
                '#9C27B0', // Purple
                '#03A9F4', // Light Blue
                '#FF5252', // Red
                '#607D8B', // Blue Grey
            ];

            // Define an index variable to cycle through the colors
            var colorIndex = 0;

            registrationDetails.forEach(function(detail) {
                activityIds.push(detail.desc);
                counts.push(detail.count);
                // Use predefined colors for each item
                var color = colorPallette[colorIndex];
                colors.push(color);
                // Increment the color index, cycling through the predefined colors
                colorIndex = (colorIndex + 1) % colorPallette.length;
            });

            // Prepare data for the pie chart
            var pieChartData = {
                labels: activityIds,
                datasets: [{
                    data: counts,
                    backgroundColor: colors,
                }]
            };

            // Define options for the pie chart
            var pieChartOptions = {
                maintainAspectRatio: false,
                responsive: false,
                legend: {
                    display: false
                },
            };

            // Get the canvas element for the pie chart
            var registrationPieChartCanvas = $('#registrationPieChart').get(0).getContext('2d');

            // Create the pie chart
            var registrationPieChart = new Chart(registrationPieChartCanvas, {
                type: 'pie',
                data: pieChartData,
                options: pieChartOptions
            });
        });
    </script>
@endsection
