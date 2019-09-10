<?php


namespace App\PhpUnit\Imports;

use App\Imports\FuelTypeImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FuelTypeImportTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->row = [
            "A" => "RS014SR",
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
            "L" => 4.0,
        ];
    }

    public function testMap()
    {
        $import = new FuelTypeImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['name' => "petrol"], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import   = new FuelTypeImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals('petrol', $imported->result->name);
    }

    public function testImportFails()
    {
        $import   = new FuelTypeImport();
        $imported = $import->import(['name' => '']);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}