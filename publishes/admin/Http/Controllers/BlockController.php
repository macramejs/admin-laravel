<?php

namespace Admin\Http\Controllers;

use Admin\Http\Indexes\BlockIndex;
use Admin\Http\Resources\BlockResource;
use Admin\Http\Resources\StoredResource;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController
{
    /**
     * Page index page.
     *
     * @param  Page $block
     * @return Page
     */
    public function items(Request $request, BlockIndex $index)
    {
        return $index->items(
            $request,
            Block::query()
        );
    }

    /**
     * Show the Block.
     *
     * @param  Block         $block
     * @return BlockResource
     */
    public function show(Block $block)
    {
        return BlockResource::make($block);
    }

    /**
     * Update the Block.
     *
     * @param  Request       $request
     * @param  Block         $block
     * @return BlockResource
     */
    public function update(Request $request, Block $block)
    {
        $validated = $request->validate([
            'name'    => 'sometimes|string',
            'content' => 'array',
        ]);

        $block->update($validated);

        return BlockResource::make($block);
    }

    /**
     * Store a new Block.
     *
     * @param  Request       $request
     * @return BlockResource
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $block = Block::make($validated);

        $block->creator_id = $request->user()->id;

        $block->save();

        return new StoredResource($block);
    }

    /**
     * Destroy the given Block.
     *
     * @param  Request $request
     * @param  Block   $block
     * @return void
     */
    public function destroy(Request $request, Block $block)
    {
        $block->delete();

        return response()->noContent();
    }
}
