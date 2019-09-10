<?php


namespace App\PhpUnit\Imports;

use App\Imports\VehicleModelImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicalModelImportTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->row = ["A" => "RS014SR",
            "B" => 2015.0,
            "C" => "Rachel Smiley",
            "D" => "Mathematician",
            "E" => "Company",
            "F" => "blue",
            "G" => "petrol",
            "H" => "manual",
            "I" => "Vauxhall",
            "J" => "Corsa",
            "K" => 5.0,
            "L" => 4.0,];
    }

    public function testMap()
    {
        $import = new VehicleModelImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['name' => 'Corsa', 'manufacturer_id' =>1], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import = new VehicleModelImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals( 'Corsa', $imported->result->name);
        $this->assertEquals( 'Vauxhall', $imported->result->manufacturer->name);
    }

    public function testImportFails()
    {
        $import = new VehicleModelImport();
        $imported = $import->import(['name'=>'']);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}