<?php


namespace App\PhpUnit\Imports;

use App\Imports\OwnerImport;
use App\Imports\TransmissionTypeImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OwnerImportTest extends TestCase
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
        $import = new OwnerImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['full_name' => 'Rachel Smiley', 'profession' => 'Mathematician', 'company_id'=>1], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import = new OwnerImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals( 'Rachel Smiley', $imported->result->full_name);
        $this->assertEquals( 'Mathematician', $imported->result->profession);
        $this->assertEquals( 'Company', $imported->result->company->name);
    }

    public function testImportFails()
    {
        $import = new TransmissionTypeImport();
        $imported = $import->import(['full_name'=>'']);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}