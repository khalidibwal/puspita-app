<div class="container mx-auto py-8">
    <div class="bg-gray-900 shadow-md rounded-lg p-10">
        <h1 class="text-3xl font-bold text-white mb-6">Antrian Online</h1>
        <div class="antrian-display text-center py-6">
            <strong id="no_antrian" class="text-8xl text-blue-400">
                {{ $currentAntrian ? $currentAntrian->no_antrian : 'Tidak ada antrian saat ini.' }}
            </strong>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let lastAntrian = '{{ $currentAntrian ? $currentAntrian->no_antrian : '' }}';

    // Poll the server every 2 seconds for new antrian data
    setInterval(function() {
        $.ajax({
            url: '{{ route('fetch.antrian') }}', // Fetch route for current antrian
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
        font-size: 3rem; /* Increased font size */
        text-align: center;
    }
</style>
