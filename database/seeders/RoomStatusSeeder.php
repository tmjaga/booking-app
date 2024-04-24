<?php

namespace Database\Seeders;

use App\Models\RoomStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomStatuses = [
            [
                'status' => 'Occupied',
                'status_description' => 'The room is currently being used by a guest.'
            ],
            [
                'status' => 'Vacant',
                'status_description' => 'The room is available and ready for occupancy.'
            ],
            [
                'status' => 'Reserved',
                'status_description' => 'The room has been booked for a guest who has not yet checked in.'
            ],
            [
                'status' => 'Out of Order',
                'status_description' => 'The room is temporarily unavailable for occupancy due to maintenance, repairs, or cleaning.'
            ],
            [
                'status' => 'Dirty',
                'status_description' => 'The room has been vacated by the previous guest but has not yet been cleaned and prepared for the next guest.'
            ],
            [
                'status' => 'Inspected',
                'status_description' => 'The room has been cleaned and inspected by housekeeping and is ready for occupancy.'
            ],
            [
                'status' => 'Blocked',
                'status_description' => 'The room is not available for booking due to specific reasons, such as being reserved for a special guest, undergoing renovation, or being held for maintenance purposes.'
            ],
            [
                'status' => 'Do Not Disturb',
                'status_description' => 'The guest has requested not to be disturbed by housekeeping or hotel staff.'
            ],
            [
                'status' => 'Checked-Out',
                'status_description' => 'The previous guest has checked out of the room, and it is now ready to be cleaned and prepared for the next guest.'
            ],
            [
                'status' => 'Pending Maintenance',
                'status_description' => 'The room requires maintenance or repairs before it can be made available for occupancy.'
            ]
        ];

        RoomStatus::truncate();

        foreach ($roomStatuses as $roomStatus) {
            RoomStatus::create($roomStatus);
        }
    }
}
