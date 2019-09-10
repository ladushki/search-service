<?php


namespace App\PhpUnit\Imports;

use App\Imports\TransmissionTypeImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TransmissionTypeImportTest extends TestCase
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
        $import = new TransmissionTypeImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['name' => "manual"], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import   = new TransmissionTypeImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals('manual', $imported->result->name);
    }

    public function testImportFails()
    {
        $import   = new TransmissionTypeImport();
        $imported = $import->import(['name' => '']);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}