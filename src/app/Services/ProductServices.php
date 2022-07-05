<?php

namespace App\Services;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceFull;
use App\Models\Product;

/**
 * Class Product.
 */
class ProductServices
{

    function findAll(?string $category = null)
    {


        if (empty($category)) {
            $products = Product::all();
        } else {
            $products = Product::
            where('category', $category)
                ->get();
        }
        foreach ($products as &$product) {
            $product['price_with_VAT'] = $this->priceVAT($product['price'], $product['VAT']);
        }

        return ProductResourceFull::collection($products);
        //return Product::all();
    }

    function findOne(int $id, ?bool $full = false)
    {
        $data_product = Product::
        where('id', $id)
            ->get();

        $data_product[0]['price_with_VAT'] = $this->priceVAT($data_product[0]['price'], $data_product[0]['VAT']);

        if (!empty($full)) {
            return ProductResourceFull::collection($data_product);
        }
        return ProductResource::collection($data_product);
    }

    public function create(ProductStoreRequest $request)
    {
        $createdProduct = Product::create($request->validated());
        return new ProductResource($createdProduct);
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        $updateProduct = Product::where('id', $id)->update($request->validated());
        return $updateProduct;

    }

    private function priceVAT($price, $vat)
    {
        $priceVAT = ($price) + (($price * $vat) / 100);
        $priceVAT = round($priceVAT, 2);
        return $priceVAT;
    }
}
