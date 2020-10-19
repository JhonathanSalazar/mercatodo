<?php


namespace App\Classes;

use App\Models\Order;
use http\Client\Request;

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
            'returnUrl' => route('payments.show', $order),
            'ipAddress' => \Request::ip(),
            'userAgent' => \Request::header('User-Agent'),
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
