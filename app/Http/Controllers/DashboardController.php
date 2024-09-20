<?php

namespace App\Http\Controllers;

use App\Models\Produksi;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah produksi yang dibuat hari ini
        $produksiToday = Produksi::whereDate('waktu', Carbon::today())->sum('Qty');

        // Menghitung jumlah delivery yang dilakukan hari ini
        $deliveryToday = Delivery::whereDate('scandate', today())->count();

        // Mendapatkan data ikhtisar dalam rentang hari tertentu
        $ikhtisarDays = $request->input('days', 30); // default 30 days if no input
        $startDate = now()->subDays($ikhtisarDays);
        $endDate = now();

        // Data kategori untuk sumbu X
        $ikhtisarCategories = [];
        for ($i = $ikhtisarDays - 1; $i >= 0; $i--) {
            $ikhtisarCategories[] = now()->subDays($i)->format('d M Y'); // Format sesuai kebutuhan
        }

        // Data produksi bulan ini dan bulan lalu
        $currentMonth = date('m');
        $lastMonth = date('m', strtotime('-1 month'));
        $currentYear = date('Y');
        $lastYear = date('Y', strtotime('-1 month'));

        $produksiThisMonth = Produksi::whereYear('waktu', $currentYear)
            ->whereMonth('waktu', $currentMonth)
            ->sum('Qty');

        $produksiLastMonth = Produksi::whereYear('waktu', $lastYear)
            ->whereMonth('waktu', $lastMonth)
            ->sum('Qty');

        // Hitung persentase kenaikan
        $persentaseKenaikan = $produksiLastMonth > 0
            ? (($produksiThisMonth - $produksiLastMonth) / $produksiLastMonth) * 100
            : 0;

        // Menghitung data delivery bulanan untuk 4 bulan terakhir
        $deliveryCounts = $this->getMonthlyDeliveryCounts($currentMonth, $currentYear);

        // Menghitung jumlah delivery bulan ini
        $deliveryThisMonth = Delivery::whereYear('scandate', $currentYear)
            ->whereMonth('scandate', $currentMonth)
            ->count();

        // Menghitung jumlah delivery bulan lalu
        $deliveryLastMonth = Delivery::whereYear('scandate', $lastYear)
            ->whereMonth('scandate', $lastMonth)
            ->count();

        // Hitung persentase kenaikan delivery
        $persentaseKenaikandelivery = $deliveryLastMonth > 0
            ? (($deliveryThisMonth - $deliveryLastMonth) / $deliveryLastMonth) * 100
            : 0;

        // Menghitung data delivery mingguan bulan ini
        $weeklyDeliveryData = $this->getWeeklyDeliveryCounts($currentMonth, $currentYear);

        // Data yang akan dikirimkan ke tampilan
        $data = compact(
            'produksiToday',
            'deliveryToday',
            'ikhtisarDays',
            'produksiThisMonth',
            'produksiLastMonth',
            'persentaseKenaikan',
            'deliveryCounts',
            'persentaseKenaikandelivery',
            'ikhtisarCategories',
            'weeklyDeliveryData'
        );

        return view('dashboard', $data);
    }

    // Fungsi untuk menghitung jumlah delivery bulanan untuk 4 bulan terakhir
    private function getMonthlyDeliveryCounts($currentMonth, $currentYear)
    {
        $deliveryData = [];
        for ($i = 0; $i < 4; $i++) {
            $month = $currentMonth - $i;
            $year = $currentYear;

            if ($month <= 0) {
                $month += 12; // Jika bulan kurang dari 1, tambahkan 12
                $year -= 1; // Kurangi tahun
            }

            $deliveryCount = Delivery::whereYear('scandate', $year)
                ->whereMonth('scandate', $month)->count();

            $deliveryData[] = $deliveryCount;
        }

        return array_reverse($deliveryData);
    }

    // Fungsi untuk menghitung jumlah delivery mingguan bulan ini
    private function getWeeklyDeliveryCounts($currentMonth, $currentYear)
    {
        $weeklyData = [0, 0, 0, 0]; // Initialize array for 4 weeks

        for ($i = 0; $i < 4; $i++) {
            $weekStart = Carbon::create($currentYear, $currentMonth, 1)->startOfWeek()->addWeeks($i);
            $weekEnd = $weekStart->copy()->endOfWeek();

            $weeklyData[$i] = Delivery::whereBetween('scandate', [$weekStart, $weekEnd])->count();
        }

        return $weeklyData;
    }
}
