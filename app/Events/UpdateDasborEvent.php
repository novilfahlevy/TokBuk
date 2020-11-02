<?php

namespace App\Events;

use App\PembelianBuku;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateDasborEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jumlahTransaksi;
    public $chart;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $now = Carbon::now();

        $label = collect(range(1, $now->daysInMonth))->map(function($day) {
            return 'Hari ke-' . $day;
        });

        $pendapatan = Transaksi::where(DB::raw('MONTH(created_at)'), $now->month)
            ->select(DB::raw('SUM(total_harga) AS total_harga'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // $pengeluaran = PembelianBuku::where(DB::raw('MONTH(created_at)'), $now->month)
        //     ->select(DB::raw('SUM(harga_jual * jumlah) AS total_harga'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get();

        $this->jumlahTransaksi = Transaksi::count();
        $this->chart = [
            'bulan' => $now->monthName,
            'label' => $label,
            'pendapatan' => $pendapatan,
            'pengeluaran' => []
            // 'pengeluaran' => $pengeluaran
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['dasbor'];
    }

    public function broadcastAs()
    {
        return 'dasbor.update';
    }
}
