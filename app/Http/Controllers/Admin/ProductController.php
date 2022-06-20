<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::with(['categories', 'tags', 'media'])->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        return view('admin.products.create', compact('categories', 'tags'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->categories()->sync($request->input('categories', []));
        $product->tags()->sync($request->input('tags', []));
        foreach ($request->input('photo', []) as $file) {
            $product->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $product->id]);
        }

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        $product->load('categories', 'tags');

        $title = $product->name;

        $icon = 'fa fa-arrow-right';

        $action = route('admin.products.update', [$product->id]);

        $method = 'PUT';

        $fields = array();
        $keys = array(
            'id', 'name', 'description', 'price', 'categories', 'tags',
        );
        foreach($keys as $key)
        {
            $fields[$key] = array(
                'name' => $key,
                'value' => $product->$key,
                'label' => trans("cruds.product.fields.$key"),
                'type' => 'text',
                'columns' => 4,
                'required' => TRUE,
            );
        }

        $fields['description']['columns'] = 12;
        
        $fields['description']['required'] = FALSE;

        return view('admin.generic.edit', compact('title', 'icon', 'fields', 'action', 'method'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $product->categories()->sync($request->input('categories', []));
        $product->tags()->sync($request->input('tags', []));
        if (count($product->photo) > 0) {
            foreach ($product->photo as $media) {
                if (!in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $product->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->load('categories', 'tags');

        $title = $product->name;
        //trans('global.show') . ' ' . trans('cruds.product.title');

        $buttons = array(
                        'back_to_list' => array(
                                        'href' => route('admin.products.index'),
                                        'label' => trans('global.back_to_list'),
                                        'icon' => 	'fa fa-arrow-left',
                                        'class' => "btn btn-xs btn-info",
                        ),

                        'edit' => array(
                                        'href' => route('admin.products.edit', $product->id),
                                        'label' => trans('global.edit'),
                                        'icon' => 	'fa fa-pencil',
                                        'class' => 'btn btn-xs btn-warning',
                        ),
                        'delete' => array(
                                        'href' => route('admin.products.destroy', $product->id),
                                        'label' => trans('global.delete'),
                                        'icon' => 	'fa fa-trash',
                                        'class' => 'btn btn-xs btn-danger',
                                        'method' => 'delete',
                                        'confirm' => trans('global.areYouSure'),
                                        'title' => trans('global.confirm'),
                        ),

        );
        $fields = array();
        $keys = array(
            'id', 'name', 'description', 'price', 'categories', 'tags',
        );
        foreach($keys as $key)
        {
            $fields[$key] = array(
                'name' => $key,
                'value' => $product->$key,
                'label' => trans("cruds.product.fields.$key")
            );
        }

        $fields['categories']['value'] = [];
        foreach ($product->categories as $cat)
            $fields['categories']['value'][] = $cat->name;
        $fields['categories']['value'] = implode(', ', $fields['categories']['value']);
        //dd($fields['categories']['value']);

        $fields['tags']['value'] = [];
        foreach ($product->tags as $tag)
            $fields['tags']['value'][] = $tag->name;
        $fields['tags']['value'] = implode(', ', $fields['tags']['value']);

        return view('admin.generic.show', compact('product',
            'title', 'buttons', 'fields' ));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();
        dd("Hey there!..");

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_create') && Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Product();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
