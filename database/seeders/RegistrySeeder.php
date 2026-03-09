<?php

namespace Database\Seeders;

use App\Models\Registry;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegistrySeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $registries = [
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-001',
                'date' => '2024-01-15',
                'sender' => 'ABC Corporation',
                'recipient' => 'Our Company',
                'subject' => 'Quarterly report request',
                'remarks' => 'Follow up needed by end of month',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-002',
                'date' => '2024-01-20',
                'sender' => 'Our Company',
                'recipient' => 'XYZ Suppliers',
                'subject' => 'Invoice #12345 payment',
                'remarks' => 'Payment pending approval',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-003',
                'date' => '2024-02-05',
                'sender' => 'Legal Department',
                'recipient' => 'Our Company',
                'subject' => 'Contract renewal - Office lease',
                'remarks' => 'Review with legal team',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-004',
                'date' => '2024-02-10',
                'sender' => 'HR Department',
                'recipient' => 'All Managers',
                'subject' => 'New employee handbook',
                'remarks' => 'Distribute to all staff',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-005',
                'date' => '2024-02-15',
                'sender' => 'Our Company',
                'recipient' => 'Client A',
                'subject' => 'Project proposal - Website redesign',
                'remarks' => 'Waiting for client feedback',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-001',
                'date' => '2024-01-15',
                'sender' => 'ABC Corporation',
                'recipient' => 'Our Company',
                'subject' => 'Quarterly report request',
                'remarks' => 'Follow up needed by end of month',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-002',
                'date' => '2024-01-20',
                'sender' => 'Our Company',
                'recipient' => 'XYZ Suppliers',
                'subject' => 'Invoice #12345 payment',
                'remarks' => 'Payment pending approval',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-003',
                'date' => '2024-02-05',
                'sender' => 'Legal Department',
                'recipient' => 'Our Company',
                'subject' => 'Contract renewal - Office lease',
                'remarks' => 'Review with legal team',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-004',
                'date' => '2024-02-10',
                'sender' => 'HR Department',
                'recipient' => 'All Managers',
                'subject' => 'New employee handbook',
                'remarks' => 'Distribute to all staff',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-005',
                'date' => '2024-02-15',
                'sender' => 'Our Company',
                'recipient' => 'Client A',
                'subject' => 'Project proposal - Website redesign',
                'remarks' => 'Waiting for client feedback',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-001',
                'date' => '2024-01-15',
                'sender' => 'ABC Corporation',
                'recipient' => 'Our Company',
                'subject' => 'Quarterly report request',
                'remarks' => 'Follow up needed by end of month',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-002',
                'date' => '2024-01-20',
                'sender' => 'Our Company',
                'recipient' => 'XYZ Suppliers',
                'subject' => 'Invoice #12345 payment',
                'remarks' => 'Payment pending approval',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-003',
                'date' => '2024-02-05',
                'sender' => 'Legal Department',
                'recipient' => 'Our Company',
                'subject' => 'Contract renewal - Office lease',
                'remarks' => 'Review with legal team',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-004',
                'date' => '2024-02-10',
                'sender' => 'HR Department',
                'recipient' => 'All Managers',
                'subject' => 'New employee handbook',
                'remarks' => 'Distribute to all staff',
                'attachments' => json_encode([]),
            ],
            [
                'user_id' => $user->id,
                'reference_no' => 'REG-005',
                'date' => '2024-02-15',
                'sender' => 'Our Company',
                'recipient' => 'Client A',
                'subject' => 'Project proposal - Website redesign',
                'remarks' => 'Waiting for client feedback',
                'attachments' => json_encode([]),
            ],
        ];

        foreach ($registries as $registry) {
            Registry::create($registry);
        }
    }
}
