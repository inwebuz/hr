<?php

namespace App\Http\Controllers\Voyager;

use App\Attribute;
use App\AttributeValue;
use App\Helpers\Helper;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use const JSON_UNESCAPED_UNICODE;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;

class VoyagerProductController extends VoyagerBaseController
{
    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
            $model = $model->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $data = $model->withTrashed()->findOrFail($id);
        } else {
            $data = $model->findOrFail($id);
        }

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();
        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        event(new BreadDataUpdated($dataType, $data));

        $redirect = redirect()->route("voyager.{$dataType->slug}.edit", ['id' => $data->id]);

        // if (auth()->user()->can('browse', app($dataType->model_name))) {
        //     $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        // } else {
        //     $redirect = redirect()->back();
        // }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated')." {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    public function attributesEdit(Request $request, Product $product)
    {
        // Check permission
        $this->authorize('edit', $product);

        $attributes = Attribute::all();
        $attributeValueIds = $product->attributeValues()->pluck('attribute_value_id')->toArray();

        return Voyager::view('voyager::products.edit-attributes', compact('product', 'attributes', 'attributeValueIds'));
    }

    public function attributesUpdate(Request $request, Product $product)
    {
        // Check permission
        $this->authorize('edit', $product);

        $attributes = $request->input('attributes', []);

        // product attributes
        $productAttributes = [];
        foreach($attributes as $key => $attribute) {
            $productAttributes[$key] = [
                'used_for_variations' => (isset($attribute['used_for_variations']) && $attribute['used_for_variations']) ? 1 : 0,
            ];
        }
        $product->attributes()->sync($productAttributes);

        // product attribute values
        $productAttributeValues = [];
        foreach($attributes as $attribute) {
            $productAttributeValues = array_merge($productAttributeValues, $attribute['values']);
        }
        $product->attributeValues()->sync($productAttributeValues);

        $product->touch();

        return redirect()->back()->with([
            'message'    => 'Атрибуты сохранены',
            'alert-type' => 'success',
        ]);
    }
}
