<?php namespace App\Http\Controllers\Forum;

use Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use GameserverApp\Transformers\Forum\CategoryTransformer;
use Riari\Forum\Frontend\Events\UserViewingCategory;
use Riari\Forum\Frontend\Events\UserViewingIndex;

class CategoryController extends BaseController
{
    /**
     * GET: Return an index of categories view (the forum index).
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->api('category.index')
                           ->parameters(['where'    => ['category_id' => 0],
                                         'orderBy'  => 'weight',
                                         'orderDir' => 'asc',
                                         'with'     => [
                                             'categories',
                                             'threads',
                                             'parent'
                                         ]
                           ])
                           ->get();

        $categories = CategoryTransformer::transformMultiple($categories);

        event(new UserViewingIndex);

        return view('forum::category.index', compact('categories'));
    }

    /**
     * GET: Return a category view.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $category = $this->api('category.fetch', $request->route('category'))->parameters([
            'with' => [
                'categories',
                'threads',
                'parent'
            ]
        ])->get();

        $category = CategoryTransformer::transform($category);

        $categories = [];
        if (Gate::allows('moveCategories')) {
            $categories = $this->api('category.index')->parameters([
                'where' => [
                    'category_id' => 0
                ]
            ])->get();
        }

        $categories = CategoryTransformer::transformMultiple($categories);

        $threads = $category->threadsPaginated;

        return view('forum::category.show', compact('categories', 'category', 'threads'));
    }

    /**
     * POST: Store a new category.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $category = $this->api('category.store')->parameters($request->all())->post();
        $category = CategoryTransformer::transform($category);

        Forum::alert('success', 'categories.created');

        return redirect(Forum::route('category.show', $category));
    }

    /**
     * PATCH: Update a category.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $action = $request->input('action');

        $category = $this->api("category.{$action}", $request->route('category'))->parameters($request->all())->patch();
        $category = CategoryTransformer::transform($category);

        Forum::alert('success', 'categories.updated', 1);

        return redirect(Forum::route('category.show', $category));
    }

    /**
     * DELETE: Delete a category.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $this->api('category.delete', $request->route('category'))->parameters($request->all())->delete();

        Forum::alert('success', 'categories.deleted', 1);

        return redirect(config('forum.routing.prefix'));
    }
}
