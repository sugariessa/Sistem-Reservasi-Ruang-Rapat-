Aplikasi ini menerapkan beberapa lapisan validasi untuk memastikan tidak terjadi bentrok (double booking) pada reservasi ruang rapat.
Berikut adalah alur logika lengkap yang digunakan dalam proses penyimpanan reservasi:

**Validasi Input Dasar**
Sebelum proses pengecekan jadwal, sistem memvalidasi:
- ruang yang dipilih harus ada (room_id)
- tanggal harus valid dan tidak boleh sebelum hari ini
- jam mulai dan jam selesai harus benar
- keperluan harus diisi
  
$request->validate([
    'room_id' => 'required|exists:rooms,id',
    'date' => 'required|date|after_or_equal:today',
    'start_time' => 'required',
    'end_time' => 'required|after:start_time',
    'keperluan' => 'required|string'
]);

**Validasi Jam Reservasi untuk Hari Ini**
Jika user melakukan reservasi di hari yang sama, sistem akan memastikan: jam mulai tidak boleh kurang dari atau sama dengan waktu sekarang

if ($request->date === date('Y-m-d')) {
    $currentTime = date('H:i');
    if ($request->start_time <= $currentTime) {
        return back()->with('error', 'Tidak dapat membuat reservasi untuk jam yang sudah terlewat.');
    }
}

**Validasi Hari Kerja Sesuai Jadwal Sistem**
Sistem memiliki tabel schedules untuk menentukan hari kerja.
Jika user memilih tanggal di luar hari kerja, reservasi otomatis ditolak.

if (!in_array($dayMapping[$dayName], $schedule->hari_kerja)) {
    return back()->with('error', 'Reservasi tidak dapat dilakukan pada hari ' . $dayName);
}

**Validasi Jam Kerja Sesuai Konfigurasi**
Sistem memastikan reservasi berada di dalam batas jam kerja:
- Tidak boleh sebelum jam_mulai
- Tidak boleh melewati jam_selesai
  
if ($request->start_time < $schedule->jam_mulai || $request->end_time > $schedule->jam_selesai) {
    return back()->with('error', 'Jam reservasi harus dalam rentang jam kerja.');
}

**Validasi Bentrok (Overlap) dengan Reservasi Lain**
Inilah inti logika anti konflik. Sistem melakukan pengecekan apakah ada reservasi lain di ruangan yang sama, tanggal yang sama, dan dengan jam yang saling bertumpukan.
Reservasi dianggap bentrok jika:

  start_time < reservasi_lain.end_time
  AND
  end_time > reservasi_lain.start_time
  
Dengan status yang masih aktif:
- menunggu
- diterima

Kode pengecekannya:

$conflict = Reservation::where('room_id', $request->room_id)
    ->where('date', $request->date)
    ->whereIn('status', ['menunggu', 'diterima'])
    ->where(function ($query) use ($request) {
        $query->where('start_time', '<', $request->end_time)
              ->where('end_time', '>', $request->start_time);
    })
    ->exists();

Jika ditemukan konflik:

return back()->with('error', 'Jadwal bentrok. Silakan pilih waktu lain.');

**Reservasi Disimpan Jika Semua Valid**
Jika semua pengecekan lolos, sistem menyimpan data dengan status awal reservasi adalah menunggu persetujuan admin.

Reservation::create([
    'user_id' => auth()->id(),
    'room_id' => $request->room_id,
    'keperluan' => $request->keperluan,
    'date' => $request->date,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'status' => 'menunggu'
]);

Dengan alur ini, sistem memastikan tidak ada reservasi yang beririsan, sehingga semua pengguna mendapatkan jadwal ruang rapat yang aman dan teratur.
