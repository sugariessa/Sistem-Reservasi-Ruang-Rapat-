<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'nama' => 'Ruang Meeting A',
                'kapasitas' => 10,
                'lokasi' => 'Lantai 1',
                'deskripsi' => 'Proyektor, AC, Whiteboard, WiFi'
            ],
            [
                'nama' => 'Ruang Konferensi B',
                'kapasitas' => 20,
                'lokasi' => 'Lantai 2',
                'deskripsi' => 'Proyektor, AC, Sound System, WiFi'
            ],
            [
                'nama' => 'Ruang Diskusi C',
                'kapasitas' => 6,
                'lokasi' => 'Lantai 1',
                'deskripsi' => 'TV LED, AC, WiFi'
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}