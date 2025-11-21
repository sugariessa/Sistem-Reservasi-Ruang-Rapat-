Berikut adalah skema database yang digunakan pada aplikasi Reservasi Ruang Rapat.  
Database ini dirancang untuk memastikan proses reservasi berjalan aman, mencegah bentrok jadwal, dan mendukung role Admin serta User.

1. Tabel: users
Menyimpan semua data pengguna aplikasi.
| Field | Type | Keterangan |
|-------|------|-----------|
| id | BIGINT UNSIGNED | Primary Key |
| name | VARCHAR(255) | Nama user |
| email | VARCHAR(255) | Unik |
| email_verified_at | TIMESTAMP | Nullable |
| password | VARCHAR(255) | Password terenkripsi |
| role | ENUM('admin','user') | Role aplikasi |
| remember_token | VARCHAR(100) | Token login |
| created_at | TIMESTAMP | Timestamp |
| updated_at | TIMESTAMP | Timestamp |

Relasi:  
`users (1)` → `(N) reservations`

2. Tabel: rooms
Menyimpan daftar ruang rapat yang tersedia.
| Field | Type | Keterangan |
|-------|------|-----------|
| id | BIGINT UNSIGNED | Primary Key |
| nama | VARCHAR(255) | Nama ruang |
| kapasitas | INT | Kapasitas orang |
| lokasi | VARCHAR(255) | Lokasi ruang |
| deskripsi | TEXT | Informasi tambahan |
| status | ENUM('aktif', 'tidak aktif') | Status ruang |
| created_at | TIMESTAMP | Timestamp |
| updated_at | TIMESTAMP | Timestamp |

Relasi:  
`rooms (1)` → `(N) reservations`

3. Tabel: reservations
Menyimpan semua data pemesanan ruang rapat.
| Field | Type | Keterangan |
|--------|------|-----------|
| id | BIGINT UNSIGNED | Primary Key |
| user_id | BIGINT UNSIGNED | FK → users.id |
| room_id | BIGINT UNSIGNED | FK → rooms.id |
| date | DATE | Tanggal reservasi |
| start_time | TIME | Jam mulai |
| end_time | TIME | Jam selesai |
| keperluan | VARCHAR(255) | Keperluan rapat |
| status | ENUM('menunggu','diterima','ditolak','dibatalkan') | Status reservasi |
| created_at | TIMESTAMP | Timestamp |
| updated_at | TIMESTAMP | Timestamp |

Relasi:  
- `reservations.user_id` → `users.id`  
- `reservations.room_id` → `rooms.id`

4. Tabel: schedules
Digunakan untuk menentukan hari kerja & jam kerja sistem.
| Field | Type | Keterangan |
|--------|------|-----------|
| id | BIGINT UNSIGNED | Primary Key |
| jam_mulai | TIME | Jam kerja dimulai |
| jam_selesai | TIME | Jam kerja berakhir |
| hari_kerja | JSON | Daftar hari kerja |
| created_at | TIMESTAMP | Timestamp |
| updated_at | TIMESTAMP | Timestamp |
