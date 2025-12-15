<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Category::factory()->createMany([
            [
                'name' => 'Routers',
                'slug' => 'routers'
            ],
            [
                'name' => 'Switches',
                'slug' => 'switches'
            ],
            [
                'name' => 'Firewalls',
                'slug' => 'firewalls'
            ],
            [
                'name' => 'Access Points',
                'slug' => 'access-points'
            ],
            [
                'name' => 'Cables & Connectors',
                'slug' => 'cables-connectors'
            ],
            [
                'name' => 'Network Adapters',
                'slug' => 'network-adapters'
            ],
            [
                'name' => 'Modems',
                'slug' => 'modems'
            ],
            [
                'name' => 'Network Storage',
                'slug' => 'network-storage'
            ],
            [
                'name' => 'VoIP Phones',
                'slug' => 'voip-phones'
            ],
            [
                'name' => 'Network Tools',
                'slug' => 'network-tools'
            ],
        ]);
    }
}
