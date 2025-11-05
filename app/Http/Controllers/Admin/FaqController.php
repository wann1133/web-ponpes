<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::ordered()->get();

        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder();

        Faq::create($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $faq->sort_order;

        $faq->update($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('status', 'FAQ berhasil dihapus.');
    }

    private function nextSortOrder(): int
    {
        return (int) Faq::max('sort_order') + 10;
    }
}
