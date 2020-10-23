<?php


namespace App\Classes;

use App\Entities\DatabaseStorageModel;
use Darryldecode\Cart\CartCollection;

class DatabaseStorage
{
    /**
     * @param $key
     * @return mixed
     */
    public function has($key)
    {
        return DatabaseStorageModel::find($key);
    }

    /**
     * @param $key
     * @return array|CartCollection
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return new CartCollection(DatabaseStorageModel::find($key)->cart_data);
        } else {
            return [];
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function put($key, $value)
    {
        if ($row = DatabaseStorageModel::find($key)) {
            // update
            $row->cart_data = $value;
            $row->save();
        } else {
            DatabaseStorageModel::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }
    }
}
