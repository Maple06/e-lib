@extends('layouts.app')

@section('title', 'Dasbor')

@section('page-header')
<div class="row">
    <div class="col-12">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dasbor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><i class="nav-icon fas fa-tachometer-alt mr-1"></i>Dasbor</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-4">
                <div class="form-group">
                    <div class="input-group date" id="datepicker" data-target-input="nearest">
                        <input type="hidden" id="datepickerValue" name="datepickerValue"> <!-- Hidden input for original value -->
                        <input type="text" class="form-control datetimepicker-input" id="datepickerInput" data-target="#datepicker"> <!-- Visible input for label -->
                        <div class="input-group-append" data-target="#datepicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group float-right">
                    <input type="hidden" id="datepickerValue" value="">
                    <a href="#" id="exportButton" class="btn btn-primary">
                        <i class="fas fa-file-export mr-1"></i>Export Data
                    </a>
                </div>
            </div>
        </div>
    </div>

    @php
        $first_row = [
            [
                "id" => "total-buku",
                "name" => "Total Buku",
                "icon" => "book",
                "color" => "#00a0b4"
            ],
            [
                "id" => "buku-disewa",
                "name" => "Buku Disewa",
                "icon" => "learn",
                "color" => "#00a0b4"
            ],
            [
                "id" => "buku-telat",
                "name" => "Buku Telat Kembali",
                "icon" => "calendar-cancel",
                "color" => "#00a0b4"
            ],
            [
                "id" => "anggota",
                "name" => "Total Anggota",
                "icon" => "users",
                "color" => "#00a0b4"
            ]
        ]
    @endphp
    <div class="container">
        <div class="row">
            @foreach ($first_row as $row)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="row m-2">
                            <div class="col-3 p-0 d-flex align-items-center">
                                <div class="d-flex justify-content-center align-items-center p-3 rounded" style="background-color:{{ $row['color'] }};">
                                    <i class="fas fa-{{ $row['icon'] }}" style="height: 15px; width: 15px"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col" style="font-size:15px">
                                        {{ $row['name'] }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex align-items-center">
                                        <div class="mr-2" style="font-size: 15px; font-weight: bold;" id="number-{{$row['id']}}">530</div>
                                        <div class="d-flex text-success justify-content-center align-items-center h-75 px-2" id="{{$row['id']}}" style="background-color: #85ba91ba; border-radius: 30px;">
                                            <svg class="mr-1" width="10px" fill="#28a745" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                {{-- Trend Down --}} {{-- <path d="M384 352c-17.7 0-32 14.3-32 32s14.3 32 32 32l160 0c17.7 0 32-14.3 32-32l0-160c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 82.7L342.6 137.4c-12.5-12.5-32.8-12.5-45.3 0L192 242.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0L320 205.3 466.7 352 384 352z"/> --}}
                                                {{-- Trend Up --}} <path d="M384 160c-17.7 0-32-14.3-32-32s14.3-32 32-32l160 0c17.7 0 32 14.3 32 32l0 160c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-82.7L342.6 374.6c-12.5 12.5-32.8 12.5-45.3 0L192 269.3 54.6 406.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160c12.5-12.5 32.8-12.5 45.3 0L320 306.7 466.7 160 384 160z"/>
                                            </svg>
                                            <p class="m-0" style="font-size: 11px;">20% (+98)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="card">
                    <div class="text-center my-5" id="kategoriBukuLoader">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                    <div class="card-body" id="kategoriBukuContainer">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="row d-flex flex-column">
                    <div class="card">
                        <div class="text-center my-5" id="kategoriPopulerLoader">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="card-body" id="kategoriPopulerContainer">
                        </div>
                    </div>
                    <div class="card">
                        <div class="text-center my-5" id="statusBukuLoader">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="card-body" id="statusBukuContainer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

        <div class="col-12">
            <div class="card">
                <div class="text-center my-5" id="lineChartLoader">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
                <div class="card-body" id="lineChartContainer">
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body" id="barChartContainer">
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body" id="pieChartContainer">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dataPointModal" tabindex="-1" role="dialog" aria-labelledby="dataPointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataPointModalLabel">Detail Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
    .datepicker-days .datepicker-switch {
        text-align: center;
    }
</style>
@endsection

@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        // Function to get relative month labels
        function getRelativeMonthLabel(date) {
            const currentDate = new Date();
            const monthsDifference = (currentDate.getFullYear() - date.getFullYear()) * 12 + (currentDate.getMonth() - date.getMonth());
    
            if (monthsDifference === 0) return "Bulan Ini";
            if (monthsDifference === 1) return "1 Bulan Lalu";
            if (monthsDifference < 12) return `${monthsDifference} Bulan Lalu`;
    
            const years = Math.floor(monthsDifference / 12);
            const months = monthsDifference % 12;
            let label = `${years} Tahun`;
    
            if (months > 0) label += ` ${months} Bulan Lalu`;
            else label += " Lalu";
    
            return label;
        }

        // Function to format date as MM-YYYY
        function formatDateAsMMYYYY(date) {
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Add leading zero if necessary
            const year = date.getFullYear();
            return `${month}-${year}`;
        }
    
        // Initialize the datepicker
        $('#datepicker').datepicker({
            format: 'mm-yyyy',
            startView: 1,
            minViewMode: 1,
            autoclose: true
        }).datepicker('setDate', new Date()); // Set default to this month
    
        // Update the input fields with the relative month label and original value
        function updateInputWithLabel() {
            const date = $('#datepicker').datepicker('getDate');
            const relativeLabel = getRelativeMonthLabel(date);
            const originalValue = formatDateAsMMYYYY(date);
            
            setTimeout(function() {
                $('#datepickerInput').val(relativeLabel);  // Force re-update after a short delay
                $('#datepickerValue').val(originalValue); // Set the original value in the hidden input
            }, 10);
        }
    
        // Set initial label
        updateInputWithLabel();
    
        // Update the label on date change
        $('#datepicker').on('changeDate', function() {
            updateInputWithLabel();
        });
    });
</script>

<script>
    $(document).ready(function() {
        function updateExportLink() {
            const dateValue = $('#datepickerValue').val();  // Get the value from the hidden input
            if (dateValue) {  // Check if the dateValue is not empty
                const exportUrl = "{{ route('dashboard.export', ':date') }}".replace(':date', dateValue);
                $('#exportButton').attr('href', exportUrl);
            }
        }

        // Update the hidden input and export link whenever the date changes
        $('#datepicker').on('changeDate', function() {
            const date = $('#datepicker').datepicker('getFormattedDate', 'mm-yyyy');
            $('#datepickerValue').val(date);  // Update the hidden input with the date
            updateExportLink();  // Update the export link with the new date
        });

        // Initial update when the page loads
        updateExportLink();
    });
</script>

<script>
$(document).ready(function() {
    function handleError(containerId, error) {
        console.error('AJAX Error: ', error);
        $(`#${containerId}`).html('<p class="text-danger">Failed to load data</p>');
    }

    // Show loader
    $('#kategoriBukuLoader').show();
    $('#kategoriPopulerLoader').show();
    $('#statusBukuLoader').show();

    // AJAX request to fetch data for book categories chart
    $.ajax({
        url: "{{ route('dashboard.data.book_categories') }}",
        method: 'GET',
        success: function(response) {
            // Create chart
            createDonutChart('kategoriBukuContainer', 'Kategori Buku', response, 'Jumlah Buku');
            
            // Hide loader
            $('#kategoriBukuLoader').hide();
        },
        error: function(xhr, status, error) {
            handleError('kategoriBukuContainer', error);
            // Hide loader in case of error
            $('#kategoriBukuLoader').hide();
        }
    });

    // AJAX request to fetch data for popular categories chart
    $.ajax({
        url: "{{ route('dashboard.data.popular_categories') }}",
        method: 'GET',
        success: function(response) {
            // Create chart
            createLineRaceChart('kategoriPopulerContainer', 'Kategori Populer', response.categories, response.data, 'Jumlah Populer');
            
            // Hide loader
            $('#kategoriPopulerLoader').hide();
        },
        error: function(xhr, status, error) {
            handleError('kategoriPopulerContainer', error);
            // Hide loader in case of error
            $('#kategoriPopulerLoader').hide();
        }
    });

    // AJAX request to fetch data for book statuses chart
    $.ajax({
        url: "{{ route('dashboard.data.book_statuses') }}",
        method: 'GET',
        success: function(response) {
            console.log(response);
            // Create chart
            createDonutChart('statusBukuContainer', 'Status Buku', response, 'Jumlah Buku', true);
            createDonutChart2('statusBukuContainer', 'Status Buku', response, 'Jumlah Buku', true);
            
            // Hide loader
            $('#statusBukuLoader').hide();
        },
        error: function(xhr, status, error) {
            console.log('XHR:', xhr);
            console.log('Status:', status);
            console.log('Error:', error);
            handleError('statusBukuContainer', error);
            // Hide loader in case of error
            $('#statusBukuLoader').hide();
        }
    });
});

function createDonutChart2(container, title, data, unit) {
    Highcharts.chart(container, {
        chart: {
            type: 'pie'
        },
        title: {
            text: title
        },
        series: [{
            name: unit,
            data: data
        }]
    });
}

function createDonutChart(container, title, data, unit, custom) {
    let chartParams = {
        chart: {
            type: 'pie',
            events: {
                render() {
                    const chart = this,
                        series = chart.series[0];
                }
            }
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        title: {
            text: title,
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.0f}%)'
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: [{
                    enabled: true,
                    distance: 1,
                    format: '{point.name}'
                }, {
                    enabled: true,
                    distance: -15,
                    format: '{point.percentage:.0f}%',
                    style: {
                        fontSize: '0.9em'
                    }
                }],
                showInLegend: true
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: unit,
            colorByPoint: true,
            innerSize: '60%',
            data: data
        }]
    };

    if (custom) {
        chartParams['legend'] = {
            align: 'left',
            layout: 'vertical',
        };

        chartParams['plotOptions']['pie'] = {
            dataLabels: {
                enabled: true,
                distance: -50,
                useHTML: true,
                format: `
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-size: 16px; font-weight: bold;">50%</span>
                        <span>Tersedia</span>
                    </div>`,
                },
            borderWidth: 3
        };
    }

    Highcharts.chart(container, chartParams);
}

function createLineRaceChart(container, title, categories, data, unit) {
    Highcharts.chart(container, {
        chart: {
            type: 'bar',
            height: '70%'
        },
        title: {
            text: title,
            align: 'left'
        },
        xAxis: {
            dataLabels: {
            align: 'left',
            },
            categories: categories,
            title: {
                text: null
            },
            gridLineWidth: 0,
            lineWidth: 0,
            labels: {
                align: 'left',
                reserveSpace: true
            }
        },
        yAxis: {
            title: {
                text: null
            },
            min: 0,
            gridLineWidth: 0,
            labels: {
                enabled: false
            }
        },
        plotOptions: {
            bar: {
                borderRadius: '50%',
                dataLabels: {
                    enabled: true
                },
                pointPadding: 0,
                groupPadding: 0,
                pointWidth: 25
            }
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        series: [{
            name: unit,
            data: data
        }]
    });
}
</script>

<script>
$(document).ready(function() {
    // Show loader
    $('#lineChartLoader').show();

    // AJAX request to fetch data for line chart
    $.ajax({
        url: "{{ route('dashboard.data.books_by_month') }}",
        method: 'GET',
        success: function(response) {
            const borrowings = response.borrowings;
            const borrowMonths = response.months;

            // Create line chart
            createLineChart2('lineChartContainer', 'Jumlah Peminjaman Buku Per Bulan', borrowMonths, borrowings);

            // Hide loader
            $('#lineChartLoader').hide();
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', error);
            // Hide loader in case of error
            $('#lineChartLoader').hide();
        }
    });
});

function createLineChart2(container, title, categories, data) {
    Highcharts.chart(container, {
        chart: {
            type: 'line'
        },
        title: {
            text: title
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            title: {
                text: 'Jumlah Peminjaman'
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Peminjaman',
            data: data,
            point: {
                events: {
                    click: function() {
                        // Set modal content
                        $('#modalContent').text('Bulan: ' + this.category + ', Jumlah: ' + this.y);
                        // Show modal
                        $('#dataPointModal').modal('show');
                    }
                }
            }
        }],
        tooltip: {
            formatter: function() {
                return 'Bulan: ' + this.x + '<br>Jumlah: ' + this.y;
            }
        },
        exporting: {
            enabled: true // Enable export feature
        },
        accessibility: {
            enabled: true,
            description: 'Line chart showing the number of book borrowings per month. The data shows a varying trend over the months.',
            point: {
                valueDescriptionFormat: '{index}. {xDescription}, {value}.'
            }
        }
    });
}
</script>

<script>
// Dummy chart data
$(document).ready(function() {
    Highcharts.chart('barChartContainer', {
        chart: {
            type: 'bar' // Specify chart type as bar
        },
        title: {
            text: 'Jumlah Buku yang Dipinjam per Kategori' // Chart title
        },
        xAxis: {
            categories: ['Fiksi', 'Non-Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Sosial'] // X-axis categories
        },
        yAxis: {
            title: {
                text: 'Jumlah Buku' // Y-axis title
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Kategori',
            data: [120, 80, 150, 90, 60, 100] // Data series
        }]
    });

    Highcharts.chart('pieChartContainer', {
        chart: {
            type: 'pie' // Specify chart type as pie
        },
        title: {
            text: 'Distribusi Anggota Berdasarkan Tipe Keanggotaan' // Chart title
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' // Tooltip format
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %' // Data labels format
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Anggota',
            colorByPoint: true,
            data: [{
                name: 'Mahasiswa',
                y: 25.0,
                sliced: true,
                selected: true
            }, {
                name: 'Guru',
                y: 15.0
            }, {
                name: 'Dosen',
                y: 10.0
            }, {
                name: 'Umum',
                y: 22.0
            }, {
                name: 'Pelajar',
                y: 28.0
            }]
        }]
    });
});
</script>
@endsection