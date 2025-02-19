<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirestoreController extends Controller
{
    protected $firestore;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(config('services.firebase.credentials'));
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $this->firestore = $firebase->firestore();
    }

    public function addData()
    {
        $collection = $this->firestore->collection('your-collection-name');
        $document = $collection->newDocument();
        $document->set([
            'field1' => 'value1',
            'field2' => 'value2',
        ]);

        return response()->json(['message' => 'Data added successfully']);
    }
}
