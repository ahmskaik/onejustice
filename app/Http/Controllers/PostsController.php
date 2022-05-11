<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\PostModel;
use Illuminate\Http\Request;

class PostsController extends SiteController
{
    public function show(Request $request, $id, $category = '', $slug = '')
    {
        $post = PostModel::Published()->Language(parent::$data['active_language_id'])->find($id);
        if (!$post)
            return redirect()->to(route('site.home'));

        $tags = json_decode($post->tags);
        parent::$data["title"] = $post->title;
        parent::$data["post"] = $post;
        parent::$data["related_posts"] = PostModel::query()
            ->Published()
            ->Language(parent::$data['active_language_id'])
            ->when($tags, function ($query) use ($tags) {
                $query->where(function ($q) use ($tags) {
                    foreach ($tags as $tag)
                        $q->whereJsonContains("tags", trim($tag));
                });
            })
            ->latest()
            ->with(['category', 'type'])
            ->take(6)
            ->get();

        parent::$data["posts_may_like"] = PostModel::Published()->Language(parent::$data['active_language_id'])
            ->where('category_id', $post->category_id)->where('id', '!=', $post->id)->orderby('date', 'desc')->with(['category', 'type'])->take(6)->get();

        $post->increment('views');

        return view('site.post.details', parent::$data);
    }

    public function getPostsByCategory(Request $request, $category)
    {
        $category = CategoryModel::with(['activeSubCategories'])->where('slug', $category)->first();

        if (!$category)
            return redirect()->to(route('site.home'));

        parent::$data["title"] = $category->name->{parent::$data['locale']} ?? $category->name->{parent::$data['fallbackLanguage']};
        parent::$data["category"] = $category;

        $active_language_id = parent::$data['active_language_id'];

        $main_post = parent::$data["main_post"] = PostModel::query()
            ->Published()
            ->Language($active_language_id)
            ->Featured()
            ->where('category_id', $category->id)
            ->orderby('date', 'desc')
            ->first();

        parent::$data["featured_posts"] = PostModel::query()
            ->with(['category', 'type'])
            ->Published()
            ->Language($active_language_id)
            ->Featured()
            ->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                    ->when(count($category->activeSubCategories), function ($query) use ($category) {
                        $query->orWhereIn('id', $category->activeSubCategories->pluck('id'));
                    });
            })
            ->when(!is_null($main_post), function ($query) use ($main_post) {
                $query->where('id', '!=', $main_post->id);
            })
            ->orderby('date', 'desc')
            ->take(2)
            ->get();


        $limit = 8;
        parent::$data["posts"] = PostModel::query()
            ->with(['category', 'type'])
            ->Published()
            //  ->Featured()
            ->Language($active_language_id)
            ->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                    ->when(count($category->activeSubCategories), function ($query) use ($category) {
                        $query->orWhereIn('category_id', $category->activeSubCategories->pluck('id'));
                    });
            })
            ->orderby('date', 'desc')
            ->when(!is_null($main_post), function ($query) use ($main_post) {
                $query->where('id', '!=', $main_post->id);
            })
            ->whereNotIn('id', parent::$data["featured_posts"]->pluck('id'))
            ->paginate($limit);

        parent::$data["hasMore"] = 0;
        parent::$data["nextPage"] = parent::$data["posts"]->nextPageUrl();
        $page = $request->input("page") ? (int)$request->input("page") : 1;

        if (parent::$data["posts"]->total() > ($page * $limit))
            parent::$data["hasMore"] = 1;


        if ($request->ajax()) {
            $data = view("site.post.postsListPart",
                [
                    "posts" => parent::$data["posts"],
                    "category" => parent::$data["category"],
                    "locale" => parent::$data["locale"],
                    'fallbackLanguage' => parent::$data['fallbackLanguage'],
                ])->render();
            return response(
                [
                    "status" => true,
                    "count" => parent::$data["posts"]->total(),
                    "nextPage" => parent::$data["nextPage"],
                    "hasMore" => parent::$data["hasMore"],
                    "data" => $data
                ], 200);
        }
        return view('site.post.list', parent::$data);
    }
}
