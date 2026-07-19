<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentUpdated
{
    use Dispatchable, SerializesModels;

    public $contentType; // 'materi', 'tugas', 'kuis'
    public $action;      // 'created', 'updated', 'deleted'
    public $contentId;
    public $kelasIds;    // Array of kelas_id that are affected
    public $data;        // Additional data

    /**
     * Create a new event instance.
     */
    public function __construct($contentType, $action, $contentId, $kelasIds = [], $data = [])
    {
        $this->contentType = $contentType;
        $this->action = $action;
        $this->contentId = $contentId;
        $this->kelasIds = is_array($kelasIds) ? $kelasIds : [$kelasIds];
        $this->data = $data;
    }
}
