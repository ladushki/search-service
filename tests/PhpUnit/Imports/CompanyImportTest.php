<?php


namespace App\PhpUnit\Imports;


use App\Company;
use App\Imports\CompanyImport;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CompanyImportTest extends TestCase
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
        $import = new CompanyImport();
        $mapped = $import->map($this->row);
        $this->assertEquals(['name' => "Company"], $mapped);
    }

    public function testImportSuccesfull()
    {
        $import = new CompanyImport();
        $imported = $import->import($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals( 'Company', $imported->result->name);
    }

    public function testImportFails()
    {
        $import = new CompanyImport();
        $imported = $import->import([]);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
    }
}