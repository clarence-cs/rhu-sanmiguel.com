<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Carbon\Carbon;

class PatientCsvSeeder extends Seeder
{
    public function run()
    {
        $csvFilePath = 'C:/database/patients.csv';

        if (!file_exists($csvFilePath)) {
            $this->command->error("Could not find the CSV file at: {$csvFilePath}. Make sure you saved it as a .csv!");
            return;
        }

        $csvFile = fopen($csvFilePath, 'r');
        $firstLine = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            
            // Skip the header row
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            // Skip completely empty rows
            if (empty(array_filter($data))) {
                continue;
            }

            // Format the date (DD/MM/YYYY to YYYY-MM-DD)
            $regDate = null;
            if (!empty($data[9])) {
                try {
                    $regDate = Carbon::createFromFormat('d/m/Y', $data[9])->format('Y-m-d');
                } catch (\Exception $e) {
                    $regDate = null; 
                }
            }

            // Insert into the database
            Patient::create([
                'patient_id'         => $data[0] ?? null,
                'pin'                => $data[1] ?? null,
                'last_name'          => $data[2] ?? null,
                'first_name'         => $data[3] ?? null,
                'middle_name'        => $data[4] ?: null, 
                'suffix'             => $data[5] ?: null,
                'sex'                => $data[6] ?: null,
                'member_type'        => $data[7] ?: null,
                'contact_no'         => $data[8] ?: null,
                'registration_date'  => $regDate,
            ]);
        }

        fclose($csvFile);
        $this->command->info('Success! Patient data imported from C:\database\patients.csv');
    }
}