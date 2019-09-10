<?php


namespace App\Functional\Api\V1\Controllers;


use App\Api\V1\Controllers\ImportController;
use App\Exceptions\InvalidContentException;
use App\Handlers\ImportVehicleHandler;
use App\Imports\VehicleImport;
use Illuminate\Support\Facades\Storage;
use Mockery;
use App\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ImportControllerTest extends TestCase
{
    use DatabaseMigrations;


    public function tearDown():void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test404()
    {
        $expected = json_decode('{"error":{"message":"404 Not Found","status_code":404}}', true);
        $this->get('api/import-vehicle', [])->assertExactJson($expected);
    }

    public function test_wrong_file()
    {
        Storage::fake('local');
        $filename = Storage::disk('local')->path('vehicles1.csv');
        config()->set('api.file', $filename);

        $service          = Mockery::mock(VehicleImport::class);
        $object = new ImportVehicleHandler($service);
        $this->expectException(InvalidContentException::class);
        $this->invokeMethod($object, 'load', ['filename' =>$filename]);
    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}