<x-live-antrian>
    <div class="container">
        <div style="background-color: white; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 40px; width: 30%; height: 30%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h1 style="font-size: 2.5rem; font-weight: bold; color: #4A5568; margin-bottom: 1.5rem;">Antrian Online</h1>
            <div class="antrian-display" style="text-align: center; padding: 1.5rem;">
                <strong id="no_antrian" style="font-size: 6rem; color: #3B82F6;">
                    {{ $currentAntrian ? $currentAntrian->no_antrian : 'Tidak ada antrian saat ini.' }}
                </strong>
            </div>
        </div>

        <div style="background-color: white; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 40px; width: 30%; height: 30%; display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 10px;">
            <h1 style="font-size: 2.5rem; font-weight: bold; color: #4A5568; margin-bottom: 1.5rem;">Antrian Offline</h1>
            <div class="antrian-display" style="text-align: center; padding: 1.5rem;">
                <strong id="no_antrian_offline" style="font-size: 6rem; color: #3B82F6;">
                    {{ $currentOfflineAntrian ? $currentOfflineAntrian->no_antrian : 'Tidak ada antrian saat ini.' }}
                </strong>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let lastAntrian = '{{ $currentAntrian ? $currentAntrian->no_antrian : '' }}';
        let lastOfflineAntrian = '{{ $currentOfflineAntrian ? $currentOfflineAntrian->no_antrian : '' }}';

        // Poll the server every 2 seconds for new antrian data
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
                            $('#no_antrian').text('Tidak ada antrian saat ini.');
                            lastAntrian = '';
                        }
                    }

                    // For offline antrian
                    if (response.currentOfflineAntrian) {
                        if (response.currentOfflineAntrian.no_antrian !== lastOfflineAntrian) {
                            lastOfflineAntrian = response.currentOfflineAntrian.no_antrian;
                            $('#no_antrian_offline').text(lastOfflineAntrian);
                        }
                    } else {
                        if (lastOfflineAntrian !== '') {
                            $('#no_antrian_offline').text('Tidak ada antrian saat ini.');
                            lastOfflineAntrian = '';
                        }
                    }
                },
                error: function() {
                    console.error('Failed to fetch antrian data.');
                }
            });
        }, 2000);
    </script>

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .antrian-display {
            font-size: 4rem;
            text-align: center;
        }
    </style>
</x-live-antrian>
