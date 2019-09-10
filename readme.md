
## Installation

1. run `composer install`;
2. run `php artisan migrate`;

Once the project creation procedure will be completed, run the `php artisan migrate` command to install the required tables.

## Usage

## Main Features
* imports csv file from local storage
* api for vehicles & search

### Controllers

You don't have to worry about authentication and password recovery anymore. I created four controllers you can find in the `App\Api\V1\Controllers` for those operations.

For each controller there's an already setup route in `routes/api.php` file:

* `GET api/import`, imports data from csv;
* `GET api/vehicles`, all vehicles;
* `GET api/vehicles?owner=Sally`, filter/search by owner;
* `GET api/vehicles?license_plate=12`, filter/search by plate;
* `GET api/vehicles?year_sort=desc`, sort by year;
