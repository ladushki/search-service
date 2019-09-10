<?php

namespace App\PhpUnit\Imports;

use App\Imports\VehicleImport;
use App\Imports\VehicleModelImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicleImportTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->row = ["A" => "RS014SR",
            "B" => 2015,
            "C" => "Rachel Smiley",
            "D" => "Mathematician",
            "E" => "Company",
            "F" => "blue",
            "G" => "petrol",
            "H" => "manual",
            "I" => "Vauxhall",
            "J" => "Corsa",
            "K" => 5,
            "L" => 4];
    }

    public function testMap()
    {
        $import = new VehicleImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['license_plate' => 'RS014SR',
                             'owner_id' =>1,
                             'color' =>'blue',
                             'fuel_type_id' =>1,
                             'transmission_type_id' =>1,
                             'vehicle_model_id' =>1,
                             'seats' =>5,
                             'doors' =>4,
                             'year_of_purchase' =>2015,
            ], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import = new VehicleImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals( 'RS014SR', $imported->result->license_plate);
        $this->assertEquals( 'Rachel Smiley', $imported->result->owner->full_name);
        $this->assertEquals( 'petrol', $imported->result->fuelType->name);
    }

    public function testImportFails()
    {
        $import = new VehicleModelImport();
        $imported = $import->import(['license_plate'=>'']);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}