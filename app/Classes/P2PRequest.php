<?php


namespace App\Classes;


use App\Order;

class P2PRequest
{

    /**
     * @var array
     */
    private $p2pRequest;

    public function __construct(Order $order)
    {
        $this->p2pRequest = [
            'payment' => [
                'reference' => $order->order_reference,
                'description' => 'Payment of Mercatodo',
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->grand_total,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://mercatodo.test/',
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];
    }

    /** Return the requiered request to create a payment with PlaceToPay Redirection
     * @return array
     */
    public function create()
    {
        return $this->p2pRequest;
    }

}
