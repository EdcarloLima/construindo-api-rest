<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /*
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @param Request $request
     * @return ProductCollection
     */
    public function index(Request $request)
    {
        $products = $this->product;

        if ($request->has('conditions')) {
            $expressions = explode(';',$request->get('conditions'));
            foreach ($expressions as $ex) {
                $exp = explode('=',$ex);
                $products = $products->where($exp[0],$exp[1]);
            }
        }

        if ($request->has('fields')) {
            $fields = $request->get('fields');
            $products = $products->selectRaw($fields);
            //return response()->json($fields);
        }

        //return response()->json($products);
        return new ProductCollection($products->paginate(10));
    }

    /*
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @param int $id
     * @return ProductResource
     */
    public function show(int $id)
    {
        $product = $this->product->find($id);
        //return response()->json($product);
        return new ProductResource($product);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $product = $this->product->create($data);

        return response()->json($product);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        // validar id no corpo da requisição
        $data = $request->all();
        $product = $this->product->find($data['id']);
        $product->update($data);

        return response()->json($product);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        $product = $this->product->find($id);
        $name = $product->name;
        $product->delete();

        return response()->json(['data' => ['msg' => "Produto $name excluído com sucesso!"]]);
    }
}
