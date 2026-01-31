<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateStatusPemesanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pemesanan:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status pemesanan menjadi selesai jika tanggal keluar sudah lewat';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $updated = Pemesanan::where('status_pemesanan', 'dikonfirmasi')
            ->whereDate('tanggal_keluar', '<', $today)
            ->update(['status_pemesanan' => 'selesai']);

        $this->info("Berhasil update {$updated} pemesanan menjadi selesai.");

        return Command::SUCCESS;
    }
}
