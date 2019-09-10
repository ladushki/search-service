<?php

namespace App\PhpUnit\Imports;

use App\Interactions\CreateCompany;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCompanyTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->row = ['name' => 'Company',];
    }

    public function testCreate()
    {
        $data = CreateCompany::run($this->row);
        $this->assertEquals( 'Company', $data->result->name);
    }

    public function testImportSuccesfull()
    {
        $imported = CreateCompany::run($this->row);
        $this->assertTrue($imported->valid);
        $this->assertEmpty($imported->errors);
        $this->assertNotEmpty($imported->result);

        $this->assertEquals( 'Company', $imported->result->name);
    }

    public function testImportFails()
    {
        $this->row['name'] = '';
        $imported = CreateCompany::run($this->row);
        $this->assertFalse($imported->valid);
        $this->assertNotEmpty($imported->errors);
        $this->assertEquals(1, count($imported->errors));
    }
}