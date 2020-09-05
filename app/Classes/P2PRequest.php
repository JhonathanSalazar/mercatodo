<?php


namespace App\Classes;


use Illuminate\Http\Request;

class P2PRequest
{

    private $payerData = [];
    private $paymentData = [];


    public function __construct(Request $request)
    {

        /*
         | -------------------------------
         | Payer data preparation
         | -------------------------------
         */
        $this->payerData['name'] = $request->get('payer_name');
        $this->payerData['surname'] = $request->get('payer_name');
        $this->payerData['email'] = $request->get('payer_email');
        $this->payerData['documentType'] = $request->get('payer_documentType');
        $this->payerData['document'] = $request->get('payer_document');
        $this->payerData['mobile'] = $request->get('payer_phone');
        $this->payerData['address'] = [
            'street' => $request->get('shipping_address'),
            'city' => $request->get('shipping_city'),
            'state' => $request->get('shipping_state'),
            'postalCode' => $request->get('shipping_postal'),
            'country' => 'CO',
            'phone' => $request->get('payer_phone'),
        ];

        /*
         | -------------------------------
         | Payment data preparation
         | -------------------------------
         */
//        $this->paymentData['reference'] =
    }

    public function RedirectionRequest()
    {
        $p2pRequest = [
            'locale' => 'es_CO',
            'payer' => $this->payerData,
        ];
    }

}
