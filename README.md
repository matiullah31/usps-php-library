# usps-php-library for merchandise-return-service-label-api
usps scane base  shipping label 

```
require_once './vendor/autoload.php';

```

```

\Usps\lib\Usps::setApiUserName('UspsUserName');
\Usps\lib\Usps::setApiPassword('UspsPassword');
\Usps\lib\Usps::setApiPermit('UspsPermit');

```

```

$from_address = array(
	'name' => "mati ullah",
	'email' => "mati_ullah31@yahoo.com",
	'address1' => '1629 North',
	'address2' => "4th floor",
	'city' => "Jacksonville",
	'zip1' => '32206',
	'state' => 'FL',
);


```

```

$to_address = array(
	'name' => "mobile and wireless",
	'email' => "customersupport@mobile.com",
	'address1' => '2675 East',
	'address2' => "",
	'city' => "Brooklyn",
	'zip1' => '11235',
	'state' => 'NY',
);

```

```

$xml = \Usps\lib\Shipment::create(array(
			'from_address' => $from_address,
			'to_address'   => $to_address,
			'email'=>false,
			'path'=>__DIR__
			)
		);

echo "<pre>";print_r($xml);exit;

```
