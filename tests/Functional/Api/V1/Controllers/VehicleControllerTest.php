<?php


namespace App\Functional\Api\V1\Controllers;

use App\Company;
use App\FuelType;
use App\Manufacturer;
use App\Owner;
use App\TestCase;
use App\TransmissionType;
use App\Vehicle;
use App\VehicleModel;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicleControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->createVehicle();
    }

    public function test404()
    {
        $expected = json_decode('{"error":{"message":"404 Not Found","status_code":404}}', true);
        $this->get('api/vehicle', [])->assertExactJson($expected);
    }

    public function testWillShowCorrectContentWithoutFilter()
    {
        $expected = json_decode(
            '[{"colour":"red","fuel_type":"dizel","license_plate":"12232423pp", "manufacturer":"Reno","model":"Clio","num_doors":"5","num_seats":"5","owner_company":"Test","owner_name":"Ted Red","owner_profession":"teacher","transmission":"auto","year_of_purchase":"2019"}]');
        $this->get('api/vehicles', [])->assertExactJson($expected);
    }

    public function testWillShowCorrectContentWithFilter()
    {
        $expected = json_decode('[{"colour":"red","fuel_type":"dizel","license_plate":"12232423pp","manufacturer":"Reno","model":"Clio","num_doors":"5","num_seats":"5","owner_company":"Test","owner_name":"Ted Red","owner_profession":"teacher","transmission":"auto","year_of_purchase":"2019"}]');

        $this->get('api/vehicles?license_plate=5', [])->assertExactJson([]);
        $this->get('api/vehicles?license_plate=12232', [])->assertExactJson($expected);
        $this->get('api/vehicles?owner=ted', [])->assertExactJson($expected);
        $this->get('api/vehicles?owner=ted&license_plate=12232', [])->assertExactJson($expected);
        $this->get('api/vehicles?owner=larissa', [])->assertExactJson([]);
        $this->get('api/vehicles?year=2000', [])->assertExactJson([]);
        $this->get('api/vehicles?year=2019', [])->assertExactJson($expected);

        $this->createVehicle(['plate' => '1', 'year' => 2000]);

        $this->get('api/vehicles?year=2019', [])->assertExactJson($expected)->assertJsonCount(1);
        $this->get('api/vehicles', [])->assertJsonCount(2);
        $this->get('api/vehicles?license_plate=1', [])->assertJsonCount(2);
    }

    private function createVehicle($data = ['plate' => '12232423pp', 'year' => 2019]): void
    {
        $company = new Company([
            'name' => 'Test',
        ]);
        $company->save();

        $fuelType = new FuelType([
            'name' => 'dizel',
        ]);
        $fuelType->save();

        $ttType = new TransmissionType([
            'name' => 'auto',
        ]);
        $ttType->save();

        $manufacturer = new Manufacturer([
            'name' => 'Reno',
        ]);
        $manufacturer->save();

        $model = new VehicleModel([
            'name'            => 'Clio',
            'manufacturer_id' => $manufacturer->id,
        ]);
        $model->save();

        $owner = new Owner([
            'full_name'  => 'Ted Red',
            'profession' => 'teacher',
            'company_id' => $company->id,
        ]);
        $owner->save();

        $vehicle = new Vehicle([
            'license_plate'        => $data['plate'],
            'owner_id'             => $owner->id,
            'password'             => '123456',
            'year_of_purchase'     => $data['year'],
            'color'                => 'red',
            'seats'                => '5',
            'doors'                => '5',
            'fuel_type_id'         => $fuelType->id,
            'transmission_type_id' => $ttType->id,
            'vehicle_model_id'     => $model->id,
        ]);

        $vehicle->save();
    }
}
