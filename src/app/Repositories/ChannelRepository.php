<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * All Channels
     * @param $name
     */
    public function all()
    {
        return Channel::all();
    }

    /**
     * Create Channel
     * @param $name
     */
    public function create($name): void
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    /**
     * Update Channel
     * @param $id
     * @param $name
     */
    public function update($id, $name): void
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    /**
     * Delete Channel
     * @param $id
     */
    public function delete($id): void
    {
        Channel::destroy(id);
    }
}
