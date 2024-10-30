<x-live-antrian>
    <div class="container">
        <div class="card">
            <h1 class="title">Antrian Online</h1>
            <div class="antrian-display">
                <strong id="no_antrian">
                    {{ $currentAntrian ? $currentAntrian->no_antrian : 'Tidak ada antrian.' }}
                </strong>
            </div>
        </div>

        <div class="card offline">
            <h1 class="title">Antrian Offline</h1>
            <div class="antrian-display">
                <strong id="no_antrian_offline">
                    {{ $currentOfflineAntrian ? $currentOfflineAntrian->no_antrian : 'Tidak ada antrian.' }}
                </strong>
            </div>
        </div>
        <a href="{{route('admin.index')}}" class='backtohome'>Kembali Ke laman Utama</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let lastAntrian = '{{ $currentAntrian ? $currentAntrian->no_antrian : '' }}';
        let lastOfflineAntrian = '{{ $currentOfflineAntrian ? $currentOfflineAntrian->no_antrian : '' }}';

        setInterval(function() {
            $.ajax({
                url: '{{ route('fetch.antrian') }}',
                method: 'GET',
                success: function(response) {
                    if (response.currentAntrian) {
                        if (response.currentAntrian.no_antrian !== lastAntrian) {
                            lastAntrian = response.currentAntrian.no_antrian;
                            $('#no_antrian').text(lastAntrian);
                        }
                    } else {
                        if (lastAntrian !== '') {
                            $('#no_antrian').text('Tidak ada antrian.');
                            lastAntrian = '';
                        }
                    }

                    if (response.currentOfflineAntrian) {
                        if (response.currentOfflineAntrian.no_antrian !== lastOfflineAntrian) {
                            lastOfflineAntrian = response.currentOfflineAntrian.no_antrian;
                            $('#no_antrian_offline').text(lastOfflineAntrian);
                        }
                    } else {
                        if (lastOfflineAntrian !== '') {
                            $('#no_antrian_offline').text('Tidak ada antrian.');
                            lastOfflineAntrian = '';
                        }
                    }
                },
                error: function() {
                    console.error('Failed to fetch antrian data.');
                }
            });
        }, 5000);
    </script>

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            gap: 20px;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right:20px
        }

        .title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #4A5568;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .antrian-display {
            text-align: center;
            padding: 1.5rem;
        }

        #no_antrian,
        #no_antrian_offline {
            font-size: 5rem;
            color: #3B82F6;
        }

        .offline #no_antrian_offline {
            font-size: 5rem;
        }
        a{
            font-size: 1rem;
            color: #3B82F6;
            text-align:'center'
        }
    </style>
</x-live-antrian>
